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
        No curriculum resources available for this category.
    </p>
    <div class="mt-6">
        <a href="{{ route('contents.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Back to Library
        </a>
    </div>
</div>
@endif
