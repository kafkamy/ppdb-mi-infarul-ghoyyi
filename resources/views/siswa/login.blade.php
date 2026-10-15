@extends('layouts.app')

@section('title', 'Portal Calon Siswa')

@section('styles')
<style>
    .auth-tab-btn {
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        color: #64748b;
        cursor: pointer;
        transition: all 0.25s ease;
        border-radius: 0;
        width: 50%;
    }
    .auth-tab-btn.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }
    .auth-tab-btn:hover:not(.active) {
        color: #334155;
        background: rgba(21,128,61,0.04);
    }
    .auth-panel { display: none; }
    .auth-panel.active { display: block; }
    .tab-bar {
        display: flex;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 62vh;">
    <div class="col-md-5 col-lg-4 animate-fade-in">
        {{-- Header --}}
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 64px; height: 64px;">
                <i class="bi bi-mortarboard-fill fs-1"></i>
            </div>
            <h4 class="fw-bold text-dark mb-0">Portal Calon Siswa</h4>
            <p class="text-muted small mb-0">MI Infarul Ghoyyi Kalijambe</p>
        </div>

        <div class="card border-0 shadow-lg">
            {{-- Tab Bar --}}
            <div class="tab-bar px-0 mx-0">
                <button class="auth-tab-btn {{ session('_tab') !== 'register' && !$errors->has('reg_email') && !$errors->has('reg_password') ? 'active' : '' }}"
                        id="tab-login" onclick="switchTab('login')">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </button>
                <button class="auth-tab-btn {{ session('_tab') === 'register' || $errors->has('reg_email') || $errors->has('reg_password') ? 'active' : '' }}"
                        id="tab-register" onclick="switchTab('register')">
                    <i class="bi bi-person-plus-fill me-1"></i> Buat Akun
                </button>
            </div>

            <div class="card-body px-4 pb-4 pt-0">

                {{-- ===== PANEL LOGIN ===== --}}
                <div id="panel-login" class="auth-panel {{ session('_tab') !== 'register' && !$errors->has('reg_email') && !$errors->has('reg_password') ? 'active' : '' }}">
                    <form method="POST" action="{{ route('siswa.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="login_email" class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email"
                                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                                       id="login_email" name="email"
                                       value="{{ old('email') }}"
                                       required autofocus
                                       placeholder="contoh@email.com">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="login_password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key-fill"></i></span>
                                <input type="password"
                                       class="form-control border-start-0 @error('password') is-invalid @enderror"
                                       id="login_password" name="password"
                                       required placeholder="••••••••">
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
                            <button type="submit" class="btn btn-primary py-2 fw-bold rounded-pill">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-muted small">Belum punya akun? </span>
                        <button class="btn btn-link btn-sm p-0 fw-bold text-primary text-decoration-none" onclick="switchTab('register')">
                            Buat Akun Baru
                        </button>
                    </div>
                </div>

                {{-- ===== PANEL REGISTER ===== --}}
                <div id="panel-register" class="auth-panel {{ session('_tab') === 'register' || $errors->has('reg_email') || $errors->has('reg_password') ? 'active' : '' }}">
                    <form method="POST" action="{{ route('siswa.register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="reg_email" class="form-label">Alamat Email Aktif</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email"
                                       class="form-control border-start-0 @error('reg_email') is-invalid @enderror"
                                       id="reg_email" name="reg_email"
                                       value="{{ old('reg_email') }}"
                                       placeholder="nama@email.com">
                            </div>
                            @error('reg_email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reg_password" class="form-label">Password <span class="text-muted fw-normal">(min. 8 karakter)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                                <input type="password"
                                       class="form-control border-start-0 @error('reg_password') is-invalid @enderror"
                                       id="reg_password" name="reg_password"
                                       placeholder="Minimal 8 karakter">
                            </div>
                            @error('reg_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="reg_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                                <input type="password"
                                       class="form-control border-start-0"
                                       id="reg_password_confirmation" name="reg_password_confirmation"
                                       placeholder="Ulangi password">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-bold rounded-pill">
                                <i class="bi bi-person-check-fill me-1"></i> Buat Akun & Masuk
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <span class="text-muted small">Sudah punya akun? </span>
                        <button class="btn btn-link btn-sm p-0 fw-bold text-primary text-decoration-none" onclick="switchTab('login')">
                            Login di sini
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('welcome') }}" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchTab(tab) {
        document.getElementById('panel-login').classList.toggle('active', tab === 'login');
        document.getElementById('panel-register').classList.toggle('active', tab === 'register');
        document.getElementById('tab-login').classList.toggle('active', tab === 'login');
        document.getElementById('tab-register').classList.toggle('active', tab === 'register');
    }
</script>
@endsection
