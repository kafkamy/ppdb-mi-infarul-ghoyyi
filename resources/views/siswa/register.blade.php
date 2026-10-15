@extends('layouts.app')

@section('title', 'Buat Akun Calon Siswa')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-5 col-lg-4 animate-fade-in">
        <div class="card border-0 shadow-lg p-3">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-envelope-plus-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Registrasi Akun</h4>
                    <p class="text-muted small">Masukkan email Anda untuk menerima kode verifikasi</p>
                </div>

                <form method="POST" action="{{ route('siswa.register') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Alamat Email Aktif</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                        </div>
                        <div class="form-text small text-muted mt-1">Pastikan email aktif untuk menerima kode verifikasi 6 digit.</div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm rounded-pill">
                            Kirim Kode Verifikasi <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted small mb-1">Sudah memiliki akun pendaftaran?</p>
                    <a href="{{ route('siswa.login') }}" class="text-decoration-none fw-bold text-primary small">
                        Login di sini
                    </a>
                </div>

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
