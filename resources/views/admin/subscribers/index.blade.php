@extends('layouts.app')

@section('title', 'Manage Subscribers')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manage Subscribers
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Filters and Search -->
                <div class="mb-6">
                    <form action="{{ route('admin.subscribers.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by name, email, school, or phone..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="with_subscription" {{ request('status') == 'with_subscription' ? 'selected' : '' }}>With Subscription</option>
                                <option value="without_subscription" {{ request('status') == 'without_subscription' ? 'selected' : '' }}>Without Subscription</option>
                            </select>
                        </div>
                        <div>
                            <select name="subscription_type" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Subscription Types</option>
                                <option value="trial" {{ request('subscription_type') == 'trial' ? 'selected' : '' }}>Trial</option>
                                <option value="paid" {{ request('subscription_type') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                Filter
                            </button>
                            <a href="{{ route('admin.subscribers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Actions -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold">Subscribers ({{ $subscribers->total() }})</h3>
                    <a href="{{ route('admin.subscribers.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Add New Subscriber
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Subscribers Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscriber</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscription</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($subscribers as $subscriber)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $subscriber->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $subscriber->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $subscriber->school_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $subscriber->school_type }} • {{ $subscriber->state }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $subscriber->phone }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($subscriber->activeSubscription)
                                        <div class="text-sm text-gray-900">{{ $subscriber->activeSubscription->plan->name }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $subscriber->subscription_status }} •
                                            {{ $subscriber->remaining_subscription_days }} days left
                                        </div>
                                    @else
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                            No Subscription
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                        {{ $subscriber->is_active ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                        {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.subscribers.show', $subscriber) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('admin.subscribers.edit', $subscriber) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.subscribers.toggle-status', $subscriber) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                {{ $subscriber->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $subscribers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
