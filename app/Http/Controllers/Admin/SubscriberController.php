<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::subscribers()->with(['activeSubscription.plan', 'subscriptions.plan']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('school_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->inactive();
            } elseif ($request->status === 'with_subscription') {
                $query->whereHas('activeSubscription');
            } elseif ($request->status === 'without_subscription') {
                $query->whereDoesntHave('activeSubscription');
            }
        }

        // Filter by subscription type
        if ($request->has('subscription_type') && $request->subscription_type != '') {
            if ($request->subscription_type === 'trial') {
                $query->whereHas('activeSubscription', function($q) {
                    $q->whereNotNull('free_access_started_at');
                });
            } elseif ($request->subscription_type === 'paid') {
                $query->whereHas('activeSubscription', function($q) {
                    $q->whereNull('free_access_started_at');
                });
            }
        }

        $subscribers = $query->latest()->paginate(10);

        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function create()
    {
        $plans = Plan::all();
        $states = $this->getNigerianStates();
        return view('admin.subscribers.create', compact('plans', 'states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'school_name' => 'required|string|max:255',
            'school_type' => 'required|string|in:public,private,federal,state',
            'state' => 'required|string',
            'lga' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'plan_id' => 'nullable|exists:plans,id',
            'start_subscription' => 'nullable|boolean',
        ]);

        // Create subscriber
        $subscriber = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'school_name' => $request->school_name,
            'school_type' => $request->school_type,
            'state' => $request->state,
            'lga' => $request->lga,
            'password' => bcrypt($request->password),
            'role_id' => 2, // Subscriber role
            'registered_at' => now(),
        ]);

        // Create subscription if requested
        if ($request->start_subscription && $request->plan_id) {
            $plan = Plan::find($request->plan_id);

            Subscription::create([
                'user_id' => $subscriber->id,
                'plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => now()->addMonths($plan->months),
                'is_active' => true,
            ]);
        }

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber created successfully.');
    }

    public function show(User $subscriber)
    {
        // Ensure we're only showing subscribers
        if (!$subscriber->isSubscriber()) {
            abort(404);
        }

        $subscriber->load(['subscriptions.plan', 'payments']);

        return view('admin.subscribers.show', compact('subscriber'));
    }

    public function edit(User $subscriber)
    {
        if (!$subscriber->isSubscriber()) {
            abort(404);
        }

        $states = $this->getNigerianStates();
        $lgas = $this->getLGAsByState($subscriber->state);

        return view('admin.subscribers.edit', compact('subscriber', 'states', 'lgas'));
    }

    public function update(Request $request, User $subscriber)
    {
        if (!$subscriber->isSubscriber()) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($subscriber->id),
            ],
            'phone' => 'required|string|max:20',
            'school_name' => 'required|string|max:255',
            'school_type' => 'required|string|in:public,private,federal,state',
            'state' => 'required|string',
            'lga' => 'required|string',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'school_name' => $request->school_name,
            'school_type' => $request->school_type,
            'state' => $request->state,
            'lga' => $request->lga,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $subscriber->update($data);

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber updated successfully.');
    }

    public function destroy(User $subscriber)
    {
        if (!$subscriber->isSubscriber()) {
            abort(404);
        }

        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber deleted successfully.');
    }

    public function createSubscription(User $subscriber)
    {
        if (!$subscriber->isSubscriber()) {
            abort(404);
        }

        $plans = Plan::all();
        return view('admin.subscribers.create-subscription', compact('subscriber', 'plans'));
    }

    public function storeSubscription(Request $request, User $subscriber)
    {
        if (!$subscriber->isSubscriber()) {
            abort(404);
        }

        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_trial' => 'nullable|boolean',
        ]);

        // Deactivate any existing active subscription
        $subscriber->subscriptions()->where('is_active', true)->update(['is_active' => false]);

        // Create new subscription
        Subscription::create([
            'user_id' => $subscriber->id,
            'plan_id' => $request->plan_id,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
            'is_active' => true,
            'free_access_started_at' => $request->is_trial ? now() : null,
        ]);

        return redirect()->route('admin.subscribers.show', $subscriber)
            ->with('success', 'Subscription created successfully.');
    }

    public function toggleStatus(User $subscriber)
    {
        if (!$subscriber->isSubscriber()) {
            abort(404);
        }

        $subscriber->update([
            'is_active' => !$subscriber->is_active
        ]);

        $status = $subscriber->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Subscriber {$status} successfully.");
    }

    private function getNigerianStates()
    {
        return [
            'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno',
            'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'Gombe', 'Imo', 'Jigawa',
            'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos', 'Nasarawa', 'Niger',
            'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara', 'FCT'
        ];
    }

    private function getLGAsByState($state)
    {
        // This is a simplified version. You might want to create a full LGA database table.
        $lgas = [
            'Lagos' => ['Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa', 'Badagry', 'Epe', 'Eti-Osa', 'Ibeju-Lekki', 'Ifako-Ijaiye', 'Ikeja', 'Ikorodu', 'Kosofe', 'Lagos Island', 'Lagos Mainland', 'Mushin', 'Ojo', 'Oshodi-Isolo', 'Shomolu', 'Surulere'],
            'Abuja' => ['Abaji', 'Bwari', 'Gwagwalada', 'Kuje', 'Kwali', 'Municipal'],
            // Add more states and their LGAs as needed
        ];

        return $lgas[$state] ?? [];
    }
}
