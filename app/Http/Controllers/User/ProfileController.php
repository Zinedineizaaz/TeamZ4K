<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        return back()->with('success', 'Profile berhasil diupdate');
    }
}
