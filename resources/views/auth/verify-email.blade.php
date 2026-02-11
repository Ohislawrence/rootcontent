@extends('layouts.guest')

@section('title', 'Verify Email - EduResource')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-6">
                <img src="{{ asset('edures2.png') }}" alt="EduResource Logo" class="h-12 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-900">{{ __('Verify Your Email') }}</h2>
                <div class="flex justify-center mt-3">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-3xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="mb-6 text-sm text-gray-600 text-center leading-relaxed">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-4">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <x-primary-button class="w-full sm:w-auto px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fas fa-paper-plane mr-2"></i>
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto px-6 py-2 border border-gray-300 bg-white text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    {{ __('Your email address will only be used for account verification and important notifications.') }}
                </p>
            </div>
        </div>
    </div>
@endsection
