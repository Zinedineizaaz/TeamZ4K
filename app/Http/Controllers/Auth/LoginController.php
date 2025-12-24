<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role !== 'user') {
            auth()->logout();

            return redirect('/login')
                ->withErrors(['email' => 'Akun ini bukan user.']);
        }

        return redirect('/home');
    }
}
