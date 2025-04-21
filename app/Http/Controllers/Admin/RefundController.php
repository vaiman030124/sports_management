<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        $refunds = Refund::with(['transaction', 'user'])->paginate(15);
        return view('admin.refunds.index', compact('refunds'));
    }

    public function create()
    {
        return view('admin.refunds.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected,processed'
        ]);

        Refund::create($validated);

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund request created successfully');
    }

    public function show(Refund $refund)
    {
        return view('admin.refunds.show', compact('refund'));
    }

    public function edit(Refund $refund)
    {
        return view('admin.refunds.edit', compact('refund'));
    }

    public function update(Request $request, Refund $refund)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected,processed'
        ]);

        $refund->update($validated);

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund request updated successfully');
    }

    public function destroy(Refund $refund)
    {
        $refund->delete();
        return redirect()->route('admin.refunds.index')
            ->with('success', 'Refund request deleted successfully');
    }
}
