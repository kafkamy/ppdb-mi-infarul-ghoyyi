@extends('layouts.app')

@section('title', 'Daftar Pendaftar')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">📋 Daftar Peserta Didik Baru</h5>
            </div>
            <div class="col-auto">
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
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, NISN, email..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diterima" {{ request('status') === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="tahun_ajaran" class="form-select">
                    <option value="">-- Semua Tahun --</option>
                    <option value="2026/2027" {{ request('tahun_ajaran') === '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">🔍 Cari</button>
            </div>
        </form>

        @if($students->count())
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Peserta</th>
                            <th>Nama Lengkap</th>
                            <th>L/P</th>
                            <th>Tanggal Lahir</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <strong>{{ $student->nomor_peserta_didik }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $student->nama_lengkap }}</strong><br>
                                    <small class="text-muted">{{ $student->asal_sekolah ?? '-' }}</small>
                                </td>
                                <td>{{ $student->jenis_kelamin ? $student->jenis_kelamin[0] : '-' }}</td>
                                <td>{{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d/m/Y') : '-' }}</td>
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
                                <td>{{ $student->tanggal_daftar ? $student->tanggal_daftar->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.students.show', $student->id) }}" 
                                       class="btn btn-sm btn-primary" title="Lihat Detail">
                                        👁️ Lihat
                                    </a>
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
