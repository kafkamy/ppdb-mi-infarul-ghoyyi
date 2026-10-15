@extends('layouts.app')

@section('title', 'Detail Pendaftar - ' . $student->nama_lengkap)

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">👤 Detail Peserta Didik</h5>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-warning">
                    ✎ Edit
                </a>
                <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-light">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Status Pendaftaran -->
        <div class="alert alert-info">
            <strong>Nomor Peserta Didik:</strong> {{ $student->nomor_peserta_didik }}<br>
            <strong>Status Pendaftaran:</strong>
            @if($student->status_pendaftaran === 'Pending')
                <span class="badge bg-warning text-dark">⏳ Menunggu Verifikasi</span>
            @elseif($student->status_pendaftaran === 'Diterima')
                <span class="badge bg-success">✓ Diterima</span>
            @else
                <span class="badge bg-danger">✗ Ditolak</span>
            @endif
        </div>

        <!-- Data Pribadi -->
        <h6 class="mt-4 mb-3 border-bottom pb-2">Data Pribadi Siswa</h6>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama Lengkap:</strong> {{ $student->nama_lengkap }}</p>
                <p><strong>Nama Panggilan:</strong> {{ $student->nama_panggilan ?? '-' }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $student->jenis_kelamin }}</p>
                <p><strong>Tempat Lahir:</strong> {{ $student->tempat_lahir }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Tanggal Lahir:</strong> {{ $student->tanggal_lahir->format('d F Y') }}</p>
                <p><strong>Agama:</strong> {{ $student->agama }}</p>
                <p><strong>Kewarganegaraan:</strong> {{ $student->kewarganegaraan ?? '-' }}</p>
                <p><strong>Anak Ke-:</strong> {{ $student->anak_ke ?? '-' }} dari {{ $student->jumlah_saudara ?? '-' }} saudara</p>
            </div>
        </div>

        <!-- Alamat -->
        <h6 class="mt-4 mb-3 border-bottom pb-2">Alamat Tempat Tinggal</h6>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Alamat Lengkap:</strong> {{ $student->alamat }}</p>
                <p><strong>Desa/Kelurahan:</strong> {{ $student->desa_kelurahan ?? '-' }}</p>
                <p><strong>Kecamatan:</strong> {{ $student->kecamatan ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Kabupaten/Kota:</strong> {{ $student->kabupaten_kota }}</p>
                <p><strong>Provinsi:</strong> {{ $student->provinsi }}</p>
                <p><strong>Kode Pos:</strong> {{ $student->kode_pos ?? '-' }}</p>
            </div>
        </div>

        <!-- Kontak -->
        <h6 class="mt-4 mb-3 border-bottom pb-2">Kontak</h6>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nomor Telepon:</strong> {{ $student->no_telepon ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Email:</strong> {{ $student->email ?? '-' }}</p>
            </div>
        </div>

        <!-- Kesehatan -->
        @if($student->no_asuransi_kesehatan || $student->riwayat_kesehatan)
            <h6 class="mt-4 mb-3 border-bottom pb-2">Kesehatan</h6>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>No. Asuransi Kesehatan:</strong> {{ $student->no_asuransi_kesehatan ?? '-' }}</p>
                </div>
            </div>
            @if($student->riwayat_kesehatan)
                <p><strong>Riwayat Kesehatan:</strong><br>{{ $student->riwayat_kesehatan }}</p>
            @endif
        @endif

        <!-- Data Orang Tua -->
        <h6 class="mt-4 mb-3 border-bottom pb-2">Data Orang Tua / Wali</h6>

        <h6 class="text-muted mt-3">Ayah Kandung</h6>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama:</strong> {{ $student->nama_ayah }}</p>
                <p><strong>NIK:</strong> {{ $student->nik_ayah ?? '-' }}</p>
                <p><strong>Pekerjaan:</strong> {{ $student->pekerjaan_ayah ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Pendidikan:</strong> {{ $student->pendidikan_ayah ?? '-' }}</p>
                <p><strong>Telepon:</strong> {{ $student->no_telepon_ayah ?? '-' }}</p>
            </div>
        </div>

        <h6 class="text-muted mt-3">Ibu Kandung</h6>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama:</strong> {{ $student->nama_ibu }}</p>
                <p><strong>NIK:</strong> {{ $student->nik_ibu ?? '-' }}</p>
                <p><strong>Pekerjaan:</strong> {{ $student->pekerjaan_ibu ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Pendidikan:</strong> {{ $student->pendidikan_ibu ?? '-' }}</p>
                <p><strong>Telepon:</strong> {{ $student->no_telepon_ibu ?? '-' }}</p>
            </div>
        </div>

        @if($student->nama_wali)
            <h6 class="text-muted mt-3">Wali</h6>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $student->nama_wali }}</p>
                    <p><strong>NIK:</strong> {{ $student->nik_wali ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Pekerjaan:</strong> {{ $student->pekerjaan_wali ?? '-' }}</p>
                    <p><strong>Telepon:</strong> {{ $student->no_telepon_wali ?? '-' }}</p>
                </div>
            </div>
        @endif

        <!-- Sekolah Asal -->
        @if($student->asal_sekolah)
            <h6 class="mt-4 mb-3 border-bottom pb-2">Asal Sekolah</h6>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Sekolah:</strong> {{ $student->asal_sekolah }}</p>
                    <p><strong>NPSN:</strong> {{ $student->npsn_sekolah_asal ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tingkat Sebelumnya:</strong> {{ $student->tingkat_sebelumnya ?? '-' }}</p>
                </div>
            </div>
        @endif

        <!-- Data Pendaftaran -->
        <h6 class="mt-4 mb-3 border-bottom pb-2">Data Pendaftaran</h6>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Tahun Ajaran:</strong> {{ $student->tahun_ajaran }}</p>
                <p><strong>Kelas Pendaftaran:</strong> {{ $student->kelas_pendaftaran }}</p>
                <p><strong>Tanggal Pendaftaran:</strong> {{ $student->tanggal_daftar->format('d F Y H:i') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Biaya Pendaftaran:</strong> Rp {{ number_format($student->biaya_pendaftaran ?? 0, 0, ',', '.') }}</p>
                <p><strong>Email Terverifikasi:</strong> {{ $student->email_verified ? '✓ Ya' : '✗ Tidak' }}</p>
                <p><strong>Dokumen Lengkap:</strong> {{ $student->dokumen_lengkap ? '✓ Ya' : '✗ Tidak' }}</p>
            </div>
        </div>

        <!-- Dokumen yang Diunggah -->
        @if($student->file_akta_kelahiran || $student->file_kartu_keluarga || $student->file_foto_3x4)
            <h6 class="mt-4 mb-3 border-bottom pb-2">Dokumen yang Diunggah</h6>
            <div class="list-group">
                @if($student->file_akta_kelahiran)
                    <a href="{{ asset('storage/' . $student->file_akta_kelahiran) }}" 
                       target="_blank" class="list-group-item list-group-item-action">
                        📄 Akta Kelahiran
                    </a>
                @endif
                @if($student->file_kartu_keluarga)
                    <a href="{{ asset('storage/' . $student->file_kartu_keluarga) }}" 
                       target="_blank" class="list-group-item list-group-item-action">
                        📄 Kartu Keluarga
                    </a>
                @endif
                @if($student->file_foto_3x4)
                    <a href="{{ asset('storage/' . $student->file_foto_3x4) }}" 
                       target="_blank" class="list-group-item list-group-item-action">
                        🖼️ Foto 3x4
                    </a>
                @endif
            </div>
        @endif

        <!-- Tombol Aksi -->
        <div class="d-grid gap-2 mt-5 mb-3">
            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-warning btn-lg">
                ✎ Edit Data Pendaftar
            </a>
        </div>
    </div>
</div>
@endsection
