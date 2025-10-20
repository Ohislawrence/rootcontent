<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:plans,name',
            'duration' => 'required|string|in:termly,yearly,custom',
            'months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);

        $plan = Plan::create([
            'name' => $request->name,
            'duration' => $request->duration,
            'months' => $request->months,
            'price' => $request->price,
            'description' => $request->description,
            'features' => $request->features ? json_encode($request->features) : null,
            'is_active' => $request->is_active ?? true,
            'is_default' => $request->is_default ?? false,
        ]);

        // If this is set as default, remove default from other plans
        if ($plan->is_default) {
            Plan::where('id', '!=', $plan->id)->update(['is_default' => false]);
        }

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan created successfully.');
    }

    public function show(Plan $plan)
    {
        $subscriptionsCount = $plan->subscriptions()->count();
        $activeSubscriptionsCount = $plan->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->count();

        return view('admin.plans.show', compact('plan', 'subscriptionsCount', 'activeSubscriptionsCount'));
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('plans')->ignore($plan->id),
            ],
            'duration' => 'required|string|in:termly,yearly,custom',
            'months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);

        $plan->update([
            'name' => $request->name,
            'duration' => $request->duration,
            'months' => $request->months,
            'price' => $request->price,
            'description' => $request->description,
            'features' => $request->features ? json_encode($request->features) : null,
            'is_active' => $request->is_active ?? $plan->is_active,
            'is_default' => $request->is_default ?? $plan->is_default,
        ]);

        // If this is set as default, remove default from other plans
        if ($plan->is_default) {
            Plan::where('id', '!=', $plan->id)->update(['is_default' => false]);
        }

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        // Check if plan has active subscriptions
        $activeSubscriptions = $plan->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->exists();

        if ($activeSubscriptions) {
            return redirect()->route('admin.plans.index')
                ->with('error', 'Cannot delete plan with active subscriptions.');
        }

        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan deleted successfully.');
    }

    public function toggleStatus(Plan $plan)
    {
        $plan->update([
            'is_active' => !$plan->is_active
        ]);

        $status = $plan->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Plan {$status} successfully.");
    }

    public function setDefault(Plan $plan)
    {
        // Deactivate all other plans as default
        Plan::where('id', '!=', $plan->id)->update(['is_default' => false]);

        // Set this plan as default
        $plan->update(['is_default' => true]);

        return redirect()->back()
            ->with('success', 'Plan set as default successfully.');
    }
}
