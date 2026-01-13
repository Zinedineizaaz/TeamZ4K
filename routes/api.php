<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\XenditWebhookController;
use App\Http\Controllers\PaymentCallbackController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route untuk Webhook Xendit (Tanpa Auth Sanctum karena diakses oleh server Xendit)
Route::post('/xendit/callback', [XenditWebhookController::class, 'handle'])->name('xendit.webhook');
Route::post('payment/callback', [PaymentCallbackController::class, 'handleCallback']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});