<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Order; // Model Order untuk mengambil riwayat transaksi

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman utama profil user
     */
    public function index()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Menampilkan riwayat transaksi/pesanan user
     */
    public function history()
    {
        // Mengambil pesanan milik user yang sedang login, diurutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('user.history', compact('orders'));
    }

    /**
     * Memperbarui data profil dan foto avatar user
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. VALIDASI INPUT
        $request->validate([
            'name'     => 'required|string|max:255',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // 2. LOGIKA UPLOAD AVATAR
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada di storage agar tidak menumpuk
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan file baru ke folder 'avatars' di dalam disk 'public'
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. UPDATE NAMA & PASSWORD
        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Mengirimkan feedback sukses ke halaman sebelumnya
        return back()->with('status', 'Profil dan foto berhasil diperbarui!');
    }
}