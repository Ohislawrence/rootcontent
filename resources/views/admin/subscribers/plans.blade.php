@extends('layouts.app')

@section('title', 'Subscription Plans')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center">Choose Your Subscription Plan</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        @foreach($plans as $plan)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 {{ $plan->duration === 'yearly' ? 'border-yellow-400' : 'border-blue-400' }}">
            <div class="bg-{{ $plan->duration === 'yearly' ? 'yellow' : 'blue' }}-500 text-white py-4 text-center">
                <h2 class="text-2xl font-bold">{{ $plan->name }}</h2>
            </div>
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
                        1-hour free trial available
                    </li>
                </ul>

                <div class="space-y-2">
                    <form action="{{ route('subscribe', $plan) }}" method="POST" class="inline-block w-full">
                        @csrf
                        <button type="submit" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Start 1-Hour Free Trial
                        </button>
                    </form>

                    <form action="{{ route('payment.initiate', $plan) }}" method="GET" class="inline-block w-full">
                        <button type="submit" class="w-full bg-{{ $plan->duration === 'yearly' ? 'yellow' : 'blue' }}-500 hover:bg-{{ $plan->duration === 'yearly' ? 'yellow' : 'blue' }}-700 text-white font-bold py-2 px-4 rounded">
                            Subscribe Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
