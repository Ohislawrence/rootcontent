@extends('layouts.app')

@section('title', 'Edit Subject')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.subjects.index') }}" class="flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Subjects
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Edit Subject</h1>
            </div>
            <p class="mt-2 text-gray-600">Update subject information for "{{ $subject->name }}"</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.subjects.update', $subject) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Form Header -->
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Subject Information
                    </h2>
                </div>

                <!-- Form Body -->
                <div class="px-6 pb-6 space-y-6">
                    <!-- Subject Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Subject Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $subject->name) }}"
                               class="block w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-300 @error('name') border-red-500 @enderror"
                               placeholder="e.g., Mathematics, English Language, Biology..."
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category"
                                id="category"
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-300 @error('category') border-red-500 @enderror"
                                required>
                            <option value="">Select a category</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ old('category', $subject->category) == $key ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grade Levels -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Grade Levels
                        </label>
                        <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($gradeLevels->groupBy('level') as $level => $levels)
                                    <div class="space-y-2">
                                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            {{ ucfirst(str_replace('_', ' ', $level)) }}
                                        </h4>
                                        @foreach($levels as $grade)
                                            <label class="flex items-center space-x-3">
                                                <input type="checkbox"
                                                       name="grade_levels[]"
                                                       value="{{ $grade->id }}"
                                                       {{ in_array($grade->id, old('grade_levels', $subject->grade_levels ?? [])) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                                <span class="text-sm text-gray-700">{{ $grade->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Leave unchecked to make this subject available for all grades.</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="block w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all duration-300 @error('description') border-red-500 @enderror"
                                  placeholder="Provide a brief description of this subject...">{{ old('description', $subject->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Subject Icon
                        </label>
                        <div class="grid grid-cols-6 md:grid-cols-12 gap-3">
                            @php
                                $icons = [
                                    'book', 'book-open', 'calculator', 'flask', 'microscope',
                                    'globe', 'language', 'music', 'palette', 'code',
                                    'dollar-sign', 'briefcase', 'heart', 'leaf', 'atom'
                                ];
                            @endphp
                            @foreach($icons as $icon)
                                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer hover:border-amber-500 hover:bg-amber-50 transition-all duration-200 {{ old('icon', $subject->icon) == $icon ? 'border-amber-500 bg-amber-50' : 'border-gray-200' }}">
                                    <input type="radio" name="icon" value="{{ $icon }}" {{ old('icon', $subject->icon) == $icon ? 'checked' : '' }} class="sr-only">
                                    <i class="fas fa-{{ $icon }} text-2xl {{ old('icon', $subject->icon) == $icon ? 'text-amber-600' : 'text-gray-500' }}"></i>
                                    <span class="text-xs mt-1 {{ old('icon', $subject->icon) == $icon ? 'text-amber-600 font-semibold' : 'text-gray-500' }}">{{ $icon }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Active Status</label>
                            <p class="text-xs text-gray-500">Enable this subject for content creation and display</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $subject->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900">Active</span>
                        </label>
                    </div>
                </div>

                <!-- Danger Zone -->
                @if($subject->contents_count > 0)
                <div class="px-6 py-4 bg-red-50 border-t-2 border-red-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-red-700">
                            <span class="font-semibold">Note:</span> This subject has {{ $subject->contents_count }} content item(s) associated with it. Changes will affect all related content.
                        </p>
                    </div>
                </div>
                @endif

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.subjects.index') }}"
                        class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Update Subject
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Card -->
        <div class="mt-6 bg-white rounded-xl shadow-lg border border-red-200 overflow-hidden">
            <div class="px-6 py-4 bg-red-600">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Danger Zone
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900">Delete this subject</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($subject->contents_count > 0)
                                This subject has {{ $subject->contents_count }} content item(s) and cannot be deleted. Please reassign or delete the content first.
                            @else
                                Once you delete this subject, there is no going back. Please be certain.
                            @endif
                        </p>
                    </div>
                    @if($subject->contents_count == 0)
                        <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Are you absolutely sure you want to delete {{ $subject->name }}? This action cannot be undone.')"
                                class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition flex items-center"
                                {{ $subject->contents_count > 0 ? 'disabled' : '' }}>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Permanently Delete
                            </button>
                        </form>
                    @else
                        <button disabled
                            class="px-4 py-2 bg-gray-400 text-white font-medium rounded-lg cursor-not-allowed flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Cannot Delete
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
