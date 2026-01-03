<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update Nama
        $user->name = $request->name;

        // Update Avatar jika ada upload
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika bukan bawaan (opsional)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Simpan yang baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Update Password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('status', 'Profil berhasil diperbarui!');
    }
}