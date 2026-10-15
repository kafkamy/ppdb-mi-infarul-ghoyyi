@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-5 col-lg-4 animate-fade-in">
        <div class="card border-0 shadow-lg p-3">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-lock fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Login Administrator</h4>
                    <p class="text-muted small">Silakan masuk untuk mengelola PPDB</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@ppdb.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key-fill"></i></span>
                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                   id="password" name="password" required placeholder="••••••••">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-muted small" for="remember">Ingat Saya</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </button>
                    </div>
                </form>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('welcome') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
