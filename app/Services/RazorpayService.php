<?php

namespace App\Services;

use Razorpay\Api\Api;
use Exception;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');
        
        if (!$key || !$secret) {
            throw new Exception('Razorpay API key and secret must be set in config/services.php');
        }

        $this->api = new Api($key, $secret);
    }

    /**
     * Create a Razorpay order
     *
     * @param float $amount Amount in INR (e.g. 100.00)
     * @param string $currency Currency code (default INR)
     * @param string|null $receipt Receipt identifier
     * @param array $notes Additional notes
     * @return \Razorpay\Api\Order
     * @throws Exception
     */
    public function createOrder(float $amount, string $currency = 'INR', ?string $receipt = null, array $notes = [])
    {
        try {
            $orderData = [
                'amount' => intval($amount * 100), // amount in paise
                'currency' => $currency,
                'payment_capture' => 1,
                'notes' => $notes,
            ];

            if ($receipt) {
                $orderData['receipt'] = $receipt;
            }

            return $this->api->order->create($orderData);
        } catch (Exception $e) {
            throw new Exception('Failed to create Razorpay order: ' . $e->getMessage());
        }
    }

    /**
     * Verify payment signature
     *
     * @param array $attributes Attributes from Razorpay payment response
     * @return bool
     * @throws Exception
     */
    public function verifyPaymentSignature(array $attributes)
    {
        try {
            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Fetch payment details by payment ID
     *
     * @param string $paymentId
     * @return \Razorpay\Api\Payment
     * @throws Exception
     */
    public function fetchPayment(string $paymentId)
    {
        try {
            return $this->api->payment->fetch($paymentId);
        } catch (Exception $e) {
            throw new Exception('Failed to fetch payment: ' . $e->getMessage());
        }
    }
}
