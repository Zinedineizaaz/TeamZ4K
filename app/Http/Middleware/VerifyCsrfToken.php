<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Izinkan Xendit untuk mengirim laporan pembayaran otomatis (Webhook)
        '/api/xendit/callback',
        '/api/xendit/webhook',
        'api/xendit/webhook', // Mengizinkan akses luar tanpa token CSRF untuk Webhook Xendit
        'api/xendit/callback', // Izinkan Xendit mengirim data ke sini
    ];
}