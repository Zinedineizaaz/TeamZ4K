@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header text-center fw-bold">
                    Login User
                </div>

                <div class="card-body">

                    {{-- PESAN ERROR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Email atau password salah
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Login
                        </button>

                        <div class="text-center mt-3">
                            <small>
                                Belum punya akun?
                                <a href="{{ route('register') }}">Daftar dulu</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
