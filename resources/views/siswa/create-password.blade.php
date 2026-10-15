@extends('layouts.app')

@section('title', 'Buat Password Akun')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-5 col-lg-4 animate-fade-in">
        <div class="card border-0 shadow-lg p-3">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-key-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Buat Password</h4>
                    <p class="text-muted small">Buat password untuk mengamankan akun pendaftaran Anda dengan email <strong>{{ $email }}</strong></p>
                </div>

                <form method="POST" action="{{ route('siswa.create-password') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                   id="password" name="password" required autofocus placeholder="Minimal 8 karakter">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control border-start-0" 
                                   id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password">
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm rounded-pill">
                            Selesaikan Registrasi <i class="bi bi-check2-circle ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
