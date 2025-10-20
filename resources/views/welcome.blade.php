<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduResource - Transform Your Learning Experience</title>
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
    </style>
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
    <nav class="relative z-10 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('edures2.png') }}" width="150">
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                
                
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
                        <a href="/login" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                            <i class="fas fa-sign-in-alt mr-2 text-blue-500"></i>
                            Login
                        </a>
                        <a href="/register" class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                            <i class="fas fa-user-plus mr-2 text-green-500"></i>
                            Register
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

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
                                <a href="/login" class="block px-5 py-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-sign-in-alt text-blue-500"></i>
                                    </div>
                                    <div class="text-left">
                                        <div class="font-medium">Login</div>
                                        <div class="text-xs text-gray-500">Access your account</div>
                                    </div>
                                </a>
                                <a href="/register" class="block px-5 py-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 flex items-center">
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

    

    <!-- Footer -->
    <footer class="relative z-10  lg:px-8 bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 mb-2">
                <p>&copy; {{ date('Y') }} EduResource. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>
</html>