@extends('layouts.app')

@section('title', $gradeLevel->name . ' Resources')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $gradeLevel->name }} - Curriculum Resources
    </h2>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Grade Level Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $gradeLevel->name }} Resources</h1>
                    <p class="text-gray-600 mt-1">Browse all curriculum materials for {{ $gradeLevel->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Resources</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $contents->total() }}</p>
                </div>
            </div>
        </div>

        <!-- Subjects Grid -->
        @if($subjects->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Subjects in {{ $gradeLevel->name }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($subjects as $subject)
                @php
                    $subjectCount = $contents->where('subject_id', $subject->id)->count();
                @endphp
                <a href="{{ route('contents.browse-subject', $subject) }}"
                   class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center hover:shadow-md transition duration-200">
                    <div class="text-lg font-semibold text-gray-900 mb-1">{{ $subject->name }}</div>
                    <div class="text-sm text-gray-500">{{ $subjectCount }} resources</div>
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
