@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header fw-bold text-center">
                    Profile Saya
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- AVATAR --}}
                        <div class="text-center mb-3">
                            <img src="{{ $user->avatar
    ? asset('storage/' . $user->avatar)
    : asset('images/default-avatar.png') }}"
    class="rounded-circle"
    width="120"
    height="120"
    style="object-fit: cover;">

                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Avatar</label>
                            <input type="file" name="avatar" class="form-control">
                        </div>

                        {{-- NAME --}}
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        {{-- EMAIL (READONLY) --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control"
                                   value="{{ $user->email }}" disabled>
                        </div>

                        <button class="btn btn-primary w-100">
                            Simpan Perubahan
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
