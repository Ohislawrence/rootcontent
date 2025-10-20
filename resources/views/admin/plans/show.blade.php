@extends('layouts.app')

@section('title', 'Plan Details')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Plan Details - {{ $plan->name }}
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
                    <h3 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h3>
                    <div class="flex items-center space-x-2">
                        {!! $plan->status_badge !!}
                        <a href="{{ route('admin.plans.edit', $plan) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                            Edit
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Plan Information</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration Type</dt>
                                <dd class="text-sm text-gray-900 capitalize">{{ $plan->duration }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="text-sm text-gray-900">{{ $plan->months }} month(s)</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Price</dt>
                                <dd class="text-2xl font-bold text-gray-900">{{ $plan->formatted_price }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="text-sm text-gray-900">{{ $plan->created_at->format('M j, Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Subscription Statistics</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Subscriptions</dt>
                                <dd class="text-2xl font-bold text-blue-600">{{ $subscriptionsCount }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Active Subscriptions</dt>
                                <dd class="text-2xl font-bold text-green-600">{{ $activeSubscriptionsCount }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Completion Rate</dt>
                                <dd class="text-sm text-gray-900">
                                    @if($subscriptionsCount > 0)
                                        {{ number_format(($activeSubscriptionsCount / $subscriptionsCount) * 100, 1) }}%
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                @if($plan->description)
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 mb-2">Description</h4>
                    <p class="text-gray-700">{{ $plan->description }}</p>
                </div>
                @endif

                @php
                    // Safely get features as array
                    $features = is_array($plan->features) ? $plan->features : (is_string($plan->features) ? json_decode($plan->features, true) : []);
                    $features = $features ?? [];
                @endphp

                @if(!empty($features))
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Features</h4>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($features as $feature)
                        <li class="flex items-center text-sm text-gray-700">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h4 class="font-semibold text-gray-900 mb-4">Plan Actions</h4>
                <div class="flex flex-wrap gap-3">
                    @if(!$plan->is_default)
                    <form action="{{ route('admin.plans.set-default', $plan) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm">
                            Set as Default
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.plans.toggle-status', $plan) }}" method="POST">
                        @csrf
                        <button type="submit" class="{{ $plan->is_active ? 'bg-orange-500 hover:bg-orange-700' : 'bg-green-500 hover:bg-green-700' }} text-white px-4 py-2 rounded-md text-sm">
                            {{ $plan->is_active ? 'Deactivate Plan' : 'Activate Plan' }}
                        </button>
                    </form>

                    @if($plan->can_delete)
                    <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm" onclick="return confirm('Are you sure you want to delete this plan?')">
                            Delete Plan
                        </button>
                    </form>
                    @else
                    <button class="bg-gray-400 text-white px-4 py-2 rounded-md text-sm cursor-not-allowed" title="Cannot delete plan with active subscriptions">
                        Delete Plan
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
