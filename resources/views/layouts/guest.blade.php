<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EduResource - Transform Your Learning Experience')</title>
    <link rel="icon" href="{{ asset('favedures.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'gradient': 'gradient 15s ease infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        gradient: {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-bg {
            background: linear-gradient(-45deg, #3b82f6, #8b5cf6, #06b6d4, #10b981);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .floating-shape {
            animation: float 6s ease-in-out infinite;
        }

        .shape-delay-1 {
            animation-delay: 0.5s;
        }

        .shape-delay-2 {
            animation-delay: 1s;
        }

        .shape-delay-3 {
            animation-delay: 1.5s;
        }

        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }

        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.3s, transform 0.3s;
        }

        .dropdown-exit {
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-exit-active {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s, transform 0.3s;
        }

        .mobile-menu-enter {
            opacity: 0;
            transform: translateY(-10px);
        }

        .mobile-menu-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.3s, transform 0.3s;
        }

        .mobile-menu-exit {
            opacity: 1;
            transform: translateY(0);
        }

        .mobile-menu-exit-active {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s, transform 0.3s;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 floating-shape"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 floating-shape shape-delay-1"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 floating-shape shape-delay-2"></div>
        <div class="absolute top-1/3 right-1/4 w-60 h-60 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 floating-shape shape-delay-3"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('edures2.png') }}" width="150" alt="EduResource Logo">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">
                    Home
                </a>

                <a href="{{ route('content.all') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('content.*') ? 'text-blue-600 font-semibold' : '' }}">
                    Browse Resources
                </a>

                @auth
                    <a href="/dashboard" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                        Dashboard
                    </a>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span>{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{'rotate-180': open}"></i>
                        </button>

                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="dropdown-enter"
                             x-transition:enter-start="dropdown-enter"
                             x-transition:enter-end="dropdown-enter-active"
                             x-transition:leave="dropdown-exit"
                             x-transition:leave-start="dropdown-exit"
                             x-transition:leave-end="dropdown-exit-active"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-20 border border-gray-100">
                            <a href="/dashboard" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-tachometer-alt mr-2 text-blue-500"></i>
                                Dashboard
                            </a>
                            <a href="/profile" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-user mr-2 text-green-500"></i>
                                Profile
                            </a>
                            <div class="border-t border-gray-100 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-2 text-red-500"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Start Now Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center space-x-2">
                            <span>Start Now</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{'rotate-180': open}"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="dropdown-enter"
                             x-transition:enter-start="dropdown-enter"
                             x-transition:enter-end="dropdown-enter-active"
                             x-transition:leave="dropdown-exit"
                             x-transition:leave-start="dropdown-exit"
                             x-transition:leave-end="dropdown-exit-active"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-20 border border-gray-100">
                            <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-sign-in-alt mr-2 text-blue-500"></i>
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-user-plus mr-2 text-green-500"></i>
                                Register
                            </a>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false"
             x-transition:enter="mobile-menu-enter"
             x-transition:enter-start="mobile-menu-enter"
             x-transition:enter-end="mobile-menu-enter-active"
             x-transition:leave="mobile-menu-exit"
             x-transition:leave-start="mobile-menu-exit"
             x-transition:leave-end="mobile-menu-exit-active"
             class="md:hidden absolute top-full left-0 right-0 bg-white shadow-xl rounded-lg mt-2 mx-4 py-4 z-50 border border-gray-100"
             x-data="{ mobileMenuOpen: false }">
            <div class="space-y-1 px-4">
                <a href="{{ route('home') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                    <i class="fas fa-home mr-3 text-blue-500"></i>
                    Home
                </a>

                <a href="{{ route('content.all') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('content.*') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                    <i class="fas fa-book mr-3 text-purple-500"></i>
                    Browse Resources
                </a>

                @auth
                    <a href="/dashboard" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-3 text-green-500"></i>
                        Dashboard
                    </a>

                    <a href="/profile" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors duration-200">
                        <i class="fas fa-user mr-3 text-cyan-500"></i>
                        Profile
                    </a>

                    <div class="border-t border-gray-100 my-2"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors duration-200">
                            <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
                            Logout
                        </button>
                    </form>
                @else
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors duration-200">
                        <i class="fas fa-sign-in-alt mr-3 text-blue-500"></i>
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors duration-200">
                        <i class="fas fa-user-plus mr-3 text-green-500"></i>
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative z-10 bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} EduResource. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @stack('scripts')
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/2347064847508" target="_blank" class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 animate-bounce">
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>
</body>
</html>
