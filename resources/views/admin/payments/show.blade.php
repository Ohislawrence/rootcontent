@extends('layouts.app')

@section('title', 'Payment Details')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Payment Details - {{ $payment->payment_reference }}
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
                    <h3 class="text-2xl font-bold text-gray-900">Payment Details</h3>
                    <div class="flex items-center space-x-2">
                        {!! $payment->formatted_status !!}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Payment Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Payment Information</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Reference Number</dt>
                                <dd class="text-sm font-mono text-gray-900">{{ $payment->payment_reference }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Paystack Reference</dt>
                                <dd class="text-sm font-mono text-gray-900">{{ $payment->paystack_reference }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                <dd class="text-2xl font-bold text-green-600">{{ $payment->formatted_amount }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Date</dt>
                                <dd class="text-sm text-gray-900">{{ $payment->created_at->format('F j, Y g:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                <dd class="text-sm text-gray-900 capitalize">{{ $payment->payment_method }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Subscriber Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Subscriber Information</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="text-sm text-gray-900">{{ $payment->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900">{{ $payment->user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="text-sm text-gray-900">{{ $payment->user->phone ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">School</dt>
                                <dd class="text-sm text-gray-900">{{ $payment->user->school_name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Location</dt>
                                <dd class="text-sm text-gray-900">{{ $payment->user->state ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Plan Information -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Plan Information</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Plan Name</dt>
                            <dd class="text-sm text-gray-900">{{ $payment->plan->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duration</dt>
                            <dd class="text-sm text-gray-900">{{ $payment->plan->months }} months ({{ $payment->plan->duration }})</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Plan Price</dt>
                            <dd class="text-sm text-gray-900">₦{{ number_format($payment->plan->price, 2) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Paystack Response Details -->
                @if($payment->paystack_response && count($payment->paystack_response) > 0)
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Paystack Response Details</h4>
                    <div class="bg-white rounded-md border border-gray-200">
                        <pre class="text-sm p-4 overflow-x-auto">{{ json_encode($payment->paystack_response, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Related Subscription -->
        @if($payment->user->subscriptions->count() > 0)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h4 class="font-semibold text-gray-900 mb-4">Related Subscription</h4>
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
                            @foreach($payment->user->subscriptions as $subscription)
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
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
