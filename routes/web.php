<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MerchantDiscountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RatingController;

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// المصادقة
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// المنتجات
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/used', [ProductController::class, 'usedProducts'])->name('products.used');
Route::get('/products/new', [ProductController::class, 'newProducts'])->name('products.new');
Route::get('/products/category/{categoryId}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// التجار
Route::get('/merchants', [MerchantController::class, 'merchantsList'])->name('merchants.index');
Route::get('/merchants/category/{category}', [MerchantController::class, 'byCategory'])->name('merchants.byCategory');
Route::get('/merchants/{id}', [MerchantController::class, 'show'])->name('merchants.show');

// التقييمات
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

// المسارات التي تتطلب تسجيل الدخول
Route::middleware(['auth'])->group(function () {
    // لوحة المستخدم العادي
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/products', [UserController::class, 'myProducts'])->name('user.products');
    
    // إدارة المنتجات
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // لوحة التاجر
    Route::get('/merchant/dashboard', [MerchantController::class, 'dashboard'])->name('merchant.dashboard');
    Route::get('/merchant/products', [MerchantController::class, 'myProducts'])->name('merchant.products');
    
    // تخفيضات التاجر
    Route::get('/merchant/discounts', [MerchantDiscountController::class, 'index'])->name('merchant.discounts');
    Route::post('/merchant/discounts', [MerchantDiscountController::class, 'store'])->name('merchant.discounts.store');
    Route::delete('/merchant/discounts/{id}', [MerchantDiscountController::class, 'destroy'])->name('merchant.discounts.destroy');
    
    // لوحة الأدمن
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::put('/admin/users/{id}/toggle', [AdminController::class, 'toggleUser'])->name('admin.users.toggle');
    Route::put('/admin/products/{id}/toggle', [AdminController::class, 'toggleProduct'])->name('admin.products.toggle');
});
