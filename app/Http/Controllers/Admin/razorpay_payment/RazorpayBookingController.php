<?php

namespace App\Http\Controllers\Admin\razorpay_payment;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Court;
use App\Models\Sport;
use App\Models\Slot;
use App\Services\RazorpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RazorpayBookingController extends Controller
{
    protected $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    /**
     * Show the booking creation form with Razorpay payment option
     */
    public function create()
    {
        $users = User::all();
        $courts = Court::all();
        $sports = Sport::all();
        $slots = Slot::all();

        return view('admin.razorpay_payment.create', compact('users', 'courts', 'sports', 'slots'));
    }

    /**
     * Handle booking creation and initiate Razorpay payment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'sport_id' => 'required|exists:sports,id',
            'court_id' => 'required|exists:courts,id',
            'slot_id' => 'required|exists:slots,id',
            'booking_date' => 'required|date',
            'number_of_players' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Create booking with pending payment status
            $booking = Booking::create([
                'user_id' => $validated['user_id'],
                'sport_id' => $validated['sport_id'],
                'court_id' => $validated['court_id'],
                'slot_id' => $validated['slot_id'],
                'booking_date' => $validated['booking_date'],
                'number_of_players' => $validated['number_of_players'],
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create Razorpay order
            $order = $this->razorpayService->createOrder(
                $validated['amount'],
                'INR',
                'booking_' . $booking->id,
                ['booking_id' => $booking->id, 'user_id' => $booking->user_id]
            );

            // Create transaction record with pending status
            $transaction = Transaction::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'amount' => $validated['amount'],
                'payment_mode' => 'razorpay',
                'payment_reference' => $order->id,
                'status' => 'pending',
                'transaction_date' => now(),
            ]);

            // Update booking with payment_id
            $booking->update(['payment_id' => $transaction->id]);

            DB::commit();

            // Return order details for frontend Razorpay payment integration
            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'amount' => $order->amount,
                    'currency' => $order->currency,
                    'receipt' => $order->receipt,
                ],
                'transaction_id' => $transaction->id,
                'booking_id' => $booking->id,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Booking creation failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Verify Razorpay payment and update booking and transaction status
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

            // Update booking payment_status to paid and status to confirmed
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
}
