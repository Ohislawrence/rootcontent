@extends('layouts.app')

@section('title', $content->title)

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $content->title }}
    </h2>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Enhanced Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 bg-white rounded-lg shadow-sm px-4 py-3 border border-gray-100">
                <li>
                    <a href="{{ route('contents.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-200 flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span class="ml-2 text-sm font-medium">Library</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('contents.browse-grade', $content->gradeLevel) }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            {{ $content->gradeLevel->name }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('contents.browse-subject', $content->subject) }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            {{ $content->subject->name }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-sm font-medium text-gray-900 font-semibold">{{ Str::limit($content->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Content Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                    <!-- Header with Gradient -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2 leading-tight">{{ $content->title }}</h1>
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="bg-white/20 backdrop-blur-sm text-white/90 px-3 py-1 rounded-full text-sm font-medium uppercase tracking-wide">
                                        {{ $content->file_type }}
                                    </span>
                                    <span class="text-white/80 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Uploaded {{ $content->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2">
                                @if($content->file_type === 'pdf')
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                @else
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-6 lg:p-8">
                        <!-- Description -->
                        @if($content->description)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Description
                            </h3>
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <p class="text-gray-700 leading-relaxed text-lg">{{ $content->description }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Enhanced Metadata Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <!-- Educational Information -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 transform transition-all duration-300 hover:scale-[1.02]">
                                <h4 class="font-bold text-gray-900 mb-4 flex items-center text-lg">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    </svg>
                                    Educational Information
                                </h4>
                                <dl class="space-y-4">
                                    <div class="flex items-center justify-between py-2 border-b border-blue-100">
                                        <dt class="text-sm font-medium text-gray-600">Grade Level</dt>
                                        <dd class="text-sm font-semibold text-gray-900 bg-blue-100 px-3 py-1 rounded-full">{{ $content->gradeLevel->name }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between py-2 border-b border-blue-100">
                                        <dt class="text-sm font-medium text-gray-600">Subject</dt>
                                        <dd class="text-sm font-semibold text-gray-900 bg-green-100 px-3 py-1 rounded-full">{{ $content->subject->name }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between py-2">
                                        <dt class="text-sm font-medium text-gray-600">Category</dt>
                                        <dd class="text-sm font-semibold text-gray-900 bg-purple-100 px-3 py-1 rounded-full capitalize">{{ $content->subject->category }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- File Information -->
                            <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-6 border border-gray-200 transform transition-all duration-300 hover:scale-[1.02]">
                                <h4 class="font-bold text-gray-900 mb-4 flex items-center text-lg">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    File Information
                                </h4>
                                <dl class="space-y-4">
                                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                        <dt class="text-sm font-medium text-gray-600">File Type</dt>
                                        <dd class="text-sm font-semibold text-gray-900 bg-gray-100 px-3 py-1 rounded-full uppercase">{{ $content->file_type }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                        <dt class="text-sm font-medium text-gray-600">File Size</dt>
                                        <dd class="text-sm font-semibold text-gray-900">
                                            @php
                                                $fileSize = Storage::disk('public')->size($content->file_path);
                                                $fileSizeInKB = round($fileSize / 1024, 1);
                                            @endphp
                                            {{ $fileSizeInKB }} KB
                                        </dd>
                                    </div>
                                    <div class="flex items-center justify-between py-2">
                                        <dt class="text-sm font-medium text-gray-600">Upload Date</dt>
                                        <dd class="text-sm font-semibold text-gray-900">{{ $content->created_at->format('F j, Y') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Enhanced File Actions -->
                        <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-6 border border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Access Resource</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($content->file_type === 'pdf')
                                <a href="{{ route('contents.preview', $content) }}"
                                   target="_blank"
                                   class="group bg-gradient-to-r from-blue-500 to-blue-600 text-white py-4 px-6 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center font-semibold">
                                    <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview PDF
                                </a>
                                @else
                                <button onclick="showPreviewMessage()"
                                        class="group bg-gradient-to-r from-gray-400 to-gray-500 text-white py-4 px-6 rounded-xl hover:from-gray-500 hover:to-gray-600 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center font-semibold cursor-not-allowed">
                                    <svg class="w-6 h-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Preview Not Available
                                </button>
                                @endif

                                <a href="{{ route('contents.download', $content) }}"
                                   class="group bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-6 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center font-semibold">
                                    <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download File
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Content -->
                @if($relatedContents->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Related Resources
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedContents as $related)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group">
                            <div class="flex justify-between items-start mb-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 uppercase tracking-wide">
                                    {{ $related->file_type }}
                                </span>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-xs text-gray-500">{{ $related->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                                <a href="{{ route('contents.show', $related) }}">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <div class="flex items-center text-sm text-gray-500 mb-4 space-x-2">
                                <span class="bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $related->gradeLevel->name }}</span>
                                <span class="bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $related->subject->name }}</span>
                            </div>
                            <div class="flex space-x-3 pt-3 border-t border-gray-100">
                                <a href="{{ route('contents.show', $related) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('contents.download', $related) }}" class="text-sm text-green-600 hover:text-green-800 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Quick Actions
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('contents.browse-grade', $content->gradeLevel) }}"
                           class="w-full bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 px-4 py-4 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md flex items-center justify-center font-medium border border-blue-200">
                            <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Browse {{ $content->gradeLevel->name }}
                        </a>

                        <a href="{{ route('contents.browse-subject', $content->subject) }}"
                           class="w-full bg-gradient-to-r from-green-50 to-green-100 text-green-700 px-4 py-4 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md flex items-center justify-center font-medium border border-green-200">
                            <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Browse {{ $content->subject->name }}
                        </a>

                        <a href="{{ route('contents.index') }}"
                           class="w-full bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 px-4 py-4 rounded-xl hover:from-gray-100 hover:to-gray-200 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md flex items-center justify-center font-medium border border-gray-200">
                            <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Back to Library
                        </a>
                    </div>
                </div>

                <!-- Subscription Status -->
                @if($subscription && $subscription->free_access_started_at)
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-2xl p-5 transform transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-sm font-bold text-yellow-800">
                                Free Trial Active
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <div class="mb-2">
                                    <span class="font-semibold">Time remaining:</span>
                                    <div class="mt-1 text-lg font-bold">
                                        {{ $subscription->free_access_started_at->addHour()->diffForHumans(['parts' => 2]) }}
                                    </div>
                                </div>
                                <a href="{{ route('subscriber.plans') }}" 
                                   class="inline-flex items-center text-yellow-800 font-semibold hover:text-yellow-900 transition-colors duration-200">
                                    Upgrade to continue access
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function showPreviewMessage() {
        alert('Preview is only available for PDF files. Please download the file to view it.');
    }
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .sticky {
        position: sticky;
    }
</style>
@endsection