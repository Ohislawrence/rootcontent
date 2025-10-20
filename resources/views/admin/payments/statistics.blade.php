@extends('layouts.app')

@section('title', 'Payment Statistics')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Payment Statistics
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Payment Analytics</h3>
                    <a href="{{ route('admin.payments.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Back to Payments
                    </a>
                </div>

                <!-- Revenue by Plan -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Revenue by Plan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($revenueByPlan as $plan)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h5 class="font-medium text-gray-900">{{ $plan->plan_name }}</h5>
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                    {{ $plan->transactions }} trans
                                </span>
                            </div>
                            <div class="text-2xl font-bold text-green-600">₦{{ number_format($plan->revenue, 2) }}</div>
                            <div class="text-sm text-gray-500 mt-1">
                                @if($totalRevenue > 0)
                                    {{ number_format(($plan->revenue / $totalRevenue) * 100, 1) }}% of total
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Status Distribution -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Payment Status Distribution</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($statusDistribution as $status)
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $status->count }}</div>
                            <div class="text-sm text-gray-600 capitalize">{{ $status->status }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Daily Revenue Chart -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Daily Revenue (Last 30 Days)</h4>
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Transactions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($dailyRevenue as $revenue)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ \Carbon\Carbon::parse($revenue->date)->format('M j, Y') }}</td>
                                        <td class="px-4 py-2 text-sm font-semibold text-green-600">₦{{ number_format($revenue->revenue, 2) }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $revenue->transactions ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Monthly Revenue (Last 12 Months)</h4>
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Growth</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @php
                                        $previousRevenue = null;
                                    @endphp
                                    @foreach($monthlyRevenue as $revenue)
                                    @php
                                        $monthName = \Carbon\Carbon::createFromDate($revenue->year, $revenue->month, 1)->format('F Y');
                                        $growth = $previousRevenue ? (($revenue->revenue - $previousRevenue) / $previousRevenue) * 100 : null;
                                        $previousRevenue = $revenue->revenue;
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $monthName }}</td>
                                        <td class="px-4 py-2 text-sm font-semibold text-green-600">₦{{ number_format($revenue->revenue, 2) }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            @if($growth !== null)
                                                <span class="{{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}%
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
