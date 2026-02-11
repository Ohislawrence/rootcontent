@extends('layouts.app')

@section('title', 'Add New Subject')

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
                <h1 class="text-2xl font-bold text-gray-900">Add New Subject</h1>
            </div>
            <p class="mt-2 text-gray-600">Create a new subject for your educational resources.</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.subjects.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Subject Information
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
                               value="{{ old('name') }}"
                               class="block w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 @error('name') border-red-500 @enderror"
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
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 @error('category') border-red-500 @enderror"
                                required>
                            <option value="">Select a category</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
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
                                                       {{ in_array($grade->id, old('grade_levels', [])) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
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
                                  class="block w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 @error('description') border-red-500 @enderror"
                                  placeholder="Provide a brief description of this subject...">{{ old('description') }}</textarea>
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
                                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 {{ old('icon') == $icon ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <input type="radio" name="icon" value="{{ $icon }}" {{ old('icon') == $icon ? 'checked' : '' }} class="sr-only">
                                    <i class="fas fa-{{ $icon }} text-2xl {{ old('icon') == $icon ? 'text-blue-600' : 'text-gray-500' }}"></i>
                                    <span class="text-xs mt-1 {{ old('icon') == $icon ? 'text-blue-600 font-semibold' : 'text-gray-500' }}">{{ $icon }}</span>
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
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900">Active</span>
                        </label>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.subjects.index') }}"
                        class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Subject
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips Card -->
        <div class="mt-6 bg-blue-50 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-blue-800">Tips for creating subjects</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Use clear, standard subject names (e.g., "Mathematics" instead of "Maths")</li>
                            <li>Select appropriate grade levels to ensure content reaches the right audience</li>
                            <li>Add a descriptive summary to help educators understand the subject scope</li>
                            <li>Choose an icon that represents the subject visually</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
