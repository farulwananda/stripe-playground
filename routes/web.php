<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePayment\CheckoutController;
use App\Http\Controllers\StripePayment\CheckoutSuccessController;
use App\Http\Controllers\StripePayment\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn () => view('welcome'));

Route::get('/cancel', [ProductController::class, 'cancel'])->name('checkout.cancel');
Route::post('/webhook', [ProductController::class, 'webhook'])->name('checkout.webhook');










//! Coupon
Route::get('/v1/coupon', [ProductController::class, 'indexCoupon'])->name('coupon.index');
Route::get('/v1/coupon/create', [ProductController::class, 'showCreateCoupon'])->name('coupon.create');
Route::post('/v1/coupon', [ProductController::class, 'createCoupon'])->name('coupon.store');
Route::get('/v1/coupon/{id}', [ProductController::class, 'showCoupon'])->name('coupon.show');
Route::post('/v1/coupon/{id}', [ProductController::class, 'updateCoupon'])->name('coupon.update');


//! Promotion Codes
Route::get('/v1/promotion/{id}', [ProductController::class, 'indexPromotionCodes'])->name('promotion');
route::get('/v1/codes/{id}', [ProductController::class, 'showPromotionCodes'])->name('promotion.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/payment', [CheckoutController::class, 'index']);
    Route::post('/payment/charge', CheckoutController::class)->name('payment.charge');
    Route::get('/payment/success', CheckoutSuccessController::class)->name('payment.success');
    Route::get('/payment/{invoice}', InvoiceController::class)->name('payment.invoice');

    // ! Route stripe coupon management [Under Development]
    Route::resource('/v1/coupons', CouponController::class)->parameters(['v1/coupons' => 'coupons']);
    // ! Route stripe promotion code management [Under Development]
    Route::resource('/v1/codes', PromotionCodeController::class)->parameters(['v1/codes' => 'codes'])->only(['show', 'create', 'edit', 'destroy']);;
});

// ! Route stripe webhook [Under Development]
Route::post('/stripe/webhook', [StripeWebhookController::class, 'webhook'])->name('stripe.webhook');

require __DIR__ . '/auth.php';
