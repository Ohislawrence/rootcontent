<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'plan'])
            ->select('payments.*')
            ->join('users', 'payments.user_id', '=', 'users.id')
            ->join('plans', 'payments.plan_id', '=', 'plans.id');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('payments.payment_reference', 'like', "%{$search}%")
                  ->orWhere('plans.name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('payments.status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('payments.created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('payments.created_at', '<=', $request->date_to);
        }

        // Filter by plan
        if ($request->has('plan_id') && $request->plan_id != '') {
            $query->where('payments.plan_id', $request->plan_id);
        }

        $payments = $query->latest('payments.created_at')->paginate(20);

        // Statistics
        $totalRevenue = Payment::where('status', 'successful')->sum('amount');
        $todayRevenue = Payment::where('status', 'successful')
            ->whereDate('created_at', today())
            ->sum('amount');
        $monthRevenue = Payment::where('status', 'successful')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        $totalTransactions = Payment::count();
        $successfulTransactions = Payment::where('status', 'successful')->count();

        $plans = Plan::active()->get();
        $statuses = ['pending', 'successful', 'failed', 'cancelled'];

        return view('admin.payments.index', compact(
            'payments',
            'totalRevenue',
            'todayRevenue',
            'monthRevenue',
            'totalTransactions',
            'successfulTransactions',
            'plans',
            'statuses'
        ));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'plan', 'user.subscriptions' => function($query) use ($payment) {
            $query->where('plan_id', $payment->plan_id)->latest();
        }]);

        return view('admin.payments.show', compact('payment'));
    }

    public function export(Request $request)
    {
        $query = Payment::with(['user', 'plan']);

        // Apply filters if any
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="payments_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

            // Headers
            fputcsv($file, [
                'Reference',
                'Subscriber Name',
                'Subscriber Email',
                'Plan',
                'Amount (₦)',
                'Status',
                'Payment Date',
                'Paystack Reference'
            ]);

            // Data
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->payment_reference,
                    $payment->user->name,
                    $payment->user->email,
                    $payment->plan->name,
                    number_format($payment->amount, 2),
                    ucfirst($payment->status),
                    $payment->created_at->format('Y-m-d H:i:s'),
                    $payment->paystack_response['reference'] ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function statistics()
    {
        // Daily revenue for the last 30 days
        $dailyRevenue = Payment::where('status', 'successful')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by plan
        $revenueByPlan = Payment::where('status', 'successful')
            ->join('plans', 'payments.plan_id', '=', 'plans.id')
            ->select(
                'plans.name as plan_name',
                DB::raw('SUM(payments.amount) as revenue'),
                DB::raw('COUNT(payments.id) as transactions')
            )
            ->groupBy('plans.id', 'plans.name')
            ->orderBy('revenue', 'desc')
            ->get();

        // Payment status distribution
        $statusDistribution = Payment::select(
            'status',
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('status')
        ->get();

        // Monthly revenue for the last 12 months
        $monthlyRevenue = Payment::where('status', 'successful')
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.payments.statistics', compact(
            'dailyRevenue',
            'revenueByPlan',
            'statusDistribution',
            'monthlyRevenue'
        ));
    }
}
