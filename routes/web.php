<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FrontpagesController;
use App\Http\Controllers\SubscriberDashboardController;
use App\Http\Controllers\SubscriptionController;


// Frontend routes
Route::get('/', [FrontpagesController::class, 'index'])->name('home');
Route::get('/content', [FrontpagesController::class, 'contentAll'])->name('content.all');
Route::get('/content/{id}/{slug?}', [FrontpagesController::class, 'contentSingle'])->name('content.single');


Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isSubscriber()) {
            return redirect()->route('subscriber.dashboard');
        }
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
    Route::resource('contents', AdminContentController::class);
    Route::get('admin/contents/{content}/download', [AdminContentController::class, 'download'])->name('contents.download');
    // Admin Subscriber Management Routes
    Route::prefix('subscribers')->name('subscribers.')->group(function () {
        Route::get('/', [SubscriberController::class, 'index'])->name('index');
        Route::get('/create', [SubscriberController::class, 'create'])->name('create');
        Route::post('/', [SubscriberController::class, 'store'])->name('store');
        Route::get('/{subscriber}', [SubscriberController::class, 'show'])->name('show');
        Route::get('/{subscriber}/edit', [SubscriberController::class, 'edit'])->name('edit');
        Route::put('/{subscriber}', [SubscriberController::class, 'update'])->name('update');
        Route::delete('/{subscriber}', [SubscriberController::class, 'destroy'])->name('destroy');
        Route::post('/{subscriber}/toggle-status', [SubscriberController::class, 'toggleStatus'])->name('toggle-status');

        // Subscription management
        Route::get('/{subscriber}/subscriptions/create', [SubscriberController::class, 'createSubscription'])->name('subscriptions.create');
        Route::post('/{subscriber}/subscriptions', [SubscriberController::class, 'storeSubscription'])->name('subscriptions.store');
        });

    // Admin Plan Management Routes
    Route::prefix('plans')->name('plans.')->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('index');
        Route::get('/create', [PlanController::class, 'create'])->name('create');
        Route::post('/', [PlanController::class, 'store'])->name('store');
        Route::get('/{plan}', [PlanController::class, 'show'])->name('show');
        Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('edit');
        Route::put('/{plan}', [PlanController::class, 'update'])->name('update');
        Route::delete('/{plan}', [PlanController::class, 'destroy'])->name('destroy');
        Route::post('/{plan}/toggle-status', [PlanController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{plan}/set-default', [PlanController::class, 'setDefault'])->name('set-default');
    });

    Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('index');
    Route::get('/statistics', [PaymentController::class, 'statistics'])->name('statistics');
    Route::get('/export', [PaymentController::class, 'export'])->name('export');
    Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
    });
});

// Subscription Routes

Route::middleware(['auth'])->group(function () {
    Route::get('subscriber/dashboard', [SubscriberDashboardController::class, 'index'])->name('subscriber.dashboard');
    // Subscription Routes
    Route::get('/plans', [SubscriptionController::class, 'plans'])->name('subscriber.plans');
    Route::post('/subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscriber.subscribe');
    Route::get('/payment/{plan}', [SubscriptionController::class, 'initiatePayment'])->name('subscriber.payment.initiate');
    Route::get('/payment-history', [SubscriptionController::class, 'paymentHistory'])->name('subscriber.payment.history');
    // Content Routes
    Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
    Route::get('/contents/{content}', [ContentController::class, 'show'])->name('contents.show');
    Route::get('/contents/{content}/download', [ContentController::class, 'download'])->name('contents.download');
    Route::get('/contents/{content}/preview', [ContentController::class, 'preview'])->name('contents.preview');
    Route::get('/browse/grade/{gradeLevel}', [ContentController::class, 'browseByGrade'])->name('contents.browse-grade');
    Route::get('/browse/subject/{subject}', [ContentController::class, 'browseBySubject'])->name('contents.browse-subject');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/o/payment/callback', [SubscriptionController::class, 'paymentCallback'])->name('payment.callback');
    Route::get('/payment/cancelled', [SubscriptionController::class, 'paymentCancelled'])->name('payment.cancelled');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
