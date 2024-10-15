<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTPController;
Route::get('/', function () {
    return view('welcome');
});

Route::post('/send-otp', [OTPController::class, 'sendOTP']);
Route::post('/verify-otp', [OTPController::class, 'verifyOTP']);

