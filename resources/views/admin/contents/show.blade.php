@extends('layouts.app')

@section('title', $content->title)

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Content Details
    </h2>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $content->title }}</h1>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.contents.edit', $content) }}" 
                           class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Edit
                        </a>
                        <a href="{{ route('admin.contents.index') }}" 
                           class="inline-flex items-center px-3 py-1 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Description -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Description</h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-gray-700">{{ $content->description ?: 'No description provided.' }}</p>
                            </div>
                        </div>

                        <!-- File Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">File Information</h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                            @if($content->file_type === 'pdf')
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">File Type: <span class="uppercase">{{ $content->file_type }}</span></p>
                                            <p class="text-sm text-gray-500">Size: {{ \Illuminate\Support\Number::fileSize(Storage::disk('public')->size($content->file_path)) }}</p>
                                            <p class="text-sm text-gray-500">Uploaded: {{ $content->created_at->format('M j, Y \a\t g:i A') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.contents.download', $content) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        Download File
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Metadata -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Details</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Grade Level</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $content->gradeLevel->name }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Subject</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $content->subject->name }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Uploaded By</p>
                                    <p class="text-sm text-gray-900">{{ $content->user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                    <p class="text-sm text-gray-900">{{ $content->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin.contents.edit', $content) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 transition-colors duration-200">
                                    Edit Content
                                </a>
                                <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="inline w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-white hover:bg-red-700 transition-colors duration-200"
                                            onclick="return confirm('Are you sure you want to delete this content? This action cannot be undone.')">
                                        Delete Content
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection