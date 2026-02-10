<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Subject;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class FrontpagesController extends Controller
{
    public function index()
    {
        // Get popular and recent content for homepage
        $popularContent = Content::with(['subject', 'gradeLevel', 'user'])
            ->popular()
            ->take(6)
            ->get();

        $recentContent = Content::with(['subject', 'gradeLevel', 'user'])
            ->recent(30)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $subjects = Subject::all();
        $gradeLevels = GradeLevel::all();

        return view('welcome', compact('popularContent', 'recentContent', 'subjects', 'gradeLevels'));
    }

    public function contentAll(Request $request)
    {
        $query = Content::with(['subject', 'gradeLevel', 'user']);

        // Apply filters if provided
        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('grade_level_id') && $request->grade_level_id) {
            $query->where('grade_level_id', $request->grade_level_id);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'popular':
                $query->popular();
                break;
            case 'downloaded':
                $query->mostDownloaded();
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $content = $query->paginate(12);
        $subjects = Subject::all();
        $gradeLevels = GradeLevel::all();

        return view('content.all', compact('content', 'subjects', 'gradeLevels'));
    }

    public function contentSingle($id, $slug = null)
    {
        // Find content by ID (ignore slug for database lookup)
        $content = Content::with(['subject', 'gradeLevel', 'user', 'views', 'downloads'])
            ->findOrFail($id);

        // Increment view count
        /**
        $content->views()->create([
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
         */
        // Generate expected slug from title
        $expectedSlug = $this->generateSlug($content->title);

        // If slug doesn't match or is missing, redirect to correct URL
        if ($slug !== $expectedSlug) {
            return redirect()->route('content.single', ['id' => $id, 'slug' => $expectedSlug], 301);
        }

        // Get related content
        $relatedContent = Content::where('subject_id', $content->subject_id)
            ->where('id', '!=', $content->id)
            ->with(['subject', 'gradeLevel'])
            ->take(4)
            ->get();

        return view('content.single', compact('content', 'relatedContent'));
    }

    /**
     * Generate URL slug from title
     */
    private function generateSlug($title)
    {
        // Convert to lowercase
        $slug = strtolower($title);

        // Replace spaces with hyphens
        $slug = str_replace(' ', '-', $slug);

        // Remove special characters
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim hyphens from beginning and end
        $slug = trim($slug, '-');

        return $slug;
    }


}
