<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::paginate(15);
        return view('admin.membership_plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.membership_plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        MembershipPlan::create($validated);

        return redirect()->route('admin.membership_plans.index')
            ->with('success', 'Membership plan created successfully');
    }

    public function show(MembershipPlan $membershipPlan)
    {
        return view('admin.membership_plans.show', compact('membershipPlan'));
    }

    public function edit(MembershipPlan $membershipPlan)
    {
        return view('admin.membership_plans.edit', compact('membershipPlan'));
    }

    public function update(Request $request, MembershipPlan $membershipPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $membershipPlan->update($validated);

        return redirect()->route('admin.membership_plans.index')
            ->with('success', 'Membership plan updated successfully');
    }

    public function destroy(MembershipPlan $membershipPlan)
    {
        $membershipPlan->delete();
        return redirect()->route('admin.membership_plans.index')
            ->with('success', 'Membership plan deleted successfully');
    }
}
