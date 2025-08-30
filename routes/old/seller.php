<?php

use App\Http\Controllers\seller\Bookings_restaurant;
use App\Http\Controllers\seller\BranchController;
use App\Http\Controllers\seller\EventsController;
use App\Http\Controllers\seller\LoginController;
use App\Http\Controllers\seller\ProfileController;
use App\Http\Controllers\seller\Tickets_sellerController;
use Illuminate\Support\Facades\Route;

// Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
// Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');
// Route::get('register', [LoginController::class, 'register'])->middleware('guest')->name('register');
// Route::post('register', [LoginController::class, 'register_logic'])->middleware('guest')->name('register_logic');
Route::middleware(['auth','role:seller,restaurant'])->group(function () {
    Route::get('', function () {
        $withdraw_balance = 20;
        $hold_balance = 10;
        $available_balance = 20;
        $total_balance = $withdraw_balance + $hold_balance;

        $total_events = 10;
        $total_bookings = 15;
        $total_tickets = 25;
        $total_canceled = 50;
        return view('seller.dashboard.index', compact(
            'withdraw_balance',
            'hold_balance',
            'total_balance',
            'available_balance',
            'total_events',
            'total_bookings',
            'total_canceled'
        ));
    })->name('dashboard');
    Route::resource('events', EventsController::class)->middleware('role:seller');
    Route::get('events/gallery/{event}', [EventsController::class, 'edit_gallery'])->name('events.gallery')->middleware('role:seller');
    Route::resource('branch', BranchController::class)->middleware('role:restaurant');
    Route::get('branch/gallery/{branch}', [BranchController::class, 'edit_gallery'])->name('branch.gallery')->middleware('role:restaurant');

    Route::middleware(['auth', 'role:seller'])->group(function () {
        Route::get('sales', [Tickets_sellerController::class, 'index'])->name('sales-s');
    });

    Route::middleware(['auth', 'role:restaurant'])->group(function () {
        Route::get('reservations', [Bookings_restaurant::class, 'index'])->name('sales-r');
    });


    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
});



/*
Route::get('/branches',function(){
    return view('seller.dashboard.branches.index');
})->name('branches');*/
