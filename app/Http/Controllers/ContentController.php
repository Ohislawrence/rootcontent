<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\ContentView;
use App\Models\ContentDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.contents.index');
        }

        // Check subscription status
        $subscription = $user->currentSubscription();
        
        if (!$subscription) {
            return redirect()->route('subscriber.plans')
                ->with('error', 'Please subscribe to access content. Start with a free 1-hour trial or choose a paid plan.');
        }

        // Check if free trial has expired
        if ($subscription->free_access_started_at && $subscription->hasFreeAccessExpired()) {
            // Deactivate the expired trial subscription
            $subscription->update(['is_active' => false]);
            
            return redirect()->route('subscriber.plans')
                ->with('error', 'Your free trial has expired. Please choose a paid plan to continue accessing content.');
        }

        // Get filter parameters
        $gradeLevelId = $request->get('grade_level_id');
        $subjectId = $request->get('subject_id');
        $search = $request->get('search');
        $fileType = $request->get('file_type');

        // Build query with filters
        $query = Content::with(['gradeLevel', 'subject'])
            ->when($gradeLevelId, function ($query, $gradeLevelId) {
                return $query->where('grade_level_id', $gradeLevelId);
            })
            ->when($subjectId, function ($query, $subjectId) {
                return $query->where('subject_id', $subjectId);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($fileType, function ($query, $fileType) {
                return $query->where('file_type', $fileType);
            });

        $contents = $query->latest()->paginate(12);
        $gradeLevels = GradeLevel::orderBy('order')->get();
        $subjects = Subject::orderBy('name')->get();

        // File type counts for filter
        $fileTypeCounts = Content::select('file_type', \DB::raw('COUNT(*) as count'))
            ->groupBy('file_type')
            ->get();

        return view('contents.index', compact(
            'contents',
            'subscription',
            'gradeLevels',
            'subjects',
            'fileTypeCounts'
        ));
    }

    public function show(Content $content)
    {
        $user = auth()->user();
        $subscription = $user->currentSubscription();

        if (!$this->checkSubscriptionAccess($subscription)) {
            return redirect()->route('subscriber.plans')
                ->with('error', 'Please subscribe to view content. Start with a free 1-hour trial or choose a paid plan.');
        }

        // Track content view
        $this->trackContentView($content);

        // Get related content
        $relatedContents = Content::where('id', '!=', $content->id)
            ->where(function ($query) use ($content) {
                $query->where('grade_level_id', $content->grade_level_id)
                      ->orWhere('subject_id', $content->subject_id);
            })
            ->with(['gradeLevel', 'subject'])
            ->take(4)
            ->get();

        return view('contents.show', compact('content', 'subscription', 'relatedContents'));
    }

    public function download(Content $content)
    {
        $user = auth()->user();
        $subscription = $user->currentSubscription();

        if (!$this->checkSubscriptionAccess($subscription)) {
            return redirect()->route('subscriber.plans')
                ->with('error', 'Please subscribe to download content. Start with a free 1-hour trial or choose a paid plan.');
        }

        // Track download
        $this->trackContentDownload($content);

        if (!Storage::disk('public')->exists($content->file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($content->file_path, $this->generateDownloadName($content));
    }

    public function preview(Content $content)
    {
        $user = auth()->user();
        $subscription = $user->currentSubscription();

        if (!$this->checkSubscriptionAccess($subscription)) {
            return response()->json(['error' => 'Subscription required'], 403);
        }

        // Track preview
        $this->trackContentView($content);

        $filePath = Storage::disk('public')->path($content->file_path);

        // For PDF files, return embedded view
        if ($content->file_type === 'pdf') {
            return response()->file($filePath);
        }

        // For other file types, provide download or message
        return response()->json([
            'message' => 'Preview not available for this file type. Please download the file.',
            'download_url' => route('contents.download', $content)
        ]);
    }

    public function browseByGrade(GradeLevel $gradeLevel)
    {
        $user = auth()->user();
        $subscription = $user->currentSubscription();

        if (!$this->checkSubscriptionAccess($subscription)) {
            return redirect()->route('subscriber.plans')
                ->with('error', 'Please subscribe to access content.');
        }

        $contents = Content::with(['gradeLevel', 'subject'])
            ->where('grade_level_id', $gradeLevel->id)
            ->latest()
            ->paginate(12);

        $subjects = Subject::whereIn('id',
            Content::where('grade_level_id', $gradeLevel->id)
                ->distinct()
                ->pluck('subject_id')
        )->get();

        return view('contents.browse-grade', compact('contents', 'gradeLevel', 'subjects', 'subscription'));
    }

    public function browseBySubject(Subject $subject)
    {
        $user = auth()->user();
        $subscription = $user->currentSubscription();

        if (!$this->checkSubscriptionAccess($subscription)) {
            return redirect()->route('subscriber.plans')
                ->with('error', 'Please subscribe to access content.');
        }

        $contents = Content::with(['gradeLevel', 'subject'])
            ->where('subject_id', $subject->id)
            ->latest()
            ->paginate(12);

        $gradeLevels = GradeLevel::whereIn('id',
            Content::where('subject_id', $subject->id)
                ->distinct()
                ->pluck('grade_level_id')
        )->get();

        return view('contents.browse-subject', compact('contents', 'subject', 'gradeLevels', 'subscription'));
    }

    private function checkSubscriptionAccess($subscription)
    {
        if (!$subscription) {
            return false;
        }

        // Check if free trial has expired
        if ($subscription->free_access_started_at && $subscription->hasFreeAccessExpired()) {
            // Deactivate the expired trial
            $subscription->update(['is_active' => false]);
            return false;
        }

        return true;
    }


    private function generateDownloadName(Content $content)
    {
        $extension = pathinfo($content->file_path, PATHINFO_EXTENSION);
        $cleanTitle = Str::slug($content->title);
        return "{$cleanTitle}-{$content->gradeLevel->name}-{$content->subject->name}.{$extension}";
    }

    private function trackContentView(Content $content)
    {
        // Prevent duplicate views in same session (optional)
        $viewKey = 'content_viewed_' . $content->id;
        if (!session()->has($viewKey)) {
            ContentView::create([
                'content_id' => $content->id,
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            // Set session to prevent duplicate views in same session
            session([$viewKey => now()]);
        }
    }

    private function trackContentDownload(Content $content)
    {
        ContentDownload::create([
            'content_id' => $content->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public function myActivity()
    {
        $user = auth()->user();

        if (!$this->checkSubscriptionAccess($user->currentSubscription())) {
            return redirect()->route('subscriber.plans')
                ->with('error', 'Please subscribe to access content.');
        }

        $recentViews = ContentView::with('content.gradeLevel', 'content.subject')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentDownloads = ContentDownload::with('content.gradeLevel', 'content.subject')
            ->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('contents.my-activity', compact('recentViews', 'recentDownloads'));
    }
}
