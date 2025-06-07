<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;
use App\Services\RazorpayService;
use Illuminate\Http\Request;
use Exception;

class RazorpayPaymentController extends Controller
{
    protected $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    /**
     * Initiate Razorpay payment for a booking
     */
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        try {
            \DB::beginTransaction();

            // Create Razorpay order
            $order = $this->razorpayService->createOrder(
                $request->amount,
                'INR',
                'booking_' . $booking->id,
                ['booking_id' => $booking->id, 'user_id' => $booking->user_id]
            );

            // Create a pending transaction record
            $transaction = Transaction::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'amount' => $request->amount,
                'payment_mode' => 'razorpay',
                'payment_reference' => $order->id,
                'status' => 'pending',
                'transaction_date' => now(),
            ]);

            // Update booking payment_id and payment_status to pending
            $booking->update([
                'payment_id' => $transaction->id,
                'payment_status' => 'pending',
            ]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'amount' => $order->amount,
                    'currency' => $order->currency,
                    'receipt' => $order->receipt,
                ],
                'transaction_id' => $transaction->id,
            ]);
        } catch (Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to initiate payment: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Verify Razorpay payment signature and update transaction and booking status
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        try {
            if (!$this->razorpayService->verifyPaymentSignature($attributes)) {
                return response()->json(['success' => false, 'message' => 'Invalid payment signature'], 400);
            }

            // Fetch transaction by razorpay_order_id
            $transaction = Transaction::where('payment_reference', $request->razorpay_order_id)->firstOrFail();

            // Update transaction status to completed and save payment id
            $transaction->update([
                'status' => 'completed',
                'payment_reference' => $request->razorpay_payment_id,
                'transaction_date' => now(),
            ]);

            // Update booking payment_status to paid
            $booking = Booking::findOrFail($transaction->booking_id);
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);

            return response()->json(['success' => true, 'message' => 'Payment verified successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment verification failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Handle Razorpay webhook callbacks
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        $secret = config('services.razorpay.secret');

        try {
            $this->razorpayService->api->utility->verifyWebhookSignature($payload, $signature, $secret);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid webhook signature'], 400);
        }

        $event = json_decode($payload, true);

        if (!$event || !isset($event['event'])) {
            return response()->json(['success' => false, 'message' => 'Invalid webhook payload'], 400);
        }

        $eventType = $event['event'];
        $payloadData = $event['payload'] ?? [];

        switch ($eventType) {
            case 'payment.authorized':
                $payment = $payloadData['payment']['entity'] ?? null;
                if ($payment) {
                    $this->updateTransactionStatus($payment['order_id'], 'authorized', $payment['id']);
                }
                break;

            case 'payment.captured':
                $payment = $payloadData['payment']['entity'] ?? null;
                if ($payment) {
                    $this->updateTransactionStatus($payment['order_id'], 'completed', $payment['id']);
                    $this->updateBookingStatus($payment['order_id'], 'paid', 'confirmed');
                }
                break;

            case 'payment.failed':
                $payment = $payloadData['payment']['entity'] ?? null;
                if ($payment) {
                    $this->updateTransactionStatus($payment['order_id'], 'failed', $payment['id']);
                    $this->updateBookingStatus($payment['order_id'], 'failed', 'pending');
                }
                break;

            default:
                // Ignore other events
                break;
        }

        return response()->json(['success' => true]);
    }

    protected function updateTransactionStatus($orderId, $status, $paymentId)
    {
        $transaction = Transaction::where('payment_reference', $orderId)->first();
        if ($transaction) {
            $transaction->update([
                'status' => $status,
                'payment_reference' => $paymentId,
                'transaction_date' => now(),
            ]);
        }
    }

    protected function updateBookingStatus($orderId, $paymentStatus, $bookingStatus)
    {
        $transaction = Transaction::where('payment_reference', $orderId)->first();
        if ($transaction) {
            $booking = Booking::find($transaction->booking_id);
            if ($booking) {
                $booking->update([
                    'payment_status' => $paymentStatus,
                    'status' => $bookingStatus,
                ]);
            }
        }
    }
}
