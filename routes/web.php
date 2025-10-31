<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\MerchantDiscountController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MerchantSubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatController;

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// المصادقة
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// المنتجات (العامة)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/new', [ProductController::class, 'newProducts'])->name('products.new');
Route::get('/products/used', [ProductController::class, 'usedProducts'])->name('products.used');
Route::get('/products/category/{categorySlug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// التقييمات
Route::middleware(['auth'])->group(function () {
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/ratings/{merchantId}', [RatingController::class, 'index'])->name('ratings.index');
});

// الرسائل والمحادثات
Route::middleware(['auth'])->group(function () {
    Route::post('/messages/contact/{productId}', [MessageController::class, 'contactMerchant'])->name('messages.contact');
    Route::post('/messages/contact-seller/{productId}', [MessageController::class, 'contactProductSeller'])->name('messages.contact-seller');
    Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::post('/messages/{id}/read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
    Route::get('/messages/conversation/{userId}', [MessageController::class, 'showConversation'])->name('messages.conversation');
    Route::post('/messages/conversation/{userId}/send', [MessageController::class, 'sendMessageInConversation'])->name('messages.send-conversation');
    Route::post('/messages/{messageId}/reply', [MessageController::class, 'replyToMessage'])->name('messages.reply');
});

// التجار
Route::get('/merchants', [MerchantController::class, 'merchantsList'])->name('merchants.index');
Route::get('/merchants/{id}', [MerchantController::class, 'show'])->name('merchants.show');
Route::get('/merchants/category/{category}', [MerchantController::class, 'byCategory'])->name('merchants.byCategory');

// لوحة تحكم التاجر
Route::middleware(['auth'])->prefix('merchant')->group(function () {
    Route::get('/dashboard', [MerchantController::class, 'dashboard'])->name('merchant.dashboard');
    Route::get('/products', [MerchantController::class, 'myProducts'])->name('merchant.products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('merchant.products.create');
    
    // تخفيضات التاجر
    Route::get('/discounts', [MerchantDiscountController::class, 'showDiscounts'])->name('merchant.discounts');
    Route::get('/discounts/create', [MerchantDiscountController::class, 'createDiscount'])->name('merchant.discounts.create');
    Route::post('/discounts/store', [MerchantDiscountController::class, 'storeDiscount'])->name('merchant.discounts.store');
    Route::get('/discounts/{id}/edit', [MerchantDiscountController::class, 'editDiscount'])->name('merchant.discounts.edit');
    Route::put('/discounts/{id}', [MerchantDiscountController::class, 'updateDiscount'])->name('merchant.discounts.update');
    Route::delete('/discounts/{id}', [MerchantDiscountController::class, 'removeDiscount'])->name('merchant.discounts.remove');
    
    // خطط الاشتراك
    Route::get('/subscription/plans', [MerchantSubscriptionController::class, 'plans'])->name('merchant.subscription.plans');
    Route::post('/subscription/{plan}', [MerchantSubscriptionController::class, 'subscribe'])->name('merchant.subscribe');
});

// نظام الدفع والاشتراكات
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
    Route::get('/payment/{plan}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/{plan}/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
});

// مسارات الاشتراك
Route::middleware(['auth'])->group(function () {
    Route::get('/subscription/history', [PaymentController::class, 'subscriptionHistory'])->name('subscription.history');
    Route::post('/subscription/cancel', [PaymentController::class, 'cancelSubscription'])->name('subscription.cancel');
});

// لوحة تحكم المستخدم العادي
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/products', [UserController::class, 'myProducts'])->name('user.products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('user.products.create');
});

// لوحة تحكم المدير
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/merchants', [AdminController::class, 'merchants'])->name('admin.merchants');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    
    // الملف الشخصي للمسؤول
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    
    // إدارة المستخدمين
    Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.user.toggle-status');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
    Route::get('/users/{id}', [AdminController::class, 'viewUser'])->name('admin.user.view');
    
    // إدارة المنتجات
    Route::post('/products/{id}/toggle-status', [AdminController::class, 'toggleProductStatus'])->name('admin.product.toggle-status');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
    
    // إدارة التجار
    Route::post('/merchants/{id}/toggle-status', [AdminController::class, 'toggleMerchantStatus'])->name('admin.merchant.toggle-status');
    Route::delete('/merchants/{id}', [AdminController::class, 'deleteMerchant'])->name('admin.merchant.delete');
    Route::get('/merchants/{id}/store', [AdminController::class, 'viewMerchantStore'])->name('admin.merchant.store');
    
    // تقارير الاشتراكات
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
    Route::get('/revenue', [AdminController::class, 'revenue'])->name('admin.revenue');
});

// التخفيضات
Route::get('/discounts', [DiscountController::class, 'discounts'])->name('discounts');
Route::get('/discounts/category/{categorySlug}', [DiscountController::class, 'categoryDiscounts'])->name('discounts.category');

// الشات العالمي
Route::middleware(['auth'])->prefix('chat')->group(function () {
    Route::get('/global', [ChatController::class, 'globalChat'])->name('chat.global');
    Route::post('/global/send', [ChatController::class, 'sendGlobalMessage'])->name('chat.global.send');
    Route::get('/global/messages', [ChatController::class, 'getGlobalMessages'])->name('chat.global.messages');
});

// الملف الشخصي وإدارة الحساب
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password.update');
    Route::get('/chat', [ProfileController::class, 'showChat'])->name('chat');
});

// المنتجات (تحتاج مصادقة) - مسارات مشتركة
Route::middleware(['auth'])->group(function () {
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// صفحات إضافية
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

// صفحة اختبار الدفع
Route::get('/test-payment', function() {
    return view('test-payment');
});

// إضافة هذه المسارات في ملف routes/web.php


Route::get('/test', function() {
    return '🎉 TEST: الموقع يعمل!';
});

Route::get('/', function() {
    return '🎉 الرئيسية تعمل!';
});
// الملف الشخصي وإدارة الحساب
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password.update');
    Route::get('/chat', [ProfileController::class, 'showChat'])->name('chat');
});

// للمسؤولين فقط
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // ... المسارات الحالية ...
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});
