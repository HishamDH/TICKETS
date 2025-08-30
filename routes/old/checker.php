<?php
use App\Http\Controllers\checker\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\checker\CheckController;


// Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
// Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');


Route::middleware(['auth', 'role:checker'])->group(function () {
    Route::get('', function () {
        return view('checker.dashboard.index');
    })->middleware('auth')->name('dashboard');

});


Route::resource('/check', CheckController::class)->names("check");
