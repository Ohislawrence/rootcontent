@extends('layouts.app')

@section('title', 'Subscriber Details')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Subscriber Details - {{ $subscriber->name }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-lg font-semibold">Profile Information</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.subscribers.edit', $subscriber) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.subscribers.toggle-status', $subscriber) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                                {{ $subscriber->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-900">Personal Information</h4>
                        <dl class="mt-2 space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriber->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriber->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriber->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Registration Date</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriber->registered_at->format('M j, Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900">School Information</h4>
                        <dl class="mt-2 space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">School Name</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriber->school_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">School Type</dt>
                                <dd class="text-sm text-gray-900 capitalize">{{ $subscriber->school_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Location</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriber->lga }}, {{ $subscriber->state }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd>
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                        {{ $subscriber->is_active ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                        {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Subscription -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Current Subscription</h3>
                    @if(!$subscriber->activeSubscription)
                        <a href="{{ route('admin.subscribers.subscriptions.create', $subscriber) }}" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                            Add Subscription
                        </a>
                    @endif
                </div>

                @if($subscriber->activeSubscription)
                    <div class="bg-green-50 border border-green-200 rounded-md p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <h4 class="font-medium text-green-800">Plan</h4>
                                <p class="text-green-900">{{ $subscriber->activeSubscription->plan->name }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-green-800">Status</h4>
                                <p class="text-green-900">{{ $subscriber->subscription_status }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-green-800">Expires In</h4>
                                <p class="text-green-900">{{ $subscriber->remaining_subscription_days }} days</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-green-800">Start Date</h4>
                                <p class="text-green-900">{{ $subscriber->activeSubscription->starts_at->format('M j, Y') }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-green-800">End Date</h4>
                                <p class="text-green-900">{{ $subscriber->activeSubscription->ends_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 text-center">
                        <p class="text-yellow-800">No active subscription</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Subscription History -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Subscription History</h3>

                @if($subscriber->subscriptions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($subscriber->subscriptions as $subscription)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $subscription->plan->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $subscription->starts_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $subscription->ends_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                            {{ $subscription->is_active && $subscription->ends_at->isFuture() ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                            {{ $subscription->is_active && $subscription->ends_at->isFuture() ? 'Active' : 'Expired' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $subscription->free_access_started_at ? 'Trial' : 'Paid' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No subscription history found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
