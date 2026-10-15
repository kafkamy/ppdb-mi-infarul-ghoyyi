@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="row align-items-center mb-5 mt-3">
    <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5">
        <div class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 animate-fade-in" style="animation-delay: 0.1s;">
            <i class="bi bi-star-fill me-1"></i> Pendaftaran Tahun Ajaran {{ date('Y') }}/{{ date('Y')+1 }}
        </div>
        <h1 class="display-4 fw-bold mb-4 animate-fade-in" style="line-height: 1.2; animation-delay: 0.2s;">
            Mulai Masa Depan Gemilang di <span class="text-primary">MI Infarul Ghoyyi</span>
        </h1>
        <p class="lead mb-4 text-secondary animate-fade-in" style="animation-delay: 0.3s;">
            Platform pendaftaran peserta didik baru terintegrasi. Kami menyediakan pendidikan berkualitas untuk membentuk generasi berakhlak mulia dan berprestasi.
        </p>
        <div class="d-grid gap-3 d-sm-flex animate-fade-in" style="animation-delay: 0.4s;">
            <a href="{{ Auth::guard('student')->check() ? route('siswa.dashboard') : route('siswa.login') }}" class="btn btn-primary btn-lg px-4 d-flex align-items-center justify-content-center">
                <i class="bi bi-pencil-square me-2"></i> Daftar Sekarang
            </a>
        </div>
    </div>
    <div class="col-lg-6 animate-fade-in" style="animation-delay: 0.5s;">
        <div class="position-relative">
            <!-- Decorative Elements -->
            <div class="position-absolute top-0 start-0 translate-middle bg-primary rounded-circle" style="width: 100px; height: 100px; opacity: 0.1; filter: blur(20px);"></div>
            <div class="position-absolute bottom-0 end-0 translate-middle bg-success rounded-circle" style="width: 150px; height: 150px; opacity: 0.1; filter: blur(30px);"></div>
            
            <div class="card border-0 shadow-lg" style="background: linear-gradient(145deg, rgba(255,255,255,0.95), rgba(255,255,255,0.8));">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-mortarboard-fill fs-1"></i>
                        </div>
                    </div>
                    <h3 class="mb-3 fw-bold">Bergabung Bersama Kami</h3>
                    <p class="text-secondary mb-4">
                        Lingkungan belajar yang mendukung pengembangan karakter, akademis, dan spiritual peserta didik dengan fasilitas modern.
                    </p>
                    
                    <div class="row g-3 text-start mt-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span class="fw-medium small">Fasilitas Modern</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span class="fw-medium small">Guru Berpengalaman</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span class="fw-medium small">Kurikulum Unggul</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span class="fw-medium small">Lingkungan Nyaman</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5 g-4">
    <div class="col-md-4 animate-fade-in" style="animation-delay: 0.6s;">
        <div class="card card-hover h-100 border-0">
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded p-3 mb-4">
                    <i class="bi bi-clipboard-check fs-4"></i>
                </div>
                <h5 class="card-title fw-bold">Persyaratan Mudah</h5>
                <p class="card-text text-secondary mb-0">Proses pendaftaran yang sederhana. Lengkapi formulir online tanpa ribet dan upload dokumen dari rumah.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in" style="animation-delay: 0.7s;">
        <div class="card card-hover h-100 border-0">
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded p-3 mb-4">
                    <i class="bi bi-bell fs-4"></i>
                </div>
                <h5 class="card-title fw-bold">Notifikasi Langsung</h5>
                <p class="card-text text-secondary mb-0">Dapatkan status pendaftaran dan pengumuman secara real-time langsung melalui dashboard Anda.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in" style="animation-delay: 0.8s;">
        <div class="card card-hover h-100 border-0">
            <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded p-3 mb-4">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
                <h5 class="card-title fw-bold">Data Aman</h5>
                <p class="card-text text-secondary mb-0">Semua data pribadi calon peserta didik dilindungi dengan sistem keamanan tinggi dan enkripsi.</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-8 animate-fade-in" style="animation-delay: 0.9s;">
        <div class="card border-0 h-100">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                <h4 class="fw-bold mb-0"><i class="bi bi-list-check text-primary me-2"></i> Persiapan Pendaftaran</h4>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100 border border-white">
                            <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Dokumen Diperlukan:</h6>
                            <ul class="list-unstyled mb-0 text-secondary">
                                <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Akta Kelahiran</li>
                                <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Kartu Keluarga</li>
                                <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Foto 3x4 berwarna</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Ijazah/Surat Keterangan Lulus</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100 border border-white">
                            <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Informasi Data:</h6>
                            <ul class="list-unstyled mb-0 text-secondary">
                                <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Data pribadi calon siswa</li>
                                <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Data orang tua/wali</li>
                                <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i>Alamat tempat tinggal lengkap</li>
                                <li><i class="bi bi-check2 text-success me-2"></i>Nomor kontak aktif (WhatsApp)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 animate-fade-in" style="animation-delay: 1.0s;">
        <div class="card border-0 bg-primary text-white h-100 text-center" style="background: linear-gradient(135deg, var(--primary), #8b5cf6);">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <i class="bi bi-headset display-4 mb-3" style="opacity: 0.8;"></i>
                <h4 class="fw-bold mb-3">Butuh Bantuan?</h4>
                <p class="mb-4 opacity-75">
                    Hubungi layanan informasi kami jika Anda mengalami kesulitan dalam proses pendaftaran.
                </p>
                <div class="bg-white bg-opacity-25 rounded p-3 mb-2 backdrop-blur">
                    <i class="bi bi-telephone-fill me-2"></i> (021) 1234-5678
                </div>
                <div class="bg-white bg-opacity-25 rounded p-3 backdrop-blur">
                    <i class="bi bi-envelope-fill me-2"></i> info@miinfarul.sch.id
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
