@extends('layouts.app')

@section('title', 'Edit Pendaftar')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Peserta Didik</h5>
            <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-sm btn-light fw-semibold">
                ← Kembali ke Detail
            </a>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Ringkasan Identitas --}}
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase">Nomor Peserta Didik</label>
                    <input type="text" class="form-control bg-light font-monospace fw-bold" value="{{ $student->nomor_peserta_didik ?? '-' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase">Nama Calon Siswa</label>
                    <input type="text" class="form-control bg-light fw-bold" value="{{ $student->nama_lengkap ?? '-' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small text-uppercase">Tanggal Pendaftaran</label>
                    <input type="text" class="form-control bg-light" value="{{ $student->tanggal_daftar ? $student->tanggal_daftar->format('d F Y') : '-' }}" readonly>
                </div>
            </div>

            {{-- =============================================== --}}
            {{-- KOTAK 1: VERIFIKASI DATA & BERKAS CALON SISWA  --}}
            {{-- =============================================== --}}
            <div class="p-4 bg-light rounded-4 border border-2 border-primary border-opacity-25 mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="bi bi-person-check-fill fs-6"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-primary">1. Verifikasi Data Calon Siswa (Status Pendaftaran)</h6>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="status_pendaftaran" class="form-label">Status Pendaftaran <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_pendaftaran') is-invalid @enderror" 
                                id="status_pendaftaran" name="status_pendaftaran" required>
                            <option value="Pending" {{ old('status_pendaftaran', $student->status_pendaftaran) === 'Pending' ? 'selected' : '' }}>
                                ⏳ Menunggu Verifikasi
                            </option>
                            <option value="Diterima" {{ old('status_pendaftaran', $student->status_pendaftaran) === 'Diterima' ? 'selected' : '' }}>
                                ✓ Diterima
                            </option>
                            <option value="Ditolak" {{ old('status_pendaftaran', $student->status_pendaftaran) === 'Ditolak' ? 'selected' : '' }}>
                                ✗ Ditolak
                            </option>
                        </select>
                        @error('status_pendaftaran')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kelengkapan Berkas Dokumen</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="dokumen_lengkap" 
                                   name="dokumen_lengkap" value="1" {{ old('dokumen_lengkap', $student->dokumen_lengkap) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="dokumen_lengkap">
                                Berkas telah diverifikasi &amp; lengkap
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="catatan_verifikasi_pendaftaran" class="form-label">Catatan Verifikasi Data / Berkas (Admin)</label>
                        <textarea class="form-control @error('catatan_verifikasi_pendaftaran') is-invalid @enderror" 
                                  id="catatan_verifikasi_pendaftaran" name="catatan_verifikasi_pendaftaran" rows="2" 
                                  placeholder="Catatan untuk calon siswa terkait data/berkas (misal: alasan penolakan jika ditolak, atau instruksi perbaikan berkas)">{{ old('catatan_verifikasi_pendaftaran', $student->catatan_verifikasi_pendaftaran) }}</textarea>
                        @error('catatan_verifikasi_pendaftaran')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- =============================================== --}}
            {{-- KOTAK 2: VERIFIKASI BUKTI & STATUS PEMBAYARAN  --}}
            {{-- =============================================== --}}
            <div class="p-4 bg-light rounded-4 border border-2 border-warning border-opacity-50 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-warning text-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-credit-card-2-front-fill fs-6"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">2. Verifikasi Bukti Pembayaran</h6>
                    </div>
                    @if($student->bukti_pembayaran)
                        <a href="{{ asset('storage/' . $student->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat File Bukti
                        </a>
                    @endif
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                        <select class="form-select @error('status_pembayaran') is-invalid @enderror" 
                                id="status_pembayaran" name="status_pembayaran">
                            <option value="Belum Bayar" {{ old('status_pembayaran', $student->status_pembayaran) === 'Belum Bayar' ? 'selected' : '' }}>
                                Belum Bayar
                            </option>
                            <option value="Menunggu Verifikasi" {{ old('status_pembayaran', $student->status_pembayaran) === 'Menunggu Verifikasi' ? 'selected' : '' }}>
                                ⏳ Menunggu Verifikasi
                            </option>
                            <option value="Terverifikasi" {{ old('status_pembayaran', $student->status_pembayaran) === 'Terverifikasi' ? 'selected' : '' }}>
                                ✓ Terverifikasi (Lunas)
                            </option>
                            <option value="Ditolak" {{ old('status_pembayaran', $student->status_pembayaran) === 'Ditolak' ? 'selected' : '' }}>
                                ✗ Ditolak
                            </option>
                        </select>
                        @error('status_pembayaran')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jumlah_pembayaran" class="form-label">Nominal Pembayaran (Rp)</label>
                        <input type="number" class="form-control @error('jumlah_pembayaran') is-invalid @enderror" 
                               id="jumlah_pembayaran" name="jumlah_pembayaran" 
                               value="{{ old('jumlah_pembayaran', $student->jumlah_pembayaran ?? $schoolSetting->biaya_pendaftaran ?? 1550000) }}" min="0">
                        @error('jumlah_pembayaran')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nis" class="form-label">Nomor Induk Siswa (NIS)</label>
                        <input type="text" class="form-control font-monospace @error('nis') is-invalid @enderror" 
                               id="nis" name="nis" 
                               value="{{ old('nis', $student->nis) }}" placeholder="Otomatis diterbitkan saat pembayaran disetujui">
                        <small class="text-muted">Dapat diisi manual jika perlu, atau terbit otomatis saat pembayaran diverifikasi.</small>
                        @error('nis')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-12">
                        <label for="catatan_verifikasi_pembayaran" class="form-label">Catatan Verifikasi Pembayaran (Admin)</label>
                        <textarea class="form-control @error('catatan_verifikasi_pembayaran') is-invalid @enderror" 
                                  id="catatan_verifikasi_pembayaran" name="catatan_verifikasi_pembayaran" rows="2" 
                                  placeholder="Catatan untuk siswa (misal: alasan penolakan bukti pembayaran, nominal kurang, dll)">{{ old('catatan_verifikasi_pembayaran', $student->catatan_verifikasi_pembayaran) }}</textarea>
                        @error('catatan_verifikasi_pembayaran')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Status Tambahan --}}
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="email_verified" 
                           name="email_verified" value="1" {{ old('email_verified', $student->email_verified) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="email_verified">
                        Email akun telah diverifikasi
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-outline-secondary px-4 py-2">
                    Batal
                </a>
            </div>
        </form>

        <!-- Tombol Delete -->
        <div class="mt-5 pt-4 border-top">
            <h6 class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i> Zona Berbahaya</h6>
            <p class="text-muted small">Menghapus data pendaftar ini akan memindahkan data ke sampah.</p>
            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peserta didik ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash me-1"></i> Hapus Data Pendaftar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
