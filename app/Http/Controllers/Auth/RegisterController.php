<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    // 1. SETELAH REGISTER, ARAHKAN KE PROFILE
    protected $redirectTo = '/profile';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        // 2. BUAT USER BARU (ROLE OTOMATIS 'user')
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // Default role
            'last_login_at' => now(),
        ]);
    }

    // 3. FORCE AUTO LOGIN SETELAH REGISTER
    // Kita override fungsi register bawaan biar pasti login
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Login otomatis
        Auth::login($user);

        // Redirect ke halaman profile dengan pesan sukses
        return redirect($this->redirectPath())->with('status', 'Registrasi berhasil! Selamat datang di profil Anda.');
    }
}