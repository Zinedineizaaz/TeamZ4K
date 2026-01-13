<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Import Controller Webhook yang baru saja kita buat
use App\Http\Controllers\XenditWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route untuk Webhook Xendit (Tanpa Auth Sanctum karena diakses oleh server Xendit)
Route::post('/xendit/callback', [XenditWebhookController::class, 'handle'])->name('xendit.webhook');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});