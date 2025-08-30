<?php

use App\Http\Controllers\employee\CheckController;
use App\Http\Controllers\employee\LoginController;
//use App\Models\SupportTicket;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\employee\SupportController;
use Psy\VersionUpdater\Checker;

// Route::get('login', [LoginController::class, 'login'])->middleware('guest')->name('login');
// Route::post('login', [LoginController::class, 'login_logic'])->middleware('guest')->name('login_logic');
// Route::get('register', [LoginController::class, 'register'])->middleware('guest')->name('register');
// Route::post('register', [LoginController::class, 'register_logic'])->middleware('guest')->name('register_logic');


Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('', function () {
        return view('employee.dashboard.index');
    })->middleware('auth')->name('dashboard');


    Route::resource('/support', SupportController::class)->names("support");


    // Route::get('/support',function(){
    //     return view('employee.dashboard.support');
    // })->middleware('auth')->name('support');

});


/*
Route::get('/employee', function () {
    $employee = [];
    return view('employee.dashboard.employees', compact('employee'));
})->name('employee');*/
Route::resource('/check', CheckController::class)->names("check");
