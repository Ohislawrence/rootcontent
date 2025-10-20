@extends('layouts.app')

@section('title', 'My Dashboard')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        My Dashboard
    </h2>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-blue-100">
                        @if($hasActiveSubscription && $currentSubscription)
                            You're subscribed to <strong>{{ $currentSubscription->plan->name }}</strong>
                        @elseif($hasActiveTrial && $currentSubscription)
                            You're on a free trial - explore all features!
                        @else
                            Start exploring our curriculum content
                        @endif
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('contents.index') }}" 
                       class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-200">
                        Browse Content Library
                    </a>
                </div>
            </div>
        </div>

        <!-- Subscription Status -->
        @if($currentSubscription)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Current Subscription Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Subscription Status</h3>
                    @if($hasActiveTrial)
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            Free Trial
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    @endif
                </div>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Current Plan</p>
                        <p class="text-xl font-bold text-gray-900">{{ $currentSubscription->plan->name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">
                            @if($hasActiveTrial)
                                Trial Ends
                            @else
                                Renews On
                            @endif
                        </p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $currentSubscription->ends_at->format('F j, Y') }}
                        </p>
                    </div>

                    @if($hasActiveTrial)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-800">
                                {{ $currentSubscription->getRemainingFreeTrialMinutes() }} minutes remaining
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="pt-3 border-t border-gray-200">
                        <a href="{{ route('subscriber.plans') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            {{ $hasActiveTrial ? 'Upgrade Plan' : 'Manage Subscription' }} →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Learning Progress</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-blue-100 rounded-lg p-2 mr-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Content Viewed</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $viewedContents }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-green-100 rounded-lg p-2 mr-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Resources Downloaded</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $downloadedContents }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-purple-100 rounded-lg p-2 mr-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Resources</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalContents }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('contents.index') }}" 
                       class="w-full bg-blue-50 text-blue-700 px-4 py-3 rounded-lg hover:bg-blue-100 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Browse Content Library
                    </a>
                    
                    <a href="{{ route('subscriber.plans') }}" 
                       class="w-full bg-green-50 text-green-700 px-4 py-3 rounded-lg hover:bg-green-100 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Manage Subscription
                    </a>
                    
                    <a href="{{ route('subscriber.payment.history') }}" 
                       class="w-full bg-purple-50 text-purple-700 px-4 py-3 rounded-lg hover:bg-purple-100 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Payment History
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Activity & Popular Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Recent Downloads -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Recently Downloaded</h3>
                        <a href="{{ route('contents.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentDownloads->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentDownloads as $download)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-green-100 rounded-full p-2 mr-3">
                                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($download->content->title, 40) }}</p>
                                    <p class="text-xs text-gray-500">{{ $download->content->gradeLevel->name }} • {{ $download->content->subject->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">{{ $download->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No downloads yet</p>
                        <a href="{{ route('contents.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Start Downloading
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Popular Content -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Popular Resources</h3>
                        <span class="text-sm text-gray-500">Most downloaded</span>
                    </div>
                </div>
                <div class="p-6">
                    @if($popularContent->count() > 0)
                    <div class="space-y-4">
                        @foreach($popularContent as $content)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-purple-100 rounded-full p-2 mr-3">
                                    <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($content->title, 40) }}</p>
                                    <p class="text-xs text-gray-500">{{ $content->gradeLevel->name }} • {{ $content->subject->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-semibold text-purple-600">{{ $content->downloads_count }} downloads</p>
                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full uppercase">
                                    {{ $content->file_type }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No popular content data yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Overview & Recent Payments -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Content by Grade Level -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Content by Grade Level</h3>
                </div>
                <div class="p-6">
                    @if($contentByGrade->count() > 0)
                    <div class="space-y-4">
                        @foreach($contentByGrade as $grade)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $grade->gradeLevel->name }}</span>
                                <span class="text-sm text-gray-500">{{ $grade->count }} resources</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" 
                                     style="width: {{ ($grade->count / $totalContents) * 100 }}%">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-gray-500 text-center py-4">No content data available</p>
                    @endif
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Payments</h3>
                        <a href="{{ route('subscriber.payment.history') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                    </div>
                </div>
                <div class="p-6">
                    @if($recentPayments->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentPayments as $payment)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-blue-100 rounded-full p-2 mr-3">
                                    <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $payment->plan->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->payment_reference }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">₦{{ number_format($payment->amount, 2) }}</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($payment->status === 'successful') bg-green-100 text-green-800
                                    @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No payment history</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection