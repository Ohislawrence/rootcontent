@extends('layouts.app')

@section('title', 'Create Subscription')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Subscription for {{ $subscriber->name }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('admin.subscribers.subscriptions.store', $subscriber) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="plan_id" class="block text-sm font-medium text-gray-700">Select Plan *</label>
                        <select name="plan_id" id="plan_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a Plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} - ₦{{ number_format($plan->price, 2) }} ({{ $plan->months }} months)</option>
                            @endforeach
                        </select>
                        @error('plan_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="starts_at" class="block text-sm font-medium text-gray-700">Start Date *</label>
                            <input type="date" name="starts_at" id="starts_at" required value="{{ old('starts_at', now()->format('Y-m-d')) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('starts_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ends_at" class="block text-sm font-medium text-gray-700">End Date *</label>
                            <input type="date" name="ends_at" id="ends_at" required value="{{ old('ends_at', now()->addMonths(3)->format('Y-m-d')) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('ends_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="is_trial" class="flex items-center">
                            <input type="checkbox" name="is_trial" id="is_trial" value="1"
                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-900">This is a trial subscription</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Trial subscriptions will have free access limitations.</p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.subscribers.show', $subscriber) }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            Cancel
                        </a>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                            Create Subscription
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
