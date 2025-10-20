<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yabacon\Paystack;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function plans()
    {
        $plans = Plan::active()->get();
        $user = auth()->user();
        
        // Get user's current subscription info
        $currentSubscription = $user->currentSubscription();
        $hasActiveSubscription = $user->hasActivePaidSubscription();
        $hasActiveTrial = $user->hasActiveTrialSubscription();
        $hasUsedFreeTrial = $user->hasUsedFreeTrial();

        return view('subscriptions.plans', compact(
            'plans', 
            'currentSubscription',
            'hasActiveSubscription',
            'hasActiveTrial',
            'hasUsedFreeTrial'
        ));
    }

    public function subscribe(Request $request, Plan $plan)
    {
        $user = auth()->user();

        // Check if user already has active PAID subscription
        if ($user->hasActivePaidSubscription()) {
            return redirect()->route('contents.index')
                ->with('error', 'You already have an active subscription.');
        }

        // Check if user already used free trial
        $hasUsedFreeTrial = Subscription::where('user_id', $user->id)
            ->whereNotNull('free_access_started_at')
            ->exists();

        if ($hasUsedFreeTrial) {
            return redirect()->route('plans')
                ->with('error', 'You have already used your free trial. Please choose a paid plan to continue.');
        }

        // Start free trial (1 hour)
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => now()->addHour(), // 1 hour free access
            'is_active' => true,
            'free_access_started_at' => now(),
        ]);

        return redirect()->route('contents.index')
            ->with('success', 'Free 1-hour trial started! You have access to all content for 1 hour.');
    }

    public function initiatePayment(Plan $plan)
    {

        $user = auth()->user();

        // Check if user already has active PAID subscription
        if ($user->hasActivePaidSubscription()) {
            return redirect()->route('contents.index')
                ->with('error', 'You already have an active subscription.');
        }

        // Validate Paystack credentials
        $paystackSecret = env('PAYSTACK_SECRET_KEY');
        if (!$paystackSecret) {
            Log::error('Paystack secret key not configured');
            return redirect()->back()->with('error', 'Payment system configuration error. Please contact support.');
        }

        $payment = Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'payment_reference' => 'PSK_' . uniqid() . time(),
            'status' => 'pending',
        ]);

        try {
            $paystack = new Paystack($paystackSecret);
            
            Log::info('Initiating Paystack payment', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'reference' => $payment->payment_reference,
                'email' => $user->email
            ]);

            // Use the correct callback URL (without subscriber prefix)
            $callbackUrl = route('payment.callback');
            
            Log::info('Callback URL being used', ['callback_url' => $callbackUrl]);

            $transaction = $paystack->transaction->initialize([
                'email' => $user->email,
                'amount' => $plan->price * 100, // Paystack expects amount in kobo
                'reference' => $payment->payment_reference,
                'callback_url' => $callbackUrl,
                'metadata' => [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'payment_id' => $payment->id
                ]
            ]);

            // Log successful initialization
            Log::info('Paystack payment initialized successfully', [
                'reference' => $payment->payment_reference,
                'authorization_url' => $transaction->data->authorization_url
            ]);

            return redirect($transaction->data->authorization_url);

        } catch (\Exception $e) {
            // Log detailed error information
            Log::error('Paystack payment initialization failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'reference' => $payment->payment_reference,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'paystack_secret_set' => !empty($paystackSecret)
            ]);

            // Update payment status to failed
            $payment->update(['status' => 'failed']);

            return redirect()->back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');
        
        Log::info('Paystack callback received', [
            'reference' => $reference,
            'all_query_params' => $request->query(),
            'full_url' => $request->fullUrl()
        ]);

        if (!$reference) {
            Log::error('Paystack callback missing reference');
            return redirect()->route('subscriber.plans')->with('error', 'Invalid payment reference.');
        }

        $paystackSecret = env('PAYSTACK_SECRET_KEY');
        if (!$paystackSecret) {
            Log::error('Paystack secret key not configured in callback');
            return redirect()->route('subscriber.plans')->with('error', 'Payment system configuration error.');
        }

        try {
            $paystack = new Paystack($paystackSecret);
            $transaction = $paystack->transaction->verify([
                'reference' => $reference,
            ]);

            Log::info('Paystack verification response', [
                'reference' => $reference,
                'transaction_status' => $transaction->data->status ?? 'unknown',
                'transaction_data' => (array) $transaction->data
            ]);

            if ($transaction->data->status === 'success') {
                $payment = Payment::where('payment_reference', $reference)->first();

                if (!$payment) {
                    Log::error('Payment record not found for reference', ['reference' => $reference]);
                    return redirect()->route('subscriber.plans')->with('error', 'Payment record not found.');
                }

                $payment->update([
                    'status' => 'successful',
                    'paystack_response' => (array) $transaction->data,
                ]);

                $user = $payment->user;
                $plan = $payment->plan;

                // Deactivate any existing subscriptions
                Subscription::where('user_id', $user->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);

                // Create new PAID subscription
                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addMonths($plan->months),
                    'is_active' => true,
                    'free_access_started_at' => null,
                ]);

                Log::info('Payment successful and subscription created', [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'payment_id' => $payment->id,
                    'subscription_id' => $subscription->id
                ]);

                // Log the user in if they're not already (for callback scenarios)
                if (!auth()->check()) {
                    auth()->login($user);
                }

                return redirect()->route('contents.index')
                    ->with('success', 'Payment successful! Your subscription is now active.');
            }

            Log::warning('Paystack payment not successful', [
                'reference' => $reference,
                'status' => $transaction->data->status ?? 'unknown'
            ]);

            return redirect()->route('subscriber.plans')->with('error', 'Payment failed or was cancelled.');

        } catch (\Exception $e) {
            Log::error('Paystack verification failed', [
                'reference' => $reference,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);

            return redirect()->route('subscriber.plans')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    public function paymentHistory(Request $request)
    {
        $user = auth()->user();
        
        // Get user's payments with plan information
        $payments = Payment::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        // Payment statistics
        $totalPayments = $payments->total();
        $successfulPayments = Payment::where('user_id', $user->id)
            ->where('status', 'successful')
            ->count();
        $totalAmountPaid = Payment::where('user_id', $user->id)
            ->where('status', 'successful')
            ->sum('amount');

        return view('subscriptions.payment-history', compact(
            'payments',
            'totalPayments',
            'successfulPayments',
            'totalAmountPaid'
        ));
    }
}