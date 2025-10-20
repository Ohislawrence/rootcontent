@extends('layouts.app')

@section('title', 'Subscription Plans')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                @if($hasActiveSubscription)
                    Your Subscription
                @else
                    Choose Your Plan
                @endif
            </h1>
            
            @if($hasActiveSubscription)
                <p class="text-lg text-green-600 mb-8">
                    You're currently subscribed to <strong>{{ $currentSubscription->plan->name }}</strong>
                </p>
            @else
                <p class="text-lg text-gray-600 mb-8">Start with a free 1-hour trial or choose a paid plan for uninterrupted access</p>
            @endif
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center max-w-2xl mx-auto">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center max-w-2xl mx-auto">
                {{ session('success') }}
            </div>
        @endif

        <!-- Current Subscription Status -->
        @if($hasActiveSubscription && $currentSubscription)
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8 max-w-4xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-green-800">Active Subscription</h3>
                        <div class="text-green-700 mt-1">
                            <p><strong>Plan:</strong> {{ $currentSubscription->plan->name }}</p>
                            <p><strong>Expires:</strong> {{ $currentSubscription->ends_at->format('F j, Y') }}</p>
                            <p><strong>Time Remaining:</strong> {{ $currentSubscription->ends_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Active
                    </span>
                </div>
            </div>
        </div>
        @endif

        <!-- Active Trial Information -->
        @if($hasActiveTrial && $currentSubscription)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8 max-w-4xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-blue-800">Free Trial Active</h3>
                        <div class="text-blue-700 mt-1">
                            @php
                                $remainingMinutes = $currentSubscription->getRemainingFreeTrialMinutes();
                            @endphp
                            @if($remainingMinutes > 0)
                                <p>Your free trial ends in <strong>{{ $remainingMinutes }} minutes</strong>.</p>
                                <p class="text-sm mt-1">Upgrade to a paid plan to continue access after your trial ends.</p>
                            @else
                                <p>Your free trial has ended. Upgrade to continue accessing content.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Trial Active
                    </span>
                </div>
            </div>
        </div>
        @endif

        <!-- Free Trial Information for New Users -->
        @if(!$hasActiveSubscription && !$hasActiveTrial && !$hasUsedFreeTrial)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8 max-w-4xl mx-auto">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-blue-800">Start with Free 1-Hour Trial</h3>
                    <p class="text-blue-700 mt-1">
                        New users get 1 hour of free access to all curriculum content. After your trial ends, choose a paid plan to continue learning.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Used Free Trial Message -->
        @if($hasUsedFreeTrial && !$hasActiveSubscription && !$hasActiveTrial)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8 max-w-4xl mx-auto">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-yellow-800">Free Trial Used</h3>
                    <p class="text-yellow-700 mt-1">
                        You have already used your free 1-hour trial. Choose a paid plan below to continue accessing our curriculum content.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Plans Grid -->
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            @foreach($plans as $plan)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 {{ $plan->duration === 'yearly' ? 'border-yellow-400' : 'border-blue-400' }} 
                @if($hasActiveSubscription && $currentSubscription && $currentSubscription->plan_id === $plan->id) ring-2 ring-green-500 ring-opacity-50 @endif">
                
                <!-- Current Plan Badge -->
                @if($hasActiveSubscription && $currentSubscription && $currentSubscription->plan_id === $plan->id)
                <div class="bg-green-500 text-white py-2 text-center">
                    <span class="text-sm font-medium">Your Current Plan</span>
                </div>
                @else
                <div class="bg-{{ $plan->duration === 'yearly' ? 'yellow' : 'blue' }}-500 text-white py-4 text-center">
                    <h2 class="text-2xl font-bold">{{ $plan->name }}</h2>
                </div>
                @endif

                <div class="p-6">
                    <div class="text-center mb-4">
                        <span class="text-4xl font-bold">₦{{ number_format($plan->price, 2) }}</span>
                        <span class="text-gray-600">/{{ $plan->duration }}</span>
                    </div>
                    
                    <ul class="mb-6 space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Access to all K-12 curriculum content
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $plan->months }} months access
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            All subjects and grade levels
                        </li>
                        
                        <!-- Safe Features Display -->
                        @php
                            // Safely get features as array
                            $features = is_array($plan->features) ? $plan->features : [];
                            if (is_string($plan->features)) {
                                $features = json_decode($plan->features, true) ?? [];
                            }
                            $features = array_slice($features, 0, 3);
                        @endphp
                        
                        @foreach($features as $feature)
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>

                    <div class="space-y-2">
                        @if($hasActiveSubscription && $currentSubscription && $currentSubscription->plan_id === $plan->id)
                            <!-- Current Plan - Show Manage Options -->
                            <button class="w-full bg-gray-500 text-white font-bold py-3 px-4 rounded cursor-not-allowed" disabled>
                                Current Plan
                            </button>
                            <p class="text-xs text-gray-500 text-center">You're currently on this plan</p>
                            
                        @elseif($hasActiveSubscription)
                            <!-- Has different active plan - Show Upgrade Option -->
                            <form action="{{ route('subscriber.payment.initiate', $plan) }}" method="GET" class="inline-block w-full">
                                <button type="submit" class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded transition duration-200">
                                    Upgrade to This Plan
                                </button>
                                <p class="text-xs text-gray-500 text-center mt-1">Switch to this plan</p>
                            </form>
                            
                        @elseif(!$hasUsedFreeTrial && !$hasActiveTrial)
                            <!-- New user - Show Free Trial -->
                            <form action="{{ route('subscriber.subscribe', $plan) }}" method="POST" class="inline-block w-full">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded transition duration-200">
                                    Start 1-Hour Free Trial
                                </button>
                                <p class="text-xs text-gray-500 text-center mt-1">No payment required</p>
                            </form>
                        @endif
                        
                        <!-- Always show Subscribe button (except for current plan) -->
                        @if(!$hasActiveSubscription || ($hasActiveSubscription && $currentSubscription->plan_id !== $plan->id))
                            <form action="{{ route('subscriber.payment.initiate', $plan) }}" method="GET" class="inline-block w-full">
                                <button type="submit" class="w-full bg-{{ $plan->duration === 'yearly' ? 'yellow' : 'blue' }}-500 hover:bg-{{ $plan->duration === 'yearly' ? 'yellow' : 'blue' }}-700 text-white font-bold py-3 px-4 rounded transition duration-200">
                                    @if($hasActiveSubscription)
                                        Switch to This Plan
                                    @else
                                        Subscribe Now
                                    @endif
                                </button>
                                <p class="text-xs text-gray-500 text-center mt-1">
                                    @if($hasActiveSubscription)
                                        Change your current plan
                                    @else
                                        Immediate access after payment
                                    @endif
                                </p>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Additional Info -->
        <div class="mt-12 text-center text-gray-600 max-w-2xl mx-auto">
            <p class="mb-4">All plans include:</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Unlimited downloads
                </div>
                <div class="flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    PDF previews
                </div>
                <div class="flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Regular updates
                </div>
            </div>
        </div>

        <!-- Back to Content Link for Subscribed Users -->
        @if($hasActiveSubscription || $hasActiveTrial)
        <div class="mt-8 text-center">
            <a href="{{ route('contents.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Content Library
            </a>
        </div>
        @endif
    </div>
</div>
@endsection