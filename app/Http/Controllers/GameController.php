<?php

// app/Http/Controllers/GameController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GameController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah main hari ini?
        $today = Carbon::today();
        $alreadyPlayed = GameHistory::where('user_id', Auth::id())
                                    ->where('played_at', $today)
                                    ->exists();

        return view('game.index', compact('alreadyPlayed'));
    }

    public function play(Request $request)
    {
        $user = Auth::user();
        
        // 1. Validasi Manual (Checklist: Form Validation logic)
        $today = Carbon::today();
        if (GameHistory::where('user_id', $user->id)->where('played_at', $today)->exists()) {
            return back()->with('error', 'Eits, kamu sudah main hari ini! Kembali lagi besok ya.');
        }

        // 2. Logika Gacha (Checklist: Collection)
        // Kita bikin peluang: Zonk (50%), Diskon (40%), Gratis Dimsum (10%)
        $prizes = collect([
            'Zonk! Coba lagi besok 😜',
            'Zonk! Coba lagi besok 😜',
            'Zonk! Coba lagi besok 😜',
            'Zonk! Coba lagi besok 😜',
            'Zonk! Coba lagi besok 😜',
            'Voucher Diskon 5%',
            'Voucher Diskon 5%',
            'Voucher Diskon 10%',
            'Voucher Diskon 10%',
            'GRATIS 1 Porsi Siomay! 🎉'
        ]);

        // Acak hadiah
        $result = $prizes->random();

        // 3. Simpan ke Database (Checklist: CRUD - Create)
        GameHistory::create([
            'user_id' => $user->id,
            'prize' => $result,
            'played_at' => $today
        ]);

        // 4. Kirim hasil via Session (Checklist: Session)
        return back()->with('prize_result', $result);
    }
}
