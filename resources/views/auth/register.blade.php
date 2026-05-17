@extends('layouts.app')
@section('title', 'Register')
@section('content')
    <div class="row justify-content-center" style="min-height: 80vh; align-items:
    center;">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Daftar Akun</h3>
                    {{-- Alert error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <div class="mb-3 position-relative">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control ps-5" id="name" placeholder="Masukkan nama"
                                required>
                            <i class="bi bi-person position-absolute" style="top: 38px;
    left: 15px; font-size: 1.1rem;"></i>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control ps-5" id="email"
                                placeholder="Masukkan email" required>
                            <i class="bi bi-envelope position-absolute" style="top:
    38px; left: 15px; font-size: 1.1rem;"></i>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control
    ps-5" id="password" placeholder="Masukkan password" required>
                            <i class="bi bi-lock position-absolute" style="top: 38px;
    left: 15px; font-size: 1.1rem;"></i>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control ps-5"
                                id="password_confirmation" placeholder="Konfirmasi
    password" required>
                            <i class="bi bi-lock-fill position-absolute" style="top:
    38px; left: 15px; font-size: 1.1rem;"></i>
                        </div>
                        <button class="btn btn-success w-100 mb-3">Daftar</button>
                    </form>
                    <div class="text-center">
                        <p class="mb-0">Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-primary fw-bold">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Custom style untuk ikon --}}
    <style>
        .position-relative i {
            color: #6c757d;
            pointer-events: none;
        }
    </style>
@endsection