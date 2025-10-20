@extends('layouts.app')

@section('title', $subject->name . ' Resources')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $subject->name }} - Curriculum Resources
    </h2>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Subject Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $subject->name }} Resources</h1>
                    <p class="text-gray-600 mt-1">Browse all {{ $subject->name }} curriculum materials across all grade levels</p>
                    <span class="inline-block mt-2 px-3 py-1 text-xs font-medium bg-{{ $subject->category == 'science' ? 'blue' : ($subject->category == 'arts' ? 'purple' : 'green') }}-100 text-{{ $subject->category == 'science' ? 'blue' : ($subject->category == 'arts' ? 'purple' : 'green') }}-800 rounded-full capitalize">
                        {{ $subject->category }} Subject
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Resources</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $contents->total() }}</p>
                </div>
            </div>
        </div>

        <!-- Grade Levels -->
        @if($gradeLevels->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Available Grade Levels</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($gradeLevels as $gradeLevel)
                @php
                    $gradeCount = $contents->where('grade_level_id', $gradeLevel->id)->count();
                @endphp
                <a href="{{ route('contents.browse-grade', $gradeLevel) }}" 
                   class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center hover:shadow-md transition duration-200">
                    <div class="text-lg font-semibold text-gray-900 mb-1">{{ $gradeLevel->name }}</div>
                    <div class="text-sm text-gray-500">{{ $gradeCount }} resources</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Content Grid -->
        @include('contents.partials.content-grid', ['contents' => $contents, 'showFilters' => false])
    </div>
</div>
@endsection