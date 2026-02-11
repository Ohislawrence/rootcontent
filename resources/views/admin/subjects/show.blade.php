@extends('layouts.app')

@section('title', $subject->name . ' - Subject Details')

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .gradient-border {
        position: relative;
        background: white;
        border-radius: 1rem;
    }

    .gradient-border::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, #3b82f6, #8b5cf6, #06b6d4);
        border-radius: 1.125rem;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .gradient-border:hover::before {
        opacity: 1;
    }

    .content-card {
        transition: all 0.3s ease;
    }
    .content-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -10px rgba(59, 130, 246, 0.2);
    }

    .progress-ring {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Navigation Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.subjects.index') }}"
                       class="flex items-center px-3 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Subjects
                    </a>
                    <span class="text-gray-300">|</span>
                    <span class="text-sm text-gray-500">
                        <span class="font-medium text-gray-700">Dashboard</span> /
                        <span class="font-medium text-gray-700">Subjects</span> /
                        <span class="text-blue-600 font-semibold">{{ $subject->name }}</span>
                    </span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1.5 bg-{{ $subject->is_active ? 'green' : 'gray' }}-100 text-{{ $subject->is_active ? 'green' : 'gray' }}-800 text-xs font-semibold rounded-full">
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-{{ $subject->is_active ? 'green' : 'gray' }}-500 rounded-full mr-1.5 animate-pulse"></span>
                            {{ $subject->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Subject Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="relative px-8 py-12">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white rounded-full"></div>
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white rounded-full"></div>
                </div>

                <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="flex items-center space-x-6">
                        <!-- Subject Icon -->
                        <div class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center shadow-2xl border border-white/30">
                            @if($subject->icon)
                                <i class="fas fa-{{ $subject->icon }} text-5xl text-white"></i>
                            @else
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Subject Info -->
                        <div>
                            <div class="flex items-center space-x-3 mb-2">
                                <h1 class="text-4xl md:text-5xl font-bold text-white">{{ $subject->name }}</h1>
                                @if($subject->category)
                                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-full border border-white/30">
                                        {{ ucfirst($subject->category) }}
                                    </span>
                                @endif
                            </div>

                            @if($subject->description)
                                <p class="text-xl text-white/90 max-w-2xl leading-relaxed">
                                    {{ $subject->description }}
                                </p>
                            @else
                                <p class="text-lg text-white/70 italic">
                                    No description provided for this subject.
                                </p>
                            @endif

                            <!-- Quick Stats -->
                            <div class="flex items-center space-x-6 mt-6">
                                <div class="flex items-center text-white/80">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Created: {{ $subject->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center text-white/80">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span>Last updated: {{ $subject->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.subjects.edit', $subject) }}"
                           class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Subject
                        </a>
                        <a href="{{ route('admin.contents.create', ['subject_id' => $subject->id]) }}"
                           class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl border-2 border-white/50 hover:bg-white/30 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Content
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Content Card -->
            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-full">
                        Total Resources
                    </span>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">{{ $subject->contents_count ?? 0 }}</p>
                        <p class="text-sm text-gray-600 mt-1">Content items</p>
                    </div>
                    <div class="text-blue-600">
                        <span class="text-sm font-semibold">
                            {{ $subject->contents->where('created_at', '>=', now()->subDays(30))->count() }} new
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500">PDF: {{ $subject->contents->where('file_type', 'pdf')->count() }}</span>
                        <span class="text-gray-500">Video: {{ $subject->contents->where('file_type', 'video')->count() }}</span>
                        <span class="text-gray-500">Other: {{ $subject->contents->whereNotIn('file_type', ['pdf', 'video'])->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Total Views Card -->
            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-green-50 text-green-600 text-xs font-semibold rounded-full">
                        Engagement
                    </span>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalViews ?? 0) }}</p>
                        <p class="text-sm text-gray-600 mt-1">Total views</p>
                    </div>
                    <div class="text-green-600">
                        <span class="text-sm font-semibold">
                            {{ number_format($recentViews ?? 0) }} this month
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                        <span>Avg. {{ $subject->contents->avg('views_count') ?? 0 }} views per item</span>
                    </div>
                </div>
            </div>

            <!-- Total Downloads Card -->
            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-purple-50 text-purple-600 text-xs font-semibold rounded-full">
                        Downloads
                    </span>
                </div>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalDownloads ?? 0) }}</p>
                        <p class="text-sm text-gray-600 mt-1">Total downloads</p>
                    </div>
                    <div class="text-purple-600">
                        <span class="text-sm font-semibold">
                            {{ number_format($recentDownloads ?? 0) }} this month
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                        <span>Download rate: {{ $totalViews > 0 ? round(($totalDownloads / $totalViews) * 100, 1) : 0 }}%</span>
                    </div>
                </div>
            </div>

            <!-- Grade Levels Card -->
            <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-amber-100 rounded-xl">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <span class="px-3 py-1 bg-amber-50 text-amber-600 text-xs font-semibold rounded-full">
                        Availability
                    </span>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900">{{ count($subject->grade_levels ?? []) ?: 'All' }}</p>
                    <p class="text-sm text-gray-600 mt-1">Grade levels</p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex flex-wrap gap-1">
                        @if(is_array($subject->grade_levels) && count($subject->grade_levels) > 0)
                            @foreach(array_slice($subject->grade_levels, 0, 3) as $grade)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                    Grade {{ $grade }}
                                </span>
                            @endforeach
                            @if(count($subject->grade_levels) > 3)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                    +{{ count($subject->grade_levels) - 3 }}
                                </span>
                            @endif
                        @else
                            <span class="text-xs text-gray-500">Available for all grade levels</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Grade Levels & Metadata -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Grade Levels Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Grade Level Availability
                        </h3>
                    </div>
                    <div class="p-6">
                        @if(is_array($subject->grade_levels) && count($subject->grade_levels) > 0)
                            <div class="space-y-6">
                                @php
                                    $groupedGrades = \App\Models\GradeLevel::whereIn('id', $subject->grade_levels)
                                        ->get()
                                        ->groupBy('level');
                                @endphp

                                @foreach($groupedGrades as $level => $grades)
                                    <div>
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                            {{ ucfirst(str_replace('_', ' ', $level)) }}
                                        </h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($grades as $grade)
                                                <span class="px-3 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg border border-blue-200">
                                                    {{ $grade->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="text-gray-900 font-medium mb-1">Available for All Grades</p>
                                <p class="text-sm text-gray-500">This subject is accessible to students at all grade levels.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subject Metadata Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Subject Information
                        </h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($subject->category == 'core') bg-blue-100 text-blue-800
                                        @elseif($subject->category == 'science') bg-green-100 text-green-800
                                        @elseif($subject->category == 'arts') bg-purple-100 text-purple-800
                                        @elseif($subject->category == 'commercial') bg-amber-100 text-amber-800
                                        @elseif($subject->category == 'technical') bg-indigo-100 text-indigo-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($subject->category) }}
                                    </span>
                                </dd>
                            </div>

                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500">Subject ID</dt>
                                <dd class="text-sm font-mono bg-gray-100 px-2 py-1 rounded text-gray-700">#{{ $subject->id }}</dd>
                            </div>

                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                <dd class="text-sm text-gray-900">
                                    @if($subject->creator)
                                        {{ $subject->creator->name }}
                                    @else
                                        <span class="text-gray-400">System</span>
                                    @endif
                                </dd>
                            </div>

                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                                <dd class="text-sm text-gray-900">{{ $subject->created_at->format('F j, Y') }}</dd>
                            </div>

                            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="text-sm text-gray-900">{{ $subject->updated_at->format('F j, Y \a\t g:i A') }}</dd>
                            </div>

                            <div class="flex justify-between items-center">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subject->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        <span class="w-2 h-2 rounded-full mr-1.5 {{ $subject->is_active ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                        {{ $subject->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.contents.create', ['subject_id' => $subject->id]) }}"
                           class="flex items-center p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition group">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Add New Content</p>
                                <p class="text-xs text-blue-600">Upload educational resources for this subject</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.subjects.edit', $subject) }}"
                           class="flex items-center p-3 bg-amber-50 text-amber-700 rounded-lg hover:bg-amber-100 transition group">
                            <div class="p-2 bg-amber-100 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">Edit Subject</p>
                                <p class="text-xs text-amber-600">Update subject details and settings</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.contents.index', ['subject_id' => $subject->id]) }}"
                           class="flex items-center p-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition group">
                            <div class="p-2 bg-purple-100 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold">View All Content</p>
                                <p class="text-xs text-purple-600">Browse all resources in this subject</p>
                            </div>
                        </a>

                        <form action="{{ route('admin.subjects.toggle-status', $subject) }}" method="POST" class="inline-block w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full flex items-center p-3 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition group">
                                <div class="p-2 bg-gray-200 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold">{{ $subject->is_active ? 'Deactivate' : 'Activate' }} Subject</p>
                                    <p class="text-xs text-gray-600">{{ $subject->is_active ? 'Hide' : 'Show' }} this subject from users</p>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Content List -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Recent Content
                        </h3>
                        <a href="{{ route('admin.contents.index', ['subject_id' => $subject->id]) }}"
                           class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse($subject->contents->take(5) as $content)
                            <div class="content-card p-6 hover:bg-gray-50 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <!-- File Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                                @if($content->file_type == 'pdf') bg-red-100
                                                @elseif($content->file_type == 'video') bg-purple-100
                                                @elseif($content->file_type == 'audio') bg-green-100
                                                @else bg-blue-100
                                                @endif">
                                                @if($content->file_type == 'pdf')
                                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                @elseif($content->file_type == 'video')
                                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Content Info -->
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-1">
                                                <a href="{{ route('admin.contents.show', $content) }}" class="hover:text-blue-600 transition">
                                                    {{ $content->title }}
                                                </a>
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                                {{ Str::limit($content->description, 100) }}
                                            </p>
                                            <div class="flex items-center space-x-4 text-xs">
                                                <span class="flex items-center text-gray-500">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $content->created_at->diffForHumans() }}
                                                </span>
                                                <span class="flex items-center text-gray-500">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    {{ $content->views_count ?? 0 }} views
                                                </span>
                                                <span class="flex items-center text-gray-500">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    {{ $content->downloads_count ?? 0 }} downloads
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.contents.edit', $content) }}"
                                           class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                           title="Edit Content">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.contents.show', $content) }}"
                                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                           title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-900 mb-2">No content yet</h4>
                                <p class="text-gray-500 mb-6">Get started by adding your first educational resource for {{ $subject->name }}.</p>
                                <a href="{{ route('admin.contents.create', ['subject_id' => $subject->id]) }}"
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Upload First Content
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Popular Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                            </svg>
                            Most Popular Content
                        </h3>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse($subject->contents->sortByDesc('views_count')->take(3) as $content)
                            <div class="p-5 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-sm font-bold text-gray-400 w-6">
                                            #{{ $loop->iteration }}
                                        </span>
                                        <div>
                                            <a href="{{ route('admin.contents.show', $content) }}" class="font-medium text-gray-900 hover:text-blue-600 transition">
                                                {{ Str::limit($content->title, 40) }}
                                            </a>
                                            <div class="flex items-center space-x-3 mt-1">
                                                <span class="text-xs text-gray-500">
                                                    <i class="fas fa-eye mr-1"></i> {{ $content->views_count ?? 0 }} views
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    <i class="fas fa-download mr-1"></i> {{ $content->downloads_count ?? 0 }} downloads
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                            {{ $content->gradeLevel->name ?? 'All Grades' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                <p>No popular content yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animate statistics numbers
    document.addEventListener('DOMContentLoaded', function() {
        const stats = document.querySelectorAll('.stat-card .text-3xl');
        stats.forEach(stat => {
            const value = parseInt(stat.innerText.replace(/[^0-9]/g, ''));
            if (!isNaN(value)) {
                let current = 0;
                const increment = value / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= value) {
                        stat.innerText = stat.innerText.includes('K') || stat.innerText.includes('M')
                            ? stat.innerText
                            : value.toLocaleString();
                        clearInterval(timer);
                    } else {
                        stat.innerText = Math.floor(current).toLocaleString();
                    }
                }, 20);
            }
        });
    });
</script>
@endpush
