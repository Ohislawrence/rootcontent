@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
        <div class="text-sm text-gray-500">
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Main Stats Cards - Side by Side -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-xl p-3">
                            <svg class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900">₦{{ number_format($totalRevenue, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Subscribers -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-xl p-3">
                            <svg class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Subscribers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalSubscribers }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs font-medium text-green-600">{{ $activeSubscribers }} active</span>
                                <span class="mx-1 text-gray-300">•</span>
                                <span class="text-xs text-gray-500">{{ $totalSubscribers - $activeSubscribers }} inactive</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Contents -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-xl p-3">
                            <svg class="h-7 w-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Curriculum Contents</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalContents }}</p>
                            <p class="text-xs text-gray-500 mt-1">Documents & Resources</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Subscriptions -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-100 rounded-xl p-3">
                            <svg class="h-7 w-7 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Active Subscriptions</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeSubscriptions }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-xs text-gray-500">{{ $paidSubscriptions }} paid</span>
                                <span class="mx-1 text-gray-300">•</span>
                                <span class="text-xs text-gray-500">{{ $trialSubscriptions }} trial</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Overview - Side by Side -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Today's Revenue</p>
                        <p class="text-2xl font-bold mt-1">₦{{ number_format($todayRevenue, 2) }}</p>
                    </div>
                    <div class="bg-blue-400/20 rounded-full p-3">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">New Subscribers Today</p>
                        <p class="text-2xl font-bold mt-1">{{ $todaySubscribers }}</p>
                    </div>
                    <div class="bg-green-400/20 rounded-full p-3">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Today's Payments</p>
                        <p class="text-2xl font-bold mt-1">{{ $todayPayments }}</p>
                    </div>
                    <div class="bg-purple-400/20 rounded-full p-3">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section with Real Data -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Revenue Overview</h3>
                        <select id="revenuePeriod" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="1month">Last Month</option>
                            <option value="3months" selected>Last 3 Months</option>
                            <option value="6months">Last 6 Months</option>
                            <option value="1year">Last Year</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Subscriber Growth Chart -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Subscriber Growth</h3>
                        <select id="growthPeriod" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="1month">Last Month</option>
                            <option value="3months" selected>Last 3 Months</option>
                            <option value="6months">Last 6 Months</option>
                            <option value="1year">Last Year</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="subscriberChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats & Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Stats -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-yellow-50 border border-yellow-100 rounded-xl">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-yellow-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-yellow-800">Pending Payments</span>
                            </div>
                            <span class="text-lg font-bold text-yellow-800">{{ $quickStats['pending_payments'] }}</span>
                        </div>

                        <div class="flex justify-between items-center p-4 bg-red-50 border border-red-100 rounded-xl">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm font-medium text-red-800">Expiring Subscriptions</span>
                            </div>
                            <span class="text-lg font-bold text-red-800">{{ $quickStats['expiring_subscriptions'] }}</span>
                        </div>

                        <div class="flex justify-between items-center p-4 bg-gray-50 border border-gray-100 rounded-xl">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-800">Inactive Subscribers</span>
                            </div>
                            <span class="text-lg font-bold text-gray-800">{{ $quickStats['inactive_subscribers'] }}</span>
                        </div>

                        <div class="flex justify-between items-center p-4 bg-blue-50 border border-blue-100 rounded-xl">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="text-sm font-medium text-blue-800">Active Plans</span>
                            </div>
                            <span class="text-lg font-bold text-blue-800">{{ $quickStats['total_plans'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Subscribers -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Subscribers</h3>
                        <a href="{{ route('admin.subscribers.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentSubscribers as $subscriber)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="bg-gray-100 rounded-full p-2 mr-3">
                                    <svg class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $subscriber->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $subscriber->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">{{ $subscriber->created_at->diffForHumans() }}</p>
                                @if($subscriber->activeSubscription)
                                    <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full font-medium">
                                        Active
                                    </span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">No recent subscribers</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Payments</h3>
                        <a href="{{ route('admin.payments.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentPayments as $payment)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-full p-2 mr-3">
                                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">₦{{ number_format($payment->amount, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->user->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">{{ $payment->created_at->diffForHumans() }}</p>
                                {!! $payment->formatted_status !!}
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">No recent payments</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Performance & Recent Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Plan Performance -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Plan Performance</h3>
                    <div class="space-y-4">
                        @foreach($planPerformance as $plan)
                        <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-semibold text-gray-900">{{ $plan->name }}</h4>
                                <span class="text-sm font-bold text-green-600">₦{{ number_format($plan->total_revenue ?? 0, 2) }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-3">
                                <div>
                                    <span class="font-medium">{{ $plan->active_subscriptions_count }}</span> Active Subs
                                </div>
                                <div>
                                    <span class="font-medium">{{ $plan->successful_payments_count }}</span> Payments
                                </div>
                            </div>
                            <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                @if($totalRevenue > 0)
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ (($plan->total_revenue ?? 0) / $totalRevenue) * 100 }}%"></div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Content -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Content</h3>
                        <a href="{{ route('admin.contents.index') }}" class="text-sm text-blue-600 hover:text-blue-900 font-medium">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($recentContents as $content)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="bg-purple-100 rounded-full p-2 mr-3">
                                    <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($content->title, 30) }}</p>
                                    <p class="text-xs text-gray-500">{{ $content->gradeLevel->name }} • {{ $content->subject->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">{{ $content->created_at->diffForHumans() }}</p>
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full uppercase font-medium">
                                    {{ $content->file_type }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">No recent content</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Most Viewed Content -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Most Viewed Resources</h3>
                    <div class="space-y-4">
                        @forelse($popularContent as $content)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="bg-red-100 rounded-full p-2 mr-3">
                                    <svg class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($content->title, 40) }}</p>
                                    <p class="text-xs text-gray-500">{{ $content->gradeLevel->name }} • {{ $content->subject->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-semibold text-red-600">{{ $content->views_count }} views</p>
                                <p class="text-xs text-gray-500">{{ $content->downloads_count }} downloads</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">No view data available</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Most Downloaded Content -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Most Downloaded Resources</h3>
                    <div class="space-y-4">
                        @forelse($mostDownloaded as $content)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-full p-2 mr-3">
                                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($content->title, 40) }}</p>
                                    <p class="text-xs text-gray-500">{{ $content->gradeLevel->name }} • {{ $content->subject->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-semibold text-green-600">{{ $content->downloads_count }} downloads</p>
                                <p class="text-xs text-gray-500">{{ $content->views_count }} views</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">No download data available</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize charts with real data
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const subscriberCtx = document.getElementById('subscriberChart').getContext('2d');

        let revenueChart, subscriberChart;

        function initRevenueChart(data) {
            if (revenueChart) {
                revenueChart.destroy();
            }

            revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.date),
                    datasets: [{
                        label: 'Revenue (₦)',
                        data: data.map(item => item.value),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₦' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        function initSubscriberChart(data) {
            if (subscriberChart) {
                subscriberChart.destroy();
            }

            subscriberChart = new Chart(subscriberCtx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.date),
                    datasets: [{
                        label: 'New Subscribers',
                        data: data.map(item => item.value),
                        backgroundColor: '#3B82F6',
                        borderColor: '#3B82F6',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Load initial chart data
        function loadChartData(type, period, chartType) {
            fetch(`/admin/dashboard/chart-data?type=${type}&period=${period}`)
                .then(response => response.json())
                .then(data => {
                    if (chartType === 'revenue') {
                        initRevenueChart(data);
                    } else {
                        initSubscriberChart(data);
                    }
                })
                .catch(error => {
                    console.error('Error loading chart data:', error);
                    // Fallback to sample data if API fails
                    const sampleData = [
                        { date: 'Jan', value: 120000 },
                        { date: 'Feb', value: 190000 },
                        { date: 'Mar', value: 150000 },
                        { date: 'Apr', value: 180000 },
                        { date: 'May', value: 220000 },
                        { date: 'Jun', value: 250000 }
                    ];
                    
                    if (chartType === 'revenue') {
                        initRevenueChart(sampleData);
                    } else {
                        initSubscriberChart(sampleData.map(item => ({ date: item.date, value: Math.floor(item.value / 3000) })));
                    }
                });
        }

        // Initial load
        loadChartData('revenue', '3months', 'revenue');
        loadChartData('subscribers', '3months', 'subscriber');

        // Event listeners for period changes
        document.getElementById('revenuePeriod').addEventListener('change', function(e) {
            loadChartData('revenue', e.target.value, 'revenue');
        });

        document.getElementById('growthPeriod').addEventListener('change', function(e) {
            loadChartData('subscribers', e.target.value, 'subscriber');
        });
    });
</script>
@endpush