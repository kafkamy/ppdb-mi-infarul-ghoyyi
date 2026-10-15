@extends('layouts.app')

@section('title', 'Pengaturan Sekolah')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">⚙️ Pengaturan Sekolah</h5>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Informasi Dasar -->
            <h5 class="mt-4 mb-3 border-bottom pb-2">Informasi Dasar Sekolah</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" 
                           id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $schoolSetting->nama_sekolah) }}" required>
                    @error('nama_sekolah')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="npsn" class="form-label">NPSN</label>
                    <input type="text" class="form-control" id="npsn" name="npsn" 
                           value="{{ old('npsn', $schoolSetting->npsn) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                          id="alamat" name="alamat" rows="3" required>{{ old('alamat', $schoolSetting->alamat) }}</textarea>
                @error('alamat')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="no_telepon" class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control" id="no_telepon" name="no_telepon" 
                           value="{{ old('no_telepon', $schoolSetting->no_telepon) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="{{ old('email', $schoolSetting->email) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control" id="website" name="website" 
                           value="{{ old('website', $schoolSetting->website) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="visi" class="form-label">Visi Sekolah</label>
                <textarea class="form-control" id="visi" name="visi" rows="2">{{ old('visi', $schoolSetting->visi) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="misi" class="form-label">Misi Sekolah</label>
                <textarea class="form-control" id="misi" name="misi" rows="2">{{ old('misi', $schoolSetting->misi) }}</textarea>
            </div>

            <!-- Pengaturan Pendaftaran -->
            <h5 class="mt-4 mb-3 border-bottom pb-2">Pengaturan Pendaftaran</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tahun_ajaran_aktif" class="form-label">Tahun Ajaran Aktif <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tahun_ajaran_aktif" name="tahun_ajaran_aktif" 
                           value="{{ old('tahun_ajaran_aktif', $schoolSetting->tahun_ajaran_aktif) }}" 
                           placeholder="Contoh: 2026/2027" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="kuota_siswa_baru" class="form-label">Kuota Siswa Baru</label>
                    <input type="number" class="form-control" id="kuota_siswa_baru" name="kuota_siswa_baru" 
                           value="{{ old('kuota_siswa_baru', $schoolSetting->kuota_siswa_baru) }}" min="1">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_buka_pendaftaran" class="form-label">Tanggal Buka Pendaftaran</label>
                    <input type="date" class="form-control" id="tanggal_buka_pendaftaran" name="tanggal_buka_pendaftaran" 
                           value="{{ old('tanggal_buka_pendaftaran', $schoolSetting->tanggal_buka_pendaftaran?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_tutup_pendaftaran" class="form-label">Tanggal Tutup Pendaftaran</label>
                    <input type="date" class="form-control" id="tanggal_tutup_pendaftaran" name="tanggal_tutup_pendaftaran" 
                           value="{{ old('tanggal_tutup_pendaftaran', $schoolSetting->tanggal_tutup_pendaftaran?->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="pendaftaran_dibuka" class="form-label">Status Pendaftaran</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="pendaftaran_dibuka" 
                           name="pendaftaran_dibuka" value="1" {{ old('pendaftaran_dibuka', $schoolSetting->pendaftaran_dibuka) ? 'checked' : '' }}>
                    <label class="form-check-label" for="pendaftaran_dibuka">
                        Pendaftaran dibuka
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="biaya_pendaftaran" class="form-label">Biaya Pendaftaran (Rp)</label>
                    <input type="number" class="form-control" id="biaya_pendaftaran" name="biaya_pendaftaran" 
                           value="{{ old('biaya_pendaftaran', $schoolSetting->biaya_pendaftaran) }}" min="0" step="1000">
                </div>
            </div>

            <div class="mb-3">
                <label for="informasi_tambahan" class="form-label">Informasi Tambahan</label>
                <textarea class="form-control" id="informasi_tambahan" name="informasi_tambahan" rows="3">{{ old('informasi_tambahan', $schoolSetting->informasi_tambahan) }}</textarea>
            </div>

            <!-- Tombol Submit -->
            <div class="d-grid gap-2 mt-5">
                <button type="submit" class="btn btn-primary btn-lg">
                    💾 Simpan Pengaturan
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
