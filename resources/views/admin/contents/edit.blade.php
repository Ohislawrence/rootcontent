@extends('layouts.app')

@section('title', 'Edit Content')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Content
    </h2>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-xl border border-gray-200">
            <div class="px-6 py-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Content</h1>
                    <a href="{{ route('admin.contents.index') }}"
                       class="text-gray-600 hover:text-gray-900 font-medium">
                        Back to Contents
                    </a>
                </div>

                <form action="{{ route('admin.contents.update', $content) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input type="text" name="title" id="title" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                value="{{ old('title', $content->title) }}"
                                placeholder="Enter content title">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                placeholder="Enter content description">{{ old('description', $content->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grade Level and Subject -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="grade_level_id" class="block text-sm font-medium text-gray-700 mb-2">Grade Level *</label>
                                <select name="grade_level_id" id="grade_level_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">Select Grade Level</option>
                                    @foreach($gradeLevels->groupBy('level') as $level => $levels)
                                        <optgroup label="{{ ucfirst(str_replace('_', ' ', $level)) }}">
                                            @foreach($levels as $gradeLevel)
                                                <option value="{{ $gradeLevel->id }}"
                                                    {{ old('grade_level_id', $content->grade_level_id) == $gradeLevel->id ? 'selected' : '' }}>
                                                    {{ $gradeLevel->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('grade_level_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                                <select name="subject_id" id="subject_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects->groupBy('category') as $category => $categorySubjects)
                                        <optgroup label="{{ ucfirst($category) }} Subjects">
                                            @foreach($categorySubjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ old('subject_id', $content->subject_id) == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Current File -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current File</label>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        @if($content->file_type === 'pdf')
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $content->title }}</p>
                                        <p class="text-xs text-gray-500 uppercase">{{ $content->file_type }} • {{ \Illuminate\Support\Number::fileSize(Storage::disk('public')->size($content->file_path)) }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.contents.download', $content) }}"
                                   class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    Download
                                </a>
                            </div>
                        </div>

                        <!-- New File Upload -->
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Update File (Optional)</label>
                            <input type="file" name="file" id="file"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                            <p class="mt-1 text-xs text-gray-500">Leave empty to keep current file. Supported formats: PDF, DOC, DOCX, PPT, PPTX, TXT (Max: 10MB)</p>
                            @error('file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Content
                            </button>
                        </div>
                        </form> <!-- Close the update form here -->

                        <!-- Delete form placed outside the update form -->
                        <div class="mt-4 text-right">
                            <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 border border-transparent rounded-lg font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
                                        onclick="return confirm('Are you sure you want to delete this content? This action cannot be undone.')">
                                    Delete Content
                                </button>
                            </form>
                        </div>

            </div>
        </div>
    </div>
</div>
@endsection
