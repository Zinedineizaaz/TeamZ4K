@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center fw-bold">
                    Register User
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Daftar
                        </button>

                        <div class="text-center mt-3">
                            <small>
                                Sudah punya akun?
                                <a href="{{ route('login') }}">Login</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
