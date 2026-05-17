@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="row justify-content-center" style="min-height: 80vh; align-items:
    center;">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Login</h3>
                    {{-- Alert error --}}
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
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
                        <button class="btn btn-primary w-100 mb-3">Login</button>
                    </form>
                    <div class="text-center">
                        <p class="mb-0">Belum punya akun?
                            <a href="{{ route('register') }}" class="text-primary fw-bold">Daftar Sekarang</a>
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
            transition: 0.2s;
        }

        .form-control:focus+i {
            color: #0d6efd;
        }
    </style>
@endsection