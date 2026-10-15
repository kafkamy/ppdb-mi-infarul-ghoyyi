@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 animate-fade-in">
    <div>
        <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-speedometer2 text-primary me-2"></i> Dashboard Admin</h2>
        <p class="text-secondary mb-0">Sistem Informasi Pendaftaran Peserta Didik Baru</p>
    </div>
    <a href="{{ route('admin.settings') }}" class="btn btn-outline-primary rounded-pill px-4">
        <i class="bi bi-gear-fill me-1"></i> Pengaturan
    </a>
</div>

<div class="row mb-5 g-4">
    <div class="col-lg-3 col-md-6 animate-fade-in" style="animation-delay: 0.1s;">
        <div class="card card-hover border-0 h-100 bg-primary text-white" style="background: linear-gradient(135deg, var(--primary), #6366f1) !important;">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="bi bi-people-fill position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                <h6 class="card-title fw-normal opacity-75 mb-1">Total Pendaftar</h6>
                <h1 class="display-5 fw-bold mb-0">{{ $totalPendaftar }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in" style="animation-delay: 0.2s;">
        <div class="card card-hover border-0 h-100 bg-warning text-dark" style="background: linear-gradient(135deg, #f59e0b, #fbbf24) !important;">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="bi bi-hourglass-split position-absolute text-dark opacity-10" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                <h6 class="card-title fw-normal opacity-75 mb-1">Menunggu Verifikasi</h6>
                <h1 class="display-5 fw-bold mb-0">{{ $pendaftarPending }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in" style="animation-delay: 0.3s;">
        <div class="card card-hover border-0 h-100 bg-success text-white" style="background: linear-gradient(135deg, var(--secondary), #34d399) !important;">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="bi bi-check-circle-fill position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                <h6 class="card-title fw-normal opacity-75 mb-1">Diterima</h6>
                <h1 class="display-5 fw-bold mb-0">{{ $pendaftarDiterima }}</h1>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in" style="animation-delay: 0.4s;">
        <div class="card card-hover border-0 h-100 bg-danger text-white" style="background: linear-gradient(135deg, #ef4444, #f87171) !important;">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="bi bi-x-circle-fill position-absolute text-white opacity-25" style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                <h6 class="card-title fw-normal opacity-75 mb-1">Ditolak</h6>
                <h1 class="display-5 fw-bold mb-0">{{ $pendaftarDitolak }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7 animate-fade-in" style="animation-delay: 0.5s;">
        <div class="card border-0 h-100 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-building text-primary me-2"></i> Informasi Sekolah</h5>
                <a href="{{ route('admin.settings') }}" class="btn btn-sm btn-outline-primary rounded-pill">Edit</a>
            </div>
            <div class="card-body px-4">
                <div class="bg-light rounded-4 p-4 h-100 border border-white">
                    <div class="row g-4">
                        <div class="col-md-6 border-end-md">
                            <h6 class="text-secondary fw-bold mb-3 small text-uppercase">Profil Institusi</h6>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Nama Sekolah</span>
                                <strong class="text-dark">{{ $schoolSetting->nama_sekolah }}</strong>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted small d-block">NPSN</span>
                                <span class="text-dark">{{ $schoolSetting->npsn ?? '-' }}</span>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Kontak</span>
                                <div><i class="bi bi-telephone-fill text-muted me-1 small"></i> {{ $schoolSetting->no_telepon ?? '-' }}</div>
                                <div><i class="bi bi-envelope-fill text-muted me-1 small"></i> {{ $schoolSetting->email ?? '-' }}</div>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Alamat</span>
                                <span class="text-dark">{{ $schoolSetting->alamat }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary fw-bold mb-3 small text-uppercase">Pengaturan PPDB</h6>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Status Pendaftaran</span>
                                @if($schoolSetting->isPendaftaranBuka())
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Dibuka</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill"><i class="bi bi-x-circle-fill me-1"></i> Ditutup</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Tahun Ajaran Aktif</span>
                                <strong class="text-dark">{{ $schoolSetting->tahun_ajaran_aktif }}</strong>
                            </div>
                            <div class="mb-3">
                                <span class="text-muted small d-block">Kuota Siswa Baru</span>
                                <span class="text-dark">{{ $schoolSetting->kuota_siswa_baru ?? 'Tidak dibatasi' }}</span>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Biaya Pendaftaran</span>
                                <span class="text-dark fw-medium text-primary">Rp {{ number_format($schoolSetting->biaya_pendaftaran ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 animate-fade-in" style="animation-delay: 0.6s;">
        <div class="card border-0 h-100 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-primary me-2"></i> Manajemen Pendaftar</h5>
            </div>
            <div class="card-body px-4 d-flex flex-column justify-content-center">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-light border p-3 d-flex align-items-center justify-content-between text-start card-hover rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="bi bi-list-ul fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark mb-1">Semua Pendaftar</div>
                                <div class="text-muted small">Lihat daftar lengkap pendaftar</div>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>
                    
                    <a href="{{ route('admin.students.index', ['status' => 'Pending']) }}" class="btn btn-light border p-3 d-flex align-items-center justify-content-between text-start card-hover rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="bi bi-hourglass-split fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark mb-1">Menunggu Verifikasi <span class="badge bg-warning text-dark ms-1">{{ $pendaftarPending }}</span></div>
                                <div class="text-muted small">Proses verifikasi dokumen pendaftar</div>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>

                    <a href="{{ route('admin.students.index', ['status' => 'Diterima']) }}" class="btn btn-light border p-3 d-flex align-items-center justify-content-between text-start card-hover rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="bi bi-check-lg fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark mb-1">Siswa Diterima <span class="badge bg-success ms-1">{{ $pendaftarDiterima }}</span></div>
                                <div class="text-muted small">Lihat daftar siswa yang telah diterima</div>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right text-muted"></i>
                    </a>

                    <a href="{{ route('admin.export', ['status' => '']) }}" class="btn btn-primary text-white p-3 d-flex align-items-center justify-content-center card-hover rounded-4 mt-2 shadow-sm">
                        <i class="bi bi-file-earmark-arrow-down-fill me-2"></i> Export Data ke CSV
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
