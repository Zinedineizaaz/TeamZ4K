<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
{
    $event = [
        'title' => 'Dimsaykuu @ M-Bloc Space',
        'location' => 'M-Bloc Space, Blok M, Jakarta Selatan',
        'date' => '15 - 20 Januari 2026',
        'description' => 'Siapa yang nggak tahu M-Bloc? Tempat nongkrong paling hits di Jakarta Selatan! Dimsaykuu bakal hadir di sana buat nemenin waktu nongkrong kalian.',
        'image' => 'images/mblok.jpg', // <--- Pastikan pakai 'k' sesuai nama file Anda
        'whatsapp' => '6281234567890' 
    ];

    return view('user.events', compact('event'));
}
}