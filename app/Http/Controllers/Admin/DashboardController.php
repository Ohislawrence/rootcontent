<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Content;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\ContentView;
use App\Models\ContentDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalSubscribers = User::subscribers()->count();
        $activeSubscribers = User::subscribers()->active()->count();
        $totalContents = Content::count();
        $totalRevenue = Payment::successful()->sum('amount');

        // Today's Statistics
        $todaySubscribers = User::subscribers()->whereDate('created_at', today())->count();
        $todayRevenue = Payment::successful()->whereDate('created_at', today())->sum('amount');
        $todayPayments = Payment::whereDate('created_at', today())->count();

        // Monthly Statistics
        $monthSubscribers = User::subscribers()->whereMonth('created_at', now()->month)->count();
        $monthRevenue = Payment::successful()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Subscription Statistics
        $activeSubscriptions = Subscription::where('is_active', true)
            ->where('ends_at', '>', now())
            ->count();
        $trialSubscriptions = Subscription::where('is_active', true)
            ->where('ends_at', '>', now())
            ->whereNotNull('free_access_started_at')
            ->count();
        $paidSubscriptions = $activeSubscriptions - $trialSubscriptions;

        // Recent Activities
        $recentSubscribers = User::subscribers()
            ->with(['activeSubscription.plan'])
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['user', 'plan'])
            ->latest()
            ->take(5)
            ->get();

        $recentContents = Content::with(['user', 'gradeLevel', 'subject'])
            ->latest()
            ->take(5)
            ->get();

        // Chart Data - Monthly Revenue (Last 6 months)
        $monthlyRevenue = Payment::successful()
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M Y'),
                    'revenue' => $item->revenue
                ];
            });

        // Chart Data - Subscriber Growth (Last 6 months)
        $subscriberGrowth = User::subscribers()
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as subscribers')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M Y'),
                    'subscribers' => $item->subscribers
                ];
            });

        // Plan Performance
        $planPerformance = Plan::withCount([
            'subscriptions as active_subscriptions_count' => function ($query) {
                $query->where('is_active', true)
                      ->where('ends_at', '>', now());
            },
            'payments as successful_payments_count' => function ($query) {
                $query->where('status', 'successful');
            }
        ])
        ->withSum(['payments as total_revenue' => function ($query) {
            $query->where('status', 'successful');
        }], 'amount')
        ->get();

        // Content Statistics by Type
        $contentByType = Content::select('file_type', DB::raw('COUNT(*) as count'))
            ->groupBy('file_type')
            ->get();

        // Quick Stats
        $quickStats = [
            'pending_payments' => Payment::pending()->count(),
            'expiring_subscriptions' => Subscription::where('is_active', true)
                ->where('ends_at', '<=', now()->addDays(7))
                ->where('ends_at', '>', now())
                ->count(),
            'inactive_subscribers' => User::subscribers()->inactive()->count(),
            'total_plans' => Plan::active()->count(),
        ];

        $popularContent = Content::withCount(['views', 'downloads'])
            ->with(['gradeLevel', 'subject'])
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $mostDownloaded = Content::withCount(['views', 'downloads'])
            ->with(['gradeLevel', 'subject'])
            ->orderByDesc('downloads_count')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalSubscribers',
            'activeSubscribers',
            'totalContents',
            'totalRevenue',
            'todaySubscribers',
            'todayRevenue',
            'todayPayments',
            'monthSubscribers',
            'monthRevenue',
            'activeSubscriptions',
            'trialSubscriptions',
            'paidSubscriptions',
            'recentSubscribers',
            'recentPayments',
            'recentContents',
            'monthlyRevenue',
            'subscriberGrowth',
            'planPerformance',
            'contentByType',
            'quickStats',
            'popularContent',
            'mostDownloaded'
        ));
    }

    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'revenue');
        $period = $request->get('period', '6months');

        switch ($period) {
            case '1month':
                $startDate = now()->subMonth();
                break;
            case '3months':
                $startDate = now()->subMonths(3);
                break;
            case '1year':
                $startDate = now()->subYear();
                break;
            default:
                $startDate = now()->subMonths(6);
        }

        if ($type === 'revenue') {
            $data = Payment::successful()
                ->where('created_at', '>=', $startDate)
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(amount) as value')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $data = User::subscribers()
                ->where('created_at', '>=', $startDate)
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as value')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        return response()->json($data);
    }
}
