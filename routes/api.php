<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentCallbackController; // Panggil Controller Pilihanmu

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// URL Webhook untuk Dashboard Xendit: 
// https://dimsaykuu.vercel.app/api/payment/callback
Route::post('payment/callback', [PaymentCallbackController::class, 'handleCallback'])->name('api.payment.callback');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});