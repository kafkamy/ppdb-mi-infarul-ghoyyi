@extends('layouts.app')

@section('title', 'Verifikasi Email Calon Siswa')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-5 col-lg-4 animate-fade-in">
        <div class="card border-0 shadow-lg p-3">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-check-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Verifikasi Email</h4>
                    <p class="text-muted small">Masukkan 6 digit kode yang telah dikirimkan ke <strong>{{ $email }}</strong></p>
                </div>

                <form method="POST" action="{{ route('siswa.verify') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="code" class="form-label text-center d-block">Kode Verifikasi</label>
                        <input type="text" class="form-control text-center fs-2 fw-bold tracking-widest @error('code') is-invalid @enderror" 
                               id="code" name="code" required autocomplete="off" maxlength="6" placeholder="000000" style="letter-spacing: 0.5rem;">
                        @error('code')
                            <div class="text-danger text-center small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm rounded-pill">
                            Verifikasi Kode <i class="bi bi-check2-all ms-1"></i>
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted small mb-1">Tidak menerima kode?</p>
                    <form action="{{ route('siswa.register') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="btn btn-link text-decoration-none fw-bold p-0 small">
                            Kirim Ulang Kode
                        </button>
                    </form>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('siswa.register') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-arrow-left"></i> Ganti Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
