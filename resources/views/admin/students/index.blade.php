@extends('layouts.app')

@section('title', 'Daftar Pendaftar')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">📋 Daftar Peserta Didik Baru</h5>
            </div>
            <div class="col-auto d-flex gap-2">
                <a href="{{ route('admin.verifikasi-data') }}" class="btn btn-sm btn-info text-white fw-semibold">
                    <i class="bi bi-person-check-fill me-1"></i> Verifikasi Data Siswa
                </a>
                <a href="{{ route('admin.verifikasi-pembayaran') }}" class="btn btn-sm btn-warning text-dark fw-semibold">
                    <i class="bi bi-credit-card-2-front-fill me-1"></i> Verifikasi Pembayaran
                </a>
                <a href="{{ route('admin.export', request()->query()) }}" class="btn btn-sm btn-light">
                    📥 Export CSV
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, NISN, pengirim..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Status Pendaftaran --</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="Diterima" {{ request('status') === 'Diterima' ? 'selected' : '' }}>✓ Diterima</option>
                    <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>✗ Ditolak</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status_pembayaran" class="form-select">
                    <option value="">-- Status Pembayaran --</option>
                    <option value="Menunggu Verifikasi" {{ request('status_pembayaran') === 'Menunggu Verifikasi' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                    <option value="Terverifikasi" {{ request('status_pembayaran') === 'Terverifikasi' ? 'selected' : '' }}>✓ Terverifikasi (Lunas)</option>
                    <option value="Belum Bayar" {{ request('status_pembayaran') === 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="Ditolak" {{ request('status_pembayaran') === 'Ditolak' ? 'selected' : '' }}>✗ Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="tahun_ajaran" class="form-select">
                    <option value="">-- Semua Tahun --</option>
                    <option value="2026/2027" {{ request('tahun_ajaran') === '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">🔍</button>
            </div>
        </form>

        @if($students->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Peserta</th>
                            <th>Nama Lengkap</th>
                            <th>L/P</th>
                            <th>Kontak</th>
                            <th>Pendaftaran</th>
                            <th>Pembayaran</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <strong class="font-monospace">{{ $student->nomor_peserta_didik }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $student->nama_lengkap }}</strong><br>
                                    <small class="text-muted">{{ $student->asal_sekolah ?? '-' }}</small>
                                </td>
                                <td>{{ $student->jenis_kelamin ? $student->jenis_kelamin[0] : '-' }}</td>
                                <td>
                                    <small>
                                        @if($student->no_telepon)
                                            📱 {{ $student->no_telepon }}<br>
                                        @endif
                                        @if($student->email)
                                            ✉️ {{ $student->email }}
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    @if($student->status_pendaftaran === 'Pending')
                                        <span class="badge bg-warning text-dark">⏳ Menunggu</span>
                                    @elseif($student->status_pendaftaran === 'Diterima')
                                        <span class="badge bg-success">✓ Diterima</span>
                                    @else
                                        <span class="badge bg-danger">✗ Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($student->status_pembayaran === 'Terverifikasi' || $student->status_pembayaran === 'Lunas')
                                        <span class="badge bg-success">✓ Lunas</span>
                                    @elseif($student->status_pembayaran === 'Menunggu Verifikasi')
                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock-history me-1"></i>Verifikasi</span>
                                    @elseif($student->status_pembayaran === 'Ditolak')
                                        <span class="badge bg-danger">✗ Ditolak</span>
                                    @else
                                        <span class="badge bg-light text-secondary border">Belum</span>
                                    @endif
                                </td>
                                <td>{{ $student->tanggal_daftar ? $student->tanggal_daftar->format('d/m/Y') : '-' }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.students.show', $student->id) }}" 
                                           class="btn btn-sm btn-primary" title="Lihat Detail">
                                            👁️ Detail
                                        </a>
                                        @if($student->status_pendaftaran === 'Pending')
                                            <a href="{{ route('admin.students.show', $student->id) }}#section-verifikasi-data" 
                                               class="btn btn-sm btn-info text-white fw-bold" title="Verifikasi Data Siswa">
                                                <i class="bi bi-person-check me-1"></i>Data
                                            </a>
                                        @endif
                                        @if($student->status_pembayaran === 'Menunggu Verifikasi')
                                            <a href="{{ route('admin.students.show', $student->id) }}#section-verifikasi-pembayaran" 
                                               class="btn btn-sm btn-warning text-dark fw-bold" title="Verifikasi Pembayaran">
                                                <i class="bi bi-credit-card me-1"></i>Bayar
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $students->links() }}
            </div>
        @else
            <div class="alert alert-info">
                Tidak ada data pendaftar yang ditemukan.
            </div>
        @endif
    </div>
</div>
@endsection
