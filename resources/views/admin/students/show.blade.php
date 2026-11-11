@extends('layouts.app')

@section('title', 'Detail Pendaftar - ' . ($student->nama_lengkap ?? 'Calon Siswa'))

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white py-3">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2"></i>Detail Peserta Didik</h5>
            </div>
            <div class="col-auto d-flex gap-2">
                <a href="{{ route('admin.verifikasi-data') }}" class="btn btn-sm btn-info text-white fw-semibold">
                    <i class="bi bi-person-check-fill me-1"></i> Ke Verifikasi Data
                </a>
                <a href="{{ route('admin.verifikasi-pembayaran') }}" class="btn btn-sm btn-warning text-dark fw-semibold">
                    <i class="bi bi-credit-card-2-front-fill me-1"></i> Ke Verifikasi Pembayaran
                </a>
                <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-light fw-semibold">
                    <i class="bi bi-pencil me-1"></i> Edit Data
                </a>
                <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-outline-light fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-4">

        {{-- Flash Notification --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5 text-success align-middle"></i>
                <strong>Sukses!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-danger align-middle"></i>
                <strong>Perhatian:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Status Pendaftaran & Pembayaran Overview Banner -->
        <div class="alert alert-light border shadow-sm p-4 mb-4" style="border-radius: 0.75rem;">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <small class="text-muted text-uppercase fw-semibold d-block">Nomor Peserta Didik</small>
                    <span class="fs-5 fw-bold text-dark font-monospace">{{ $student->nomor_peserta_didik ?? '-' }}</span>
                    @if($student->nis)
                        <div class="mt-1">
                            <span class="badge bg-success font-monospace px-2 py-1"><i class="bi bi-person-badge-fill me-1"></i>NIS: {{ $student->nis }}</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <small class="text-muted text-uppercase fw-semibold d-block mb-1">Status Verifikasi Data Siswa</small>
                    @if($student->status_pendaftaran === 'Pending')
                        <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi Data</span>
                    @elseif($student->status_pendaftaran === 'Diterima')
                        <span class="badge bg-success px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i> Data Disetujui (Diterima)</span>
                    @else
                        <span class="badge bg-danger px-3 py-2"><i class="bi bi-x-circle-fill me-1"></i> Data Ditolak</span>
                    @endif
                    <div class="mt-1">
                        <a href="#section-verifikasi-data" class="small text-primary text-decoration-none fw-semibold">
                            Lihat Verifikasi Data ↓
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <small class="text-muted text-uppercase fw-semibold d-block mb-1">Status Verifikasi Bukti Pembayaran</small>
                    @if($student->status_pembayaran === 'Terverifikasi' || $student->status_pembayaran === 'Lunas')
                        <span class="badge bg-success px-3 py-2"><i class="bi bi-patch-check-fill me-1"></i> Terverifikasi (Lunas)</span>
                    @elseif($student->status_pembayaran === 'Menunggu Verifikasi')
                        <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-clock-history me-1"></i> Menunggu Verifikasi Bukti</span>
                    @elseif($student->status_pembayaran === 'Ditolak')
                        <span class="badge bg-danger px-3 py-2"><i class="bi bi-x-circle-fill me-1"></i> Bukti Ditolak</span>
                    @else
                        <span class="badge bg-secondary px-3 py-2"><i class="bi bi-dash-circle me-1"></i> Belum Bayar</span>
                    @endif
                    <div class="mt-1">
                        <a href="#section-verifikasi-pembayaran" class="small text-primary text-decoration-none fw-semibold">
                            Lihat Verifikasi Pembayaran ↓
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- BAGIAN 1: VERIFIKASI DATA CALON SISWA (TERPISAH DARI PEMBAYARAN)   --}}
        {{-- ================================================================= --}}
        <div id="section-verifikasi-data" class="card border border-2 {{ $student->status_pendaftaran === 'Pending' ? 'border-primary shadow' : 'border-light shadow-sm' }} mb-4" style="border-radius:1rem;">
            <div class="card-header bg-light py-3 px-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-person-check-fill fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">1. Verifikasi Data Calon Siswa</h5>
                        <small class="text-muted">Pemeriksaan kelengkapan formulir biodata dan berkas pendaftaran</small>
                    </div>
                </div>
                <div>
                    @if($student->status_pendaftaran === 'Pending')
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                            <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi Panitia
                        </span>
                    @elseif($student->status_pendaftaran === 'Diterima')
                        <span class="badge bg-success px-3 py-2 rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i> Data Disetujui (Diterima)
                        </span>
                    @else
                        <span class="badge bg-danger px-3 py-2 rounded-pill">
                            <i class="bi bi-x-circle-fill me-1"></i> Data Ditolak
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Kiri: Status & Tindakan Verifikasi Data --}}
                    <div class="col-md-7">
                        <table class="table table-borderless align-middle mb-0" style="font-size: 0.95rem;">
                            <tbody>
                                <tr>
                                    <td class="text-muted py-2" width="40%">Status Pendaftaran</td>
                                    <td class="py-2">
                                        @if($student->status_pendaftaran === 'Pending')
                                            <span class="badge bg-warning text-dark fs-6"><i class="bi bi-hourglass-split me-1"></i>Pending (Menunggu)</span>
                                        @elseif($student->status_pendaftaran === 'Diterima')
                                            <span class="badge bg-success fs-6"><i class="bi bi-check2-circle me-1"></i>Disetujui (Diterima)</span>
                                        @else
                                            <span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Kelengkapan Dokumen</td>
                                    <td class="py-2">
                                        @if($student->dokumen_lengkap)
                                            <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25 px-3 py-1">
                                                <i class="bi bi-check-circle-fill me-1"></i>Dokumen Lengkap &amp; Valid
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-15 text-secondary border border-secondary border-opacity-25 px-3 py-1">
                                                <i class="bi bi-clock me-1"></i>Belum Terverifikasi Lengkap
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Tanggal Pendaftaran</td>
                                    <td class="py-2 fw-semibold">
                                        {{ $student->tanggal_daftar ? $student->tanggal_daftar->format('d F Y') : '-' }}
                                    </td>
                                </tr>
                                @if($student->tanggal_verifikasi_pendaftaran)
                                <tr>
                                    <td class="text-muted py-2">Tanggal Diverifikasi</td>
                                    <td class="py-2 text-muted">
                                        {{ $student->tanggal_verifikasi_pendaftaran->format('d F Y, H:i') }} WIB
                                    </td>
                                </tr>
                                @endif
                                @if($student->catatan_verifikasi_pendaftaran)
                                <tr>
                                    <td class="text-danger py-2">Catatan Verifikasi Data</td>
                                    <td class="py-2 text-danger fw-semibold">
                                        <i class="bi bi-chat-left-quote me-1"></i>{{ $student->catatan_verifikasi_pendaftaran }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                        {{-- Tombol Aksi Verifikasi Data Siswa --}}
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check me-1"></i>Aksi Verifikasi Data Calon Siswa:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                {{-- Tombol Setujui Data (Diterima) --}}
                                <form action="{{ route('admin.students.verify-data', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui data calon siswa ini (Status: Diterima)?');">
                                    @csrf
                                    <input type="hidden" name="status_pendaftaran" value="Diterima">
                                    <input type="hidden" name="dokumen_lengkap" value="1">
                                    <button type="submit" class="btn btn-success px-3 py-2 fw-semibold shadow-sm" {{ $student->status_pendaftaran === 'Diterima' ? 'disabled' : '' }}>
                                        <i class="bi bi-check-circle-fill me-1"></i> Setujui Data (Diterima)
                                    </button>
                                </form>

                                {{-- Tombol Tolak Data (Modal) --}}
                                <button type="button" class="btn btn-outline-danger px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTolakData">
                                    <i class="bi bi-x-circle-fill me-1"></i> Tolak Data Pendaftaran
                                </button>

                                {{-- Tombol Reset ke Pending --}}
                                @if($student->status_pendaftaran === 'Diterima' || $student->status_pendaftaran === 'Ditolak')
                                    <form action="{{ route('admin.students.verify-data', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Kembalikan status pendaftaran ke Menunggu Verifikasi?');">
                                        @csrf
                                        <input type="hidden" name="status_pendaftaran" value="Pending">
                                        <button type="submit" class="btn btn-outline-warning text-dark px-3 py-2 fw-semibold">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Menunggu
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Kanan: Berkas Dokumen yang Perlu Diperiksa --}}
                    <div class="col-md-5">
                        <div class="bg-light p-3 rounded-3 border h-100">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-folder-check text-primary me-1"></i>Pemeriksaan Berkas Dokumen:</h6>
                            <div class="d-flex flex-column gap-2 mb-3">
                                {{-- Akta Kelahiran --}}
                                <div class="p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-person-fill fs-5 {{ $student->file_akta_kelahiran ? 'text-primary' : 'text-muted opacity-50' }}"></i>
                                        <span class="small fw-semibold">Akta Kelahiran</span>
                                    </div>
                                    @if($student->file_akta_kelahiran)
                                        <a href="{{ asset('storage/' . $student->file_akta_kelahiran) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size:0.75rem;">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Berkas
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted border">Belum Ada</span>
                                    @endif
                                </div>

                                {{-- Kartu Keluarga --}}
                                <div class="p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-people-fill fs-5 {{ $student->file_kartu_keluarga ? 'text-info' : 'text-muted opacity-50' }}"></i>
                                        <span class="small fw-semibold">Kartu Keluarga (KK)</span>
                                    </div>
                                    @if($student->file_kartu_keluarga)
                                        <a href="{{ asset('storage/' . $student->file_kartu_keluarga) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size:0.75rem;">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Berkas
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted border">Belum Ada</span>
                                    @endif
                                </div>

                                {{-- Pas Foto 3x4 --}}
                                <div class="p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-image-fill fs-5 {{ $student->file_foto_3x4 ? 'text-success' : 'text-muted opacity-50' }}"></i>
                                        <span class="small fw-semibold">Pas Foto 3x4</span>
                                    </div>
                                    @if($student->file_foto_3x4)
                                        <a href="{{ asset('storage/' . $student->file_foto_3x4) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size:0.75rem;">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>Lihat Berkas
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted border">Belum Ada</span>
                                    @endif
                                </div>
                            </div>

                            <div class="small text-muted">
                                <i class="bi bi-info-circle me-1"></i> Verifikasi data ini memutuskan apakah calon siswa <strong>Diterima</strong> atau <strong>Ditolak</strong> berdasarkan identitas &amp; dokumennya secara independen.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- =================================================================== --}}
        {{-- BAGIAN 2: VERIFIKASI BUKTI PEMBAYARAN (TERPISAH DARI DATA SISWA)    --}}
        {{-- =================================================================== --}}
        <div id="section-verifikasi-pembayaran" class="card border border-2 {{ $student->status_pembayaran === 'Menunggu Verifikasi' ? 'border-warning shadow' : 'border-light shadow-sm' }} mb-4" style="border-radius:1rem;">
            <div class="card-header bg-light py-3 px-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-warning text-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-credit-card-2-front-fill fs-5"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">2. Bukti &amp; Verifikasi Pembayaran</h5>
                        <small class="text-muted">Pemeriksaan bukti transfer biaya pendaftaran &amp; penerbitan NIS otomatis</small>
                    </div>
                </div>
                <div>
                    @if($student->status_pembayaran === 'Menunggu Verifikasi')
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                            <i class="bi bi-clock-history me-1"></i> Menunggu Verifikasi Bukti
                        </span>
                    @elseif($student->status_pembayaran === 'Terverifikasi' || $student->status_pembayaran === 'Lunas')
                        <span class="badge bg-success px-3 py-2 rounded-pill">
                            <i class="bi bi-patch-check-fill me-1"></i> Terverifikasi (Lunas)
                        </span>
                    @elseif($student->status_pembayaran === 'Ditolak')
                        <span class="badge bg-danger px-3 py-2 rounded-pill">
                            <i class="bi bi-x-circle-fill me-1"></i> Bukti Ditolak
                        </span>
                    @else
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">
                            <i class="bi bi-dash-circle me-1"></i> Belum Bayar
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Detail Data Pembayaran --}}
                    <div class="col-md-7">
                        <table class="table table-borderless align-middle mb-0" style="font-size: 0.95rem;">
                            <tbody>
                                <tr>
                                    <td class="text-muted py-2" width="40%">Status Pembayaran</td>
                                    <td class="py-2">
                                        @if($student->status_pembayaran === 'Terverifikasi' || $student->status_pembayaran === 'Lunas')
                                            <span class="badge bg-success fs-6"><i class="bi bi-check2-circle me-1"></i>Terverifikasi (Lunas)</span>
                                        @elseif($student->status_pembayaran === 'Menunggu Verifikasi')
                                            <span class="badge bg-warning text-dark fs-6"><i class="bi bi-hourglass-split me-1"></i>Menunggu Verifikasi</span>
                                        @elseif($student->status_pembayaran === 'Ditolak')
                                            <span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary fs-6"><i class="bi bi-dash-circle me-1"></i>Belum Bayar</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($student->nis)
                                <tr>
                                    <td class="text-muted py-2">Nomor Induk Siswa (NIS)</td>
                                    <td class="py-2">
                                        <span class="badge bg-success font-monospace fs-6 px-3 py-1">
                                            <i class="bi bi-person-badge-fill me-1"></i>{{ $student->nis }}
                                        </span>
                                        <span class="badge bg-light text-success border border-success ms-1">Diterbitkan Otomatis</span>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-muted py-2">Nominal Pembayaran</td>
                                    <td class="py-2 fw-bold text-primary fs-6">
                                        {{ $student->jumlah_pembayaran ? 'Rp ' . number_format($student->jumlah_pembayaran, 0, ',', '.') : 'Rp ' . number_format($student->biaya_pendaftaran ?? 1550000, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Metode / Bank Tujuan</td>
                                    <td class="py-2 fw-semibold">{{ $student->bank_tujuan_pembayaran ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Atas Nama Pengirim</td>
                                    <td class="py-2 fw-semibold">{{ $student->nama_pengirim_pembayaran ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Tanggal Pembayaran</td>
                                    <td class="py-2">
                                        {{ $student->tanggal_pembayaran ? $student->tanggal_pembayaran->format('d F Y, H:i') . ' WIB' : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Catatan dari Calon Siswa</td>
                                    <td class="py-2">{{ $student->catatan_pembayaran ?: '—' }}</td>
                                </tr>
                                @if($student->tanggal_verifikasi_pembayaran)
                                <tr>
                                    <td class="text-muted py-2">Tanggal Diverifikasi</td>
                                    <td class="py-2 text-muted">
                                        {{ $student->tanggal_verifikasi_pembayaran->format('d F Y, H:i') }} WIB
                                    </td>
                                </tr>
                                @endif
                                @if($student->catatan_verifikasi_pembayaran)
                                <tr>
                                    <td class="text-danger py-2">Catatan Verifikasi Pembayaran</td>
                                    <td class="py-2 text-danger fw-semibold">
                                        <i class="bi bi-chat-left-quote me-1"></i>{{ $student->catatan_verifikasi_pembayaran }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                        {{-- Tombol Verifikasi Pembayaran --}}
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check me-1"></i>Aksi Verifikasi Bukti Pembayaran:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                {{-- Tombol Setujui / Verifikasi Pembayaran --}}
                                <form action="{{ route('admin.students.verify-payment', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin memverifikasi dan menyetujui bukti pembayaran ini (Status: Lunas)?');">
                                    @csrf
                                    <input type="hidden" name="status_pembayaran" value="Terverifikasi">
                                    <button type="submit" class="btn btn-success px-3 py-2 fw-semibold shadow-sm" {{ $student->status_pembayaran === 'Terverifikasi' ? 'disabled' : '' }}>
                                        <i class="bi bi-check-circle-fill me-1"></i> Setujui &amp; Verifikasi (Lunas)
                                    </button>
                                </form>

                                {{-- Tombol Tolak Pembayaran (Membuka Modal) --}}
                                <button type="button" class="btn btn-outline-danger px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTolakPembayaran">
                                    <i class="bi bi-x-circle-fill me-1"></i> Tolak Pembayaran
                                </button>

                                {{-- Tombol Reset ke Menunggu --}}
                                @if($student->status_pembayaran === 'Terverifikasi' || $student->status_pembayaran === 'Ditolak')
                                    <form action="{{ route('admin.students.verify-payment', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Kembalikan status pembayaran ke Menunggu Verifikasi?');">
                                        @csrf
                                        <input type="hidden" name="status_pembayaran" value="Menunggu Verifikasi">
                                        <button type="submit" class="btn btn-outline-warning text-dark px-3 py-2 fw-semibold">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Menunggu
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Pratinjau File Bukti Pembayaran --}}
                    <div class="col-md-5">
                        <div class="bg-light p-3 rounded-3 text-center border h-100 d-flex flex-column justify-content-between">
                            <div>
                                <span class="small fw-bold text-muted text-uppercase d-block mb-2">Pratinjau Bukti Transfer</span>
                                @if($student->bukti_pembayaran)
                                    @php
                                        $ext = pathinfo($student->bukti_pembayaran, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
                                        $fileUrl = asset('storage/' . $student->bukti_pembayaran);
                                    @endphp

                                    @if($isImage)
                                        <div class="position-relative overflow-hidden rounded border bg-white mb-3" style="max-height: 240px;">
                                            <img src="{{ $fileUrl }}" alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 240px; object-fit: contain; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalPreviewBukti">
                                        </div>
                                    @else
                                        <div class="p-4 bg-white rounded border mb-3">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger display-3"></i>
                                            <div class="fw-semibold text-dark mt-2">Dokumen Bukti Transfer (PDF)</div>
                                        </div>
                                    @endif
                                @else
                                    <div class="py-5 text-muted">
                                        <i class="bi bi-image text-secondary opacity-25 display-2"></i>
                                        <p class="small text-muted mt-2 mb-0">Belum ada file bukti transfer yang diunggah oleh calon siswa.</p>
                                    </div>
                                @endif
                            </div>

                            @if($student->bukti_pembayaran)
                                <div class="d-grid gap-2 mt-2">
                                    <a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary btn-sm rounded-pill py-2">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Ukuran Penuh / Unduh
                                    </a>
                                    @if($isImage)
                                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modalPreviewBukti">
                                            <i class="bi bi-zoom-in me-1"></i> Perbesar Gambar
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================== -->
        <!-- RINCIAN DATA BIODATA LENGKAP   -->
        <!-- ============================== -->
        <div class="card border-0 bg-light p-4 rounded-4 mt-4">
            <!-- Data Pribadi -->
            <h6 class="mb-3 border-bottom pb-2 fw-bold text-dark"><i class="bi bi-person-fill text-primary me-2"></i>Data Pribadi Siswa</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Nama Lengkap:</strong> {{ $student->nama_lengkap ?? '-' }}</p>
                    <p class="mb-2"><strong>Nama Panggilan:</strong> {{ $student->nama_panggilan ?? '-' }}</p>
                    <p class="mb-2"><strong>Jenis Kelamin:</strong> {{ $student->jenis_kelamin ?? '-' }}</p>
                    <p class="mb-2"><strong>Tempat Lahir:</strong> {{ $student->tempat_lahir ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Tanggal Lahir:</strong> {{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d F Y') : '-' }}</p>
                    <p class="mb-2"><strong>Agama:</strong> {{ $student->agama ?? '-' }}</p>
                    <p class="mb-2"><strong>Kewarganegaraan:</strong> {{ $student->kewarganegaraan ?? '-' }}</p>
                    <p class="mb-2"><strong>Anak Ke-:</strong> {{ $student->anak_ke ?? '-' }} dari {{ $student->jumlah_saudara ?? '-' }} saudara</p>
                </div>
            </div>

            <!-- Alamat -->
            <h6 class="mt-4 mb-3 border-bottom pb-2 fw-bold text-dark"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Alamat Tempat Tinggal</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Alamat Lengkap:</strong> {{ $student->alamat ?? '-' }}</p>
                    <p class="mb-2"><strong>Desa/Kelurahan:</strong> {{ $student->desa_kelurahan ?? '-' }}</p>
                    <p class="mb-2"><strong>Kecamatan:</strong> {{ $student->kecamatan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Kabupaten/Kota:</strong> {{ $student->kabupaten_kota ?? '-' }}</p>
                    <p class="mb-2"><strong>Provinsi:</strong> {{ $student->provinsi ?? '-' }}</p>
                    <p class="mb-2"><strong>Kode Pos:</strong> {{ $student->kode_pos ?? '-' }}</p>
                </div>
            </div>

            <!-- Kontak -->
            <h6 class="mt-4 mb-3 border-bottom pb-2 fw-bold text-dark"><i class="bi bi-telephone-fill text-primary me-2"></i>Kontak</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Nomor Telepon / WhatsApp:</strong> {{ $student->no_telepon ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Email:</strong> {{ $student->email ?? '-' }}</p>
                </div>
            </div>

            <!-- Kesehatan -->
            @if($student->no_asuransi_kesehatan || $student->riwayat_kesehatan)
                <h6 class="mt-4 mb-3 border-bottom pb-2 fw-bold text-dark"><i class="bi bi-heart-pulse-fill text-primary me-2"></i>Kesehatan</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>No. Asuransi Kesehatan:</strong> {{ $student->no_asuransi_kesehatan ?? '-' }}</p>
                    </div>
                    @if($student->riwayat_kesehatan)
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Riwayat Kesehatan:</strong> {{ $student->riwayat_kesehatan }}</p>
                    </div>
                    @endif
                </div>
            @endif

            <!-- Data Orang Tua -->
            <h6 class="mt-4 mb-3 border-bottom pb-2 fw-bold text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Data Orang Tua / Wali</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <h6 class="text-secondary fw-bold small text-uppercase mb-2">Ayah Kandung</h6>
                    <p class="mb-1"><strong>Nama:</strong> {{ $student->nama_ayah ?? '-' }}</p>
                    <p class="mb-1"><strong>NIK:</strong> {{ $student->nik_ayah ?? '-' }}</p>
                    <p class="mb-1"><strong>Pekerjaan:</strong> {{ $student->pekerjaan_ayah ?? '-' }}</p>
                    <p class="mb-1"><strong>Telepon:</strong> {{ $student->no_telepon_ayah ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-secondary fw-bold small text-uppercase mb-2">Ibu Kandung</h6>
                    <p class="mb-1"><strong>Nama:</strong> {{ $student->nama_ibu ?? '-' }}</p>
                    <p class="mb-1"><strong>NIK:</strong> {{ $student->nik_ibu ?? '-' }}</p>
                    <p class="mb-1"><strong>Pekerjaan:</strong> {{ $student->pekerjaan_ibu ?? '-' }}</p>
                    <p class="mb-1"><strong>Telepon:</strong> {{ $student->no_telepon_ibu ?? '-' }}</p>
                </div>
            </div>

            @if($student->nama_wali)
                <div class="mt-3">
                    <h6 class="text-secondary fw-bold small text-uppercase mb-2">Wali</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama:</strong> {{ $student->nama_wali }}</p>
                            <p class="mb-1"><strong>NIK:</strong> {{ $student->nik_wali ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Pekerjaan:</strong> {{ $student->pekerjaan_wali ?? '-' }}</p>
                            <p class="mb-1"><strong>Telepon:</strong> {{ $student->no_telepon_wali ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Sekolah Asal -->
            @if($student->asal_sekolah)
                <h6 class="mt-4 mb-3 border-bottom pb-2 fw-bold text-dark"><i class="bi bi-building me-2 text-primary"></i>Asal Sekolah</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Nama Sekolah:</strong> {{ $student->asal_sekolah }}</p>
                        <p class="mb-1"><strong>NPSN:</strong> {{ $student->npsn_sekolah_asal ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tingkat Sebelumnya:</strong> {{ $student->tingkat_sebelumnya ?? '-' }}</p>
                    </div>
                </div>
            @endif

            <!-- Data Pendaftaran -->
            <h6 class="mt-4 mb-3 border-bottom pb-2 fw-bold text-dark"><i class="bi bi-file-earmark-text-fill text-primary me-2"></i>Data Pendaftaran</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tahun Ajaran:</strong> {{ $student->tahun_ajaran }}</p>
                    <p class="mb-1"><strong>Kelas Pendaftaran:</strong> {{ $student->kelas_pendaftaran }}</p>
                    <p class="mb-1"><strong>Tanggal Pendaftaran:</strong> {{ $student->tanggal_daftar ? $student->tanggal_daftar->format('d F Y') : '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Biaya Pendaftaran:</strong> Rp {{ number_format($student->biaya_pendaftaran ?? 0, 0, ',', '.') }}</p>
                    <p class="mb-1"><strong>Email Terverifikasi:</strong> {{ $student->email_verified ? '✓ Ya' : '✗ Tidak' }}</p>
                    <p class="mb-1"><strong>Dokumen Lengkap:</strong> {{ $student->dokumen_lengkap ? '✓ Ya' : '✗ Tidak' }}</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Tambahan -->
        <div class="d-grid gap-2 mt-4">
            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-warning btn-lg fw-bold text-dark">
                <i class="bi bi-pencil-square me-1"></i> Edit Data Lengkap Pendaftar
            </a>
        </div>
    </div>
</div>

{{-- MODAL TOLAK DATA PENDAFTARAN --}}
<div class="modal fade" id="modalTolakData" tabindex="-1" aria-labelledby="modalTolakDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.students.verify-data', $student->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status_pendaftaran" value="Ditolak">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="modalTolakDataLabel">
                        <i class="bi bi-x-circle-fill me-2"></i>Tolak Data Pendaftaran Calon Siswa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">
                        Masukkan alasan penolakan data calon siswa. Catatan ini akan ditampilkan pada dashboard calon siswa agar dapat diperbaiki.
                    </p>
                    <div class="mb-3">
                        <label for="catatan_verifikasi_pendaftaran" class="form-label fw-bold">Alasan Penolakan Data <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatan_verifikasi_pendaftaran" name="catatan_verifikasi_pendaftaran" rows="3" 
                                  placeholder="Contoh: Berkas kartu keluarga tidak terbaca, atau usia belum memenuhi batas minimal." required>{{ old('catatan_verifikasi_pendaftaran', $student->catatan_verifikasi_pendaftaran) }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger fw-bold">
                        <i class="bi bi-x-circle me-1"></i> Konfirmasi Tolak Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TOLAK PEMBAYARAN --}}
<div class="modal fade" id="modalTolakPembayaran" tabindex="-1" aria-labelledby="modalTolakPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.students.verify-payment', $student->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status_pembayaran" value="Ditolak">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="modalTolakPembayaranLabel">
                        <i class="bi bi-x-circle-fill me-2"></i>Tolak Bukti Pembayaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">
                        Masukkan alasan penolakan bukti pembayaran. Catatan ini akan ditampilkan pada portal calon siswa agar dapat mengunggah bukti yang benar.
                    </p>
                    <div class="mb-3">
                        <label for="catatan_verifikasi_pembayaran" class="form-label fw-bold">Alasan Penolakan Pembayaran <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatan_verifikasi_pembayaran" name="catatan_verifikasi_pembayaran" rows="3" 
                                  placeholder="Contoh: Bukti transfer buram/tidak terbaca, atau nominal transfer tidak sesuai rincian." required>{{ old('catatan_verifikasi_pembayaran', $student->catatan_verifikasi_pembayaran) }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger fw-bold">
                        <i class="bi bi-x-circle me-1"></i> Konfirmasi Tolak Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL PREVIEW GAMBAR BUKTI --}}
@if($student->bukti_pembayaran && isset($isImage) && $isImage)
<div class="modal fade" id="modalPreviewBukti" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Pratinjau Bukti Pembayaran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3 bg-dark">
                <img src="{{ asset('storage/' . $student->bukti_pembayaran) }}" alt="Bukti Pembayaran Penuh" class="img-fluid rounded" style="max-height: 80vh;">
            </div>
            <div class="modal-footer">
                <a href="{{ asset('storage/' . $student->bukti_pembayaran) }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tab Baru
                </a>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
