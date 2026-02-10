@extends('layouts.app')

@section('title', $content->title . ' - EduResource')

@section('content')
<section class="relative z-10 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('content.all') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Resources
            </a>
        </div>

        <!-- Content Header -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-wrap gap-2 mb-6">
                <span class="px-4 py-2 bg-blue-100 text-blue-600 font-semibold rounded-full">
                    {{ $content->subject->name ?? 'General' }}
                </span>
                <span class="px-4 py-2 bg-purple-100 text-purple-600 font-semibold rounded-full">
                    {{ $content->gradeLevel->name ?? 'All Grades' }}
                </span>
                <span class="px-4 py-2 bg-gray-100 text-gray-600 font-semibold rounded-full">
                    {{ ucfirst($content->file_type) }}
                </span>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ $content->title }}</h1>

            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                        {{ substr($content->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-medium">{{ $content->user->name }}</div>
                        <div class="text-sm text-gray-500">Posted {{ $content->created_at->diffForHumans() }}</div>
                    </div>
                </div>


            </div>

            <!-- Description -->
            <div class="prose max-w-none mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Description</h3>
                <p class="text-gray-700 leading-relaxed">{{ $content->description }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-4">
                <button onclick="shareContent()"
                        class="bg-gradient-to-r from-blue-500 to-cyan-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center">
                    <i class="fas fa-share-alt mr-2"></i>
                    Share
                </button>
            </div>
        </div>

        <!-- Related Content -->
        @if($relatedContent->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Resources</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($relatedContent as $related)
                        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">
                                    {{ $related->subject->name ?? 'General' }}
                                </span>
                                <span class="px-3 py-1 bg-purple-100 text-purple-600 text-xs font-semibold rounded-full">
                                    {{ $related->gradeLevel->name ?? 'All Grades' }}
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $related->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($related->description, 80) }}</p>
                            <a href="{{ route('content.single', ['id' => $related->id, 'slug' => Illuminate\Support\Str::slug($related->title)]) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                View Resource →
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
function shareContent() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $content->title }}',
            text: 'Check out this educational resource on EduResource',
            url: window.location.href,
        })
        .then(() => console.log('Successful share'))
        .catch((error) => console.log('Error sharing:', error));
    } else {
        // Fallback: Copy to clipboard
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copied to clipboard!');
        });
    }
}
</script>
@endpush
@endsection
