@extends('layouts.app')

@section('title', 'EduResource - Transform Your Learning Experience')

@section('content')
<!-- Hero Section -->
<section class="relative z-10 py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Hero Content -->
            <div class="text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                    Transform Your
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Learning Experience</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0">
                    Access a comprehensive library of educational resources, curated content, and interactive tools designed to enhance learning outcomes for students and educators.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4 mb-12">
                    <!-- Start Now Button with Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center space-x-3 group">
                            <span class="text-lg">Start Learning Now</span>
                            <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{'rotate-180': open}"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="dropdown-enter"
                             x-transition:enter-start="dropdown-enter"
                             x-transition:enter-end="dropdown-enter-active"
                             x-transition:leave="dropdown-exit"
                             x-transition:leave-start="dropdown-exit"
                             x-transition:leave-end="dropdown-exit-active"
                             class="absolute left-0 mt-3 w-56 bg-white rounded-xl shadow-2xl py-3 z-20 border border-gray-100">
                            <a href="{{ route('login') }}" class="block px-5 py-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-sign-in-alt text-blue-500"></i>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium">Login</div>
                                    <div class="text-xs text-gray-500">Access your account</div>
                                </div>
                            </a>
                            <a href="{{ route('register') }}" class="block px-5 py-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user-plus text-green-500"></i>
                                </div>
                                <div class="text-left">
                                    <div class="font-medium">Register</div>
                                    <div class="text-xs text-gray-500">Create a new account</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="flex flex-wrap justify-center lg:justify-start gap-6 md:gap-10">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-blue-600">500+</div>
                        <div class="text-gray-500">Educational Resources</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-purple-600">50+</div>
                        <div class="text-gray-500">Subjects Covered</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-cyan-600">10K+</div>
                        <div class="text-gray-500">Active Subscribers</div>
                    </div>
                </div>
            </div>

            <!-- Hero Visual -->
            <div class="relative">
                <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl p-6">
                        <div class="flex space-x-4 mb-6">
                            <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-white rounded-lg p-3 shadow-sm flex flex-col items-center justify-center">
                                <i class="fas fa-book text-blue-500 text-xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-700">Lessons</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm flex flex-col items-center justify-center">
                                <i class="fas fa-video text-purple-500 text-xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-700">Videos</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm flex flex-col items-center justify-center">
                                <i class="fas fa-file-pdf text-red-500 text-xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-700">PDFs</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm flex flex-col items-center justify-center">
                                <i class="fas fa-chart-bar text-green-500 text-xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-700">Analytics</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm flex flex-col items-center justify-center">
                                <i class="fas fa-tasks text-yellow-500 text-xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-700">Assignments</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm flex flex-col items-center justify-center">
                                <i class="fas fa-graduation-cap text-indigo-500 text-xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-700">Certificates</span>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg p-4 text-center">
                            <div class="text-sm font-medium">Your Learning Journey Starts Here</div>
                        </div>
                    </div>
                </div>

                <!-- Floating elements around the card -->
                <div class="absolute -top-6 -left-6 w-24 h-24 bg-yellow-200 rounded-full opacity-70 floating-shape"></div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-200 rounded-full opacity-70 floating-shape shape-delay-1"></div>
                <div class="absolute top-1/2 -right-8 w-16 h-16 bg-purple-200 rounded-lg opacity-70 floating-shape shape-delay-2"></div>
            </div>
        </div>
    </div>
</section>
@endsection
