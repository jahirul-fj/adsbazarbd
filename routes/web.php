<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassifiedAdController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\DesignerDashboardController;
use App\Http\Controllers\DisplayAdController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/track-ad', [HomeController::class, 'track'])->name('track');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Classified Ads
Route::get('/classified-advertisement', [ClassifiedAdController::class, 'index'])->name('classified.index');
Route::post('/classified-advertisement', [ClassifiedAdController::class, 'store'])->name('classified.store');
Route::get('/classified-advertisement/{trackingNo}', [ClassifiedAdController::class, 'show'])->name('classified.show');

// Display Ads
Route::get('/display-advertisement', [DisplayAdController::class, 'index'])->name('display.index');
Route::post('/display-advertisement', [DisplayAdController::class, 'store'])->name('display.store');
Route::get('/display-advertisement/{trackingNo}', [DisplayAdController::class, 'show'])->name('display.show');

// Designers
Route::get('/designers', [DesignerController::class, 'index'])->name('designers.index');
Route::get('/designers/{id}', [DesignerController::class, 'show'])->name('designers.show');
Route::get('/designers/{id}/hire', [DesignerController::class, 'hire'])->name('designers.hire');
Route::post('/designers/{id}/hire', [DesignerController::class, 'storeOrder'])->name('designers.storeOrder');

// Portal Selector & Quick Demo Logins
Route::get('/login', [AuthController::class, 'showPortalSelector'])->name('login');
Route::get('/portal-select', [AuthController::class, 'showPortalSelector'])->name('portal.select');
Route::get('/register', [AuthController::class, 'showClientRegister'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');

/*
|--------------------------------------------------------------------------
| 1. Admin Authentication & Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Auth
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout');

    // Protected Admin Panel
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/classified-ads', [AdminDashboardController::class, 'classifiedAds'])->name('classified');
        Route::post('/classified-ads/{id}/status', [AdminDashboardController::class, 'updateClassifiedStatus'])->name('classified.status');
        Route::get('/display-ads', [AdminDashboardController::class, 'displayAds'])->name('display');
        Route::post('/display-ads/{id}/status', [AdminDashboardController::class, 'updateDisplayStatus'])->name('display.status');
        Route::get('/newspapers', [AdminDashboardController::class, 'newspapers'])->name('newspapers');
        Route::post('/newspapers', [AdminDashboardController::class, 'storeNewspaper'])->name('newspapers.store');
        Route::post('/newspapers/{id}', [AdminDashboardController::class, 'updateNewspaper'])->name('newspapers.update');
        Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('categories');
        Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
        Route::get('/designers', [AdminDashboardController::class, 'designers'])->name('designers');
        Route::post('/designers/{id}/featured', [AdminDashboardController::class, 'toggleDesignerFeatured'])->name('designers.featured');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::get('/design-orders', [AdminDashboardController::class, 'designOrders'])->name('orders');
        Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments');
        Route::post('/payments/{id}/status', [AdminDashboardController::class, 'updatePaymentStatus'])->name('payments.status');
        Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminDashboardController::class, 'updateSettings'])->name('settings.update');
    });
});

/*
|--------------------------------------------------------------------------
| 2. Client Authentication & Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('client')->name('client.')->group(function () {
    // Client Auth
    Route::get('/login', [AuthController::class, 'showClientLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'clientLogin'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showClientRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'clientRegister'])->name('register.post');
    Route::post('/logout', [AuthController::class, 'clientLogout'])->name('logout');

    // Protected Client Dashboard
    Route::middleware(['client'])->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
        Route::get('/classified-ads', [ClientDashboardController::class, 'myClassifiedAds'])->name('classified');
        Route::get('/display-ads', [ClientDashboardController::class, 'myDisplayAds'])->name('display');
        Route::get('/orders', [ClientDashboardController::class, 'myDesignOrders'])->name('orders');
        Route::get('/orders/{id}', [ClientDashboardController::class, 'showOrder'])->name('order.show');
        Route::post('/orders/{id}/message', [ClientDashboardController::class, 'sendOrderMessage'])->name('order.message');
        Route::post('/orders/{id}/approve', [ClientDashboardController::class, 'approveOrder'])->name('order.approve');
        Route::post('/orders/{id}/review', [ClientDashboardController::class, 'submitReview'])->name('order.review');
    });
});

/*
|--------------------------------------------------------------------------
| 3. Designer Authentication & Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::prefix('designer')->name('designer.')->group(function () {
    // Designer Auth
    Route::get('/login', [AuthController::class, 'showDesignerLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'designerLogin'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showDesignerRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'designerRegister'])->name('register.post');
    Route::post('/logout', [AuthController::class, 'designerLogout'])->name('logout');

    // Protected Designer Dashboard
    Route::middleware(['designer'])->group(function () {
        Route::get('/dashboard', [DesignerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [DesignerDashboardController::class, 'myOrders'])->name('orders');
        Route::get('/orders/{id}', [DesignerDashboardController::class, 'showOrder'])->name('order.show');
        Route::post('/orders/{id}/message', [DesignerDashboardController::class, 'sendOrderMessage'])->name('order.message');
        Route::get('/profile', [DesignerDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [DesignerDashboardController::class, 'updateProfile'])->name('profile.update');
    });
});
