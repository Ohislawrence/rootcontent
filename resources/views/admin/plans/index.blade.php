@extends('layouts.app')

@section('title', 'Manage Plans')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manage Subscription Plans
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Actions -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Subscription Plans ({{ $plans->count() }})</h3>
                    <a href="{{ route('admin.plans.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Create New Plan
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Plans Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($plans as $plan)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <!-- Plan Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h3>
                                    <div class="flex items-center mt-1">
                                        {!! $plan->status_badge !!}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900">{{ $plan->formatted_price }}</div>
                                    <div class="text-sm text-gray-500">per {{ $plan->duration }}</div>
                                </div>
                            </div>

                            <!-- Plan Details -->
                            <div class="mb-4">
                                <div class="text-sm text-gray-600 mb-2">
                                    <strong>Duration:</strong> {{ $plan->months }} month(s)
                                </div>
                                @if($plan->description)
                                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($plan->description, 100) }}</p>
                                @endif

                                @php
                                    // Safely get features as array
                                    $features = is_array($plan->features) ? $plan->features : (is_string($plan->features) ? json_decode($plan->features, true) : []);
                                    $features = $features ?? [];
                                @endphp

                                @if(!empty($features))
                                <div class="text-sm text-gray-600">
                                    <strong>Features:</strong>
                                    <ul class="list-disc list-inside mt-1 space-y-1">
                                        @foreach(array_slice($features, 0, 3) as $feature)
                                            <li class="text-xs">{{ $feature }}</li>
                                        @endforeach
                                        @if(count($features) > 3)
                                            <li class="text-xs text-gray-500">+{{ count($features) - 3 }} more features</li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                            </div>

                            <!-- Subscription Stats -->
                            <div class="border-t border-gray-200 pt-3 mb-4">
                                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                    <div>
                                        <div class="font-semibold">Total Subscriptions</div>
                                        <div>{{ $plan->subscriptions->count() }}</div>
                                    </div>
                                    <div>
                                        <div class="font-semibold">Active Subscriptions</div>
                                        <div>{{ $plan->subscriptions()->where('is_active', true)->where('ends_at', '>', now())->count() }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.plans.show', $plan) }}" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white text-center py-2 px-3 rounded text-sm">
                                    View
                                </a>
                                <a href="{{ route('admin.plans.edit', $plan) }}" class="flex-1 bg-indigo-500 hover:bg-indigo-700 text-white text-center py-2 px-3 rounded text-sm">
                                    Edit
                                </a>

                                @if(!$plan->is_default)
                                <form action="{{ route('admin.plans.set-default', $plan) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-700 text-white py-2 px-3 rounded text-sm">
                                        Set Default
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.plans.toggle-status', $plan) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full {{ $plan->is_active ? 'bg-orange-500 hover:bg-orange-700' : 'bg-green-500 hover:bg-green-700' }} text-white py-2 px-3 rounded text-sm">
                                        {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                @if($plan->can_delete)
                                <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white py-2 px-3 rounded text-sm" onclick="return confirm('Are you sure you want to delete this plan?')">
                                        Delete
                                    </button>
                                </form>
                                @else
                                <button class="flex-1 bg-gray-400 text-white py-2 px-3 rounded text-sm cursor-not-allowed" title="Cannot delete plan with active subscriptions">
                                    Delete
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($plans->isEmpty())
                    <div class="col-span-3 text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No plans</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new subscription plan.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Create New Plan
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
