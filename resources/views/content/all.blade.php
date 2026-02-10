@extends('layouts.guest')

@section('title', 'Browse Content')

@section('content')

    <!-- Hero Section -->
    <section class="relative z-10 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                    Browse Educational
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Resources</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Discover our comprehensive collection of learning materials, curated by educators for students of all levels.
                </p>

                <!-- Search and Filter -->
                <form method="GET" action="{{ route('content.all') }}" class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Search resources...">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select name="subject_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                            <select name="grade_level_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Grades</option>
                                @foreach($gradeLevels as $grade)
                                    <option value="{{ $grade->id }}" {{ request('grade_level_id') == $grade->id ? 'selected' : '' }}>
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Filter Resources
                        </button>
                    </div>
                </form>

                <!-- Sorting -->
                <div class="flex justify-center space-x-4 mb-8">
                    <a href="{{ route('content.all', array_merge(request()->except('sort'), ['sort' => 'recent'])) }}"
                       class="px-4 py-2 rounded-lg font-medium {{ request('sort', 'recent') == 'recent' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <i class="fas fa-clock mr-2"></i>
                        Most Recent
                    </a>
                    <a href="{{ route('content.all', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}"
                       class="px-4 py-2 rounded-lg font-medium {{ request('sort') == 'popular' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <i class="fas fa-fire mr-2"></i>
                        Most Popular
                    </a>
                    <a href="{{ route('content.all', array_merge(request()->except('sort'), ['sort' => 'downloaded'])) }}"
                       class="px-4 py-2 rounded-lg font-medium {{ request('sort') == 'downloaded' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <i class="fas fa-download mr-2"></i>
                        Most Downloaded
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Grid -->
    <section class="relative z-10 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @if($content->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($content as $item)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">
                                        {{ $item->subject->name ?? 'General' }}
                                    </span>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-600 text-xs font-semibold rounded-full">
                                        {{ $item->gradeLevel->name ?? 'All Grades' }}
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($item->description, 100) }}</p>

                                <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
                                    <div class="flex items-center">
                                        <i class="fas fa-eye mr-1"></i>
                                        <span>{{ $item->views_count }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-download mr-1"></i>
                                        <span>{{ $item->downloads_count }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <span>{{ $item->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('content.single', ['id' => $item->id, 'slug' => Str::slug($item->title)]) }}"
                                   class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-3 rounded-lg font-semibold hover:shadow-lg transition-shadow duration-300">
                                    View Resource
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $content->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-6">
                        <i class="fas fa-search text-gray-300 text-6xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-3">No Resources Found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('content.all') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-shadow duration-300">
                        Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </section>

@endsection
