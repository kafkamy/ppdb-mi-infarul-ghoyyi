@extends('layouts.app')

@section('title', 'Edit Pendaftar')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">✎ Edit Data Peserta Didik</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nomor_peserta_didik" class="form-label">Nomor Peserta Didik</label>
                    <input type="text" class="form-control" value="{{ $student->nomor_peserta_didik }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_daftar" class="form-label">Tanggal Pendaftaran</label>
                    <input type="text" class="form-control" value="{{ $student->tanggal_daftar ? $student->tanggal_daftar->format('d F Y') : '-' }}" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="status_pendaftaran" class="form-label">Status Pendaftaran <span class="text-danger">*</span></label>
                <select class="form-select @error('status_pendaftaran') is-invalid @enderror" 
                        id="status_pendaftaran" name="status_pendaftaran" required>
                    <option value="Pending" {{ $student->status_pendaftaran === 'Pending' ? 'selected' : '' }}>
                        ⏳ Menunggu Verifikasi
                    </option>
                    <option value="Diterima" {{ $student->status_pendaftaran === 'Diterima' ? 'selected' : '' }}>
                        ✓ Diterima
                    </option>
                    <option value="Ditolak" {{ $student->status_pendaftaran === 'Ditolak' ? 'selected' : '' }}>
                        ✗ Ditolak
                    </option>
                </select>
                @error('status_pendaftaran')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label for="dokumen_lengkap" class="form-label">Verifikasi Dokumen</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="dokumen_lengkap" 
                           name="dokumen_lengkap" value="1" {{ $student->dokumen_lengkap ? 'checked' : '' }}>
                    <label class="form-check-label" for="dokumen_lengkap">
                        Dokumen telah diverifikasi dan lengkap
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label for="email_verified" class="form-label">Verifikasi Email</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="email_verified" 
                           name="email_verified" value="1" {{ $student->email_verified ? 'checked' : '' }}>
                    <label class="form-check-label" for="email_verified">
                        Email telah diverifikasi
                    </label>
                </div>
            </div>

            <div class="d-grid gap-2 mt-5">
                <button type="submit" class="btn btn-primary btn-lg">
                    💾 Simpan Perubahan
                </button>
                <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-secondary">
                    ← Batal
                </a>
            </div>
        </form>

        <!-- Tombol Delete -->
        <div class="mt-5 pt-5 border-top">
            <h6 class="text-danger">⚠️ Zona Berbahaya</h6>
            <p class="text-muted">Menghapus data pendaftar tidak dapat dibatalkan.</p>
            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    🗑️ Hapus Data Pendaftar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
