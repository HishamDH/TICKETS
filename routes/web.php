<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cart_controller;
use App\Http\Controllers\Checkout;
use App\Models\Offering;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpConfermation;
use App\Http\Controllers\offerView;
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

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::resource("/confermation",OtpConfermation::class)->names("otpConfermation");

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');
Route::post('register', [AuthController::class, 'store'])->middleware('guest:merchant')->name('signup');
Route::post('login', [AuthController::class, 'login'])->middleware('guest:merchant')->name('singin');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:merchant')->name('logout');

Route::get('status', function (Request $request) {
    if (!$request->session()->get('status', false))
        return redirect()->route('home');
    return view('auth.status', [
        'status' => $request->session()->get('status'),
    ]);
})->middleware('guest:merchant')->name('status');

Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('/{id}', function ($id) {
    $merchant = User::findOrFail($id);
    if ($merchant->status != 'active' || $merchant->role != 'merchant') {
        abort(404);
    }
    set_viewed($merchant->id);
    return view('template', compact('merchant'));
})->where(['id' => '[0-9]+'])->name('template');

Route::get('/{id}/{offering}', function ($id, Offering $offering) {
    $merchant = User::findOrFail($id);
    if ($offering->user_id != $merchant->id || $offering->status == 'inactive') {
        abort(404);
    }
    set_viewed($merchant->id);
    return view('templates.tmplate1.item', compact('merchant', 'offering'));
})->where(['id' => '[0-9]+', 'offering' => '[0-9]+'])->name('template1.item');

// Route::get('/cart-{template}', [Cart_controller::class, 'index'])
//     ->middleware(['auth:customer', 'verified_user'])
//     ->where('template', '[0-9]+')
//     ->name('cart');


Route::get('/view-{template}/{id}', [offerView::class, 'index'])
    //->middleware('auth:customer')
    ->where('template', '[0-9]+')
    ->name('offer_view');


Route::get('/{id}/checkout', [Checkout::class, 'paid'])
    ->middleware('auth:customer')
    ->name('template1.checkout.paid');
Route::get('/{id}/checkout/success', [Checkout::class, 'success'])
    ->middleware('auth:customer')
    ->name('template1.checkout.success');

Route::get('payment', function(){
    $response = Http::withHeaders([
        'x-api-key' => "", // المفتاح السري من .env
        'Content-Type' => 'application/json',
    ])->post('https://ticket-window.ottu.com/api/v3/checkout', [
        'amount' => 12, // بالـ fils = 10 KWD
        'currency' => 'SAR',
        'lang' => 'ar',
        'success_url' => route('payment.success'),
        'error_url' => route('payment.error'),
        'cancel_url' => route('payment.cancel'),
    ]);

    $data = $response->json();

    return view('payment', [
        'session_id' => $data['session_id'],
        'public_key' => "",
        'merchant_id' => 'ticket-window.ottu.com'
    ]);
})->name('payment');
Route::view('payment/error', 'payment')->name('payment.error');
Route::view('payment/cancel', 'payment')->name('payment.cancel');
Route::view('payment/success', 'payment')->name('payment.success');

