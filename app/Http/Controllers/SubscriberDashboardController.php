<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\ContentDownload;
use App\Models\ContentView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriberDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Current subscription info
        $currentSubscription = $user->currentSubscription();
        $hasActiveSubscription = $user->hasActivePaidSubscription();
        $hasActiveTrial = $user->hasActiveTrialSubscription();

        // Quick stats
        $totalContents = Content::count();
        $downloadedContents = ContentDownload::where('user_id', $user->id)->count();
        $viewedContents = ContentView::where('user_id', $user->id)->count();

        // Recent downloads
        $recentDownloads = ContentDownload::with('content.gradeLevel', 'content.subject')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Recent views
        $recentViews = ContentView::with('content.gradeLevel', 'content.subject')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Popular content (most downloaded by all users)
        $popularContent = Content::withCount('downloads')
            ->with(['gradeLevel', 'subject'])
            ->whereHas('downloads')
            ->orderByDesc('downloads_count')
            ->take(5)
            ->get();

        // Recent payments
        $recentPayments = Payment::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Subscription history
        $subscriptionHistory = Subscription::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Content by category stats
        $contentByGrade = Content::select('grade_level_id', DB::raw('COUNT(*) as count'))
            ->with('gradeLevel')
            ->groupBy('grade_level_id')
            ->get();

        $contentBySubject = Content::select('subject_id', DB::raw('COUNT(*) as count'))
            ->with('subject')
            ->groupBy('subject_id')
            ->get();

        return view('subscriber.dashboard', compact(
            'currentSubscription',
            'hasActiveSubscription',
            'hasActiveTrial',
            'totalContents',
            'downloadedContents',
            'viewedContents',
            'recentDownloads',
            'recentViews',
            'popularContent',
            'recentPayments',
            'subscriptionHistory',
            'contentByGrade',
            'contentBySubject'
        ));
    }
}