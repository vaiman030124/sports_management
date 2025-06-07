<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class RazorpayPaymentController extends Controller
{
    /**
     * Display a listing of Razorpay payments.
     */
    public function index()
    {
        $payments = Transaction::where('payment_mode', 'razorpay')->with('user', 'booking')->paginate(20);
        return view('admin.razorpay_payments.index', compact('payments'));
    }

    /**
     * Display the specified Razorpay payment.
     */
    public function show(Transaction $transaction)
    {
        if ($transaction->payment_mode !== 'razorpay') {
            abort(404);
        }
        $transaction->load('user', 'booking');
        return view('admin.razorpay_payments.show', compact('transaction'));
    }
}
