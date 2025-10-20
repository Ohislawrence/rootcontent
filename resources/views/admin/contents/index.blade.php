@extends('layouts.app')

@section('title', 'Admin - Contents')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Content Management</h1>
                <p class="mt-2 text-gray-600">Manage and organize your educational resources efficiently.</p>
            </div>
            <a href="{{ route('admin.contents.create') }}" 
                class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Upload New Content
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center shadow-sm">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Content Table -->
        <div class="bg-white shadow rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Grade Level</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Subject</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">File Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($contents as $content)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                        @if($content->file_type === 'pdf')
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @elseif($content->file_type === 'video')
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $content->title }}</p>
                                        <p class="text-sm text-gray-500">Uploaded {{ $content->created_at->diffForHumans() }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $content->gradeLevel->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $content->subject->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 uppercase">
                                        {{ $content->file_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center space-x-3">
                                    <a href="#" class="text-blue-600 hover:text-blue-900" title="View">
                                        <x-heroicon-o-eye class="w-5 h-5 inline" />
                                    </a>
                                    <a href="#" class="text-green-600 hover:text-green-900" title="Edit">
                                        <x-heroicon-o-pencil-square class="w-5 h-5 inline" />
                                    </a>
                                    <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900" title="Delete">
                                            <x-heroicon-o-trash class="w-5 h-5 inline" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-gray-700 font-medium mb-1">No content found</p>
                                        <p class="text-sm text-gray-500 mb-3">Get started by uploading your first educational resource.</p>
                                        <a href="{{ route('admin.contents.create') }}" 
                                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">
                                            Upload Content
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 text-sm text-gray-600 border-t">
                Showing {{ $contents->count() }} {{ Str::plural('item', $contents->count()) }}
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $stats = [
                    ['title' => 'Total Contents', 'count' => $contents->count(), 'color' => 'blue', 'icon' => 'document'],
                    ['title' => 'Grade Levels', 'count' => $contents->pluck("gradeLevel.name")->unique()->count(), 'color' => 'green', 'icon' => 'academic-cap'],
                    ['title' => 'Subjects', 'count' => $contents->pluck("subject.name")->unique()->count(), 'color' => 'purple', 'icon' => 'book-open'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 p-3 rounded-lg bg-{{ $stat['color'] }}-100">
                            <x-dynamic-component :component="'heroicon-o-' . $stat['icon']" class="w-6 h-6 text-{{ $stat['color'] }}-600"/>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ $stat['title'] }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stat['count'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
