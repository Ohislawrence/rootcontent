@extends('layouts.guest')

@section('title', 'Reset Password - EduResource')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-6">
                <img src="{{ asset('edures2.png') }}" alt="EduResource Logo" class="h-12 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-900">{{ __('Reset Password') }}</h2>
                <p class="text-sm text-gray-600 mt-2">{{ __('Please choose your new password') }}</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-1" />
                    <x-text-input id="email" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    type="email"
                                    name="email"
                                    :value="old('email', $request->email)"
                                    required autofocus autocomplete="username"
                                    placeholder="your@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('New Password')" class="block text-sm font-medium text-gray-700 mb-1" />
                    <x-text-input id="password" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password"
                                    placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    <p class="text-xs text-gray-500 mt-1">{{ __('Minimum 8 characters') }}</p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Confirm New Password')" class="block text-sm font-medium text-gray-700 mb-1" />
                    <x-text-input id="password_confirmation" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    type="password"
                                    name="password_confirmation"
                                    required autocomplete="new-password"
                                    placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                </div>

                <div class="flex flex-col space-y-4">
                    <x-primary-button class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fas fa-key mr-2"></i>
                        {{ __('Reset Password') }}
                    </x-primary-button>

                    <div class="text-center text-sm text-gray-600">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-1"></i>
                            {{ __('Back to Login') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
