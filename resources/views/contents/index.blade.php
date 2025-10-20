@extends('layouts.app')

@section('title', 'Curriculum Content Library')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Curriculum Content Library
    </h2>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Subscription Status Banner -->
        @if($subscription && $subscription->free_access_started_at)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Free Trial Active
                        </h3>
                        <div class="mt-1 text-sm text-blue-700">
                            @php
                                $remainingMinutes = $subscription->getRemainingFreeTrialMinutes();
                            @endphp
                            @if($remainingMinutes > 0)
                                <p>Your free trial ends in <strong>{{ $remainingMinutes }} minutes</strong>. 
                                <a href="{{ route('subscriber.plans') }}" class="font-medium underline">Upgrade to continue access</a>.</p>
                            @else
                                <p>Your free trial has ended. 
                                <a href="{{ route('subscriber.plans') }}" class="font-medium underline">Upgrade to continue access</a>.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('subscriber.plans') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition duration-200">
                        Upgrade Now
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Resources</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $contents->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Subjects</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $subjects->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Grade Levels</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $gradeLevels->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="bg-orange-100 rounded-lg p-3 mr-4">
                        <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">File Types</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $fileTypeCounts->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filters</h3>

                    <!-- Search -->
                    <div class="mb-6">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               placeholder="Search resources..."
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Grade Level Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                        <select name="grade_level_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Grades</option>
                            @foreach($gradeLevels->groupBy('level') as $level => $levels)
                                <optgroup label="{{ ucfirst(str_replace('_', ' ', $level)) }}">
                                    @foreach($levels as $gradeLevel)
                                        <option value="{{ $gradeLevel->id }}" {{ request('grade_level_id') == $gradeLevel->id ? 'selected' : '' }}>
                                            {{ $gradeLevel->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select name="subject_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Subjects</option>
                            @foreach($subjects->groupBy('category') as $category => $categorySubjects)
                                <optgroup label="{{ ucfirst($category) }} Subjects">
                                    @foreach($categorySubjects as $subject)
                                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <!-- File Type Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">File Type</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="file_type" value="" {{ !request('file_type') ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm text-gray-700">All Types</span>
                            </label>
                            @foreach($fileTypeCounts as $fileType)
                            <label class="flex items-center">
                                <input type="radio" name="file_type" value="{{ $fileType->file_type }}"
                                       {{ request('file_type') == $fileType->file_type ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm text-gray-700 uppercase">
                                    {{ $fileType->file_type }} ({{ $fileType->count }})
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex space-x-2">
                        <button type="button" id="applyFilters" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                            Apply Filters
                        </button>
                        <a href="{{ route('contents.index') }}" class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200 text-center">
                            Reset
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="lg:w-3/4">
                <!-- Active Filters -->
                @if(request()->anyFilled(['search', 'grade_level_id', 'subject_id', 'file_type']))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.586V4z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-800">Active Filters:</span>
                        </div>
                        <a href="{{ route('contents.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Clear all</a>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @if(request('search'))
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Search: "{{ request('search') }}"
                            <button type="button" class="ml-1 text-blue-600 hover:text-blue-800" onclick="clearFilter('search')">×</button>
                        </span>
                        @endif
                        @if(request('grade_level_id'))
                        @php $selectedGrade = $gradeLevels->firstWhere('id', request('grade_level_id')); @endphp
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Grade: {{ $selectedGrade->name ?? 'Unknown' }}
                            <button type="button" class="ml-1 text-blue-600 hover:text-blue-800" onclick="clearFilter('grade_level_id')">×</button>
                        </span>
                        @endif
                        @if(request('subject_id'))
                        @php $selectedSubject = $subjects->firstWhere('id', request('subject_id')); @endphp
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Subject: {{ $selectedSubject->name ?? 'Unknown' }}
                            <button type="button" class="ml-1 text-blue-600 hover:text-blue-800" onclick="clearFilter('subject_id')">×</button>
                        </span>
                        @endif
                        @if(request('file_type'))
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Type: {{ strtoupper(request('file_type')) }}
                            <button type="button" class="ml-1 text-blue-600 hover:text-blue-800" onclick="clearFilter('file_type')">×</button>
                        </span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Content Grid -->
                @if($contents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($contents as $content)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition duration-200">
                        <!-- File Type Badge -->
                        <div class="flex justify-between items-start p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $content->file_type == 'pdf' ? 'red' : ($content->file_type == 'doc' || $content->file_type == 'docx' ? 'blue' : 'purple') }}-100 text-{{ $content->file_type == 'pdf' ? 'red' : ($content->file_type == 'doc' || $content->file_type == 'docx' ? 'blue' : 'purple') }}-800 uppercase">
                                {{ $content->file_type }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $content->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Content Body -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                {{ $content->title }}
                            </h3>

                            @if($content->description)
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                {{ $content->description }}
                            </p>
                            @endif

                            <!-- Metadata -->
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <span class="bg-gray-100 px-2 py-1 rounded mr-2">{{ $content->gradeLevel->name }}</span>
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $content->subject->name }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <a href="{{ route('contents.show', $content) }}"
                                   class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-md text-sm hover:bg-blue-700 transition duration-200">
                                    View Details
                                </a>
                                <a href="{{ route('contents.download', $content) }}"
                                   class="flex-1 bg-green-600 text-white text-center py-2 px-3 rounded-md text-sm hover:bg-green-700 transition duration-200">
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $contents->links() }}
                </div>
                @else
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No resources found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request()->anyFilled(['search', 'grade_level_id', 'subject_id', 'file_type']))
                            Try adjusting your filters or search terms.
                        @else
                            No curriculum resources available at the moment.
                        @endif
                    </p>
                    @if(request()->anyFilled(['search', 'grade_level_id', 'subject_id', 'file_type']))
                    <div class="mt-6">
                        <a href="{{ route('contents.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Clear Filters
                        </a>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Apply filters when button is clicked
        document.getElementById('applyFilters').addEventListener('click', function() {
            applyFilters();
        });

        // Apply filters when Enter is pressed in search
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });

        function applyFilters() {
            const search = document.getElementById('search').value;
            const gradeLevelId = document.querySelector('select[name="grade_level_id"]').value;
            const subjectId = document.querySelector('select[name="subject_id"]').value;
            const fileType = document.querySelector('input[name="file_type"]:checked')?.value || '';

            const params = new URLSearchParams();

            if (search) params.append('search', search);
            if (gradeLevelId) params.append('grade_level_id', gradeLevelId);
            if (subjectId) params.append('subject_id', subjectId);
            if (fileType) params.append('file_type', fileType);

            window.location.href = '{{ route("contents.index") }}?' + params.toString();
        }

        window.clearFilter = function(filterName) {
            const params = new URLSearchParams(window.location.search);
            params.delete(filterName);
            window.location.href = '{{ route("contents.index") }}?' + params.toString();
        };
    });
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
