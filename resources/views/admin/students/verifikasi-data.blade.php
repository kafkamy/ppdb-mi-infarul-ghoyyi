@extends('layouts.app')

@section('title', 'Verifikasi Data Calon Siswa')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white py-3">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-check-fill me-2"></i>Verifikasi Data Calon Siswa</h5>
                <small class="opacity-75">Pemeriksaan formulir identitas, biodata orang tua, dan dokumen pendaftaran calon siswa</small>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.verifikasi-pembayaran') }}" class="btn btn-sm btn-warning text-dark fw-semibold">
                    <i class="bi bi-credit-card-2-front-fill me-1"></i> Ke Verifikasi Pembayaran
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light fw-semibold">
                    ← Kembali ke Dashboard
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

        {{-- Filter Status Tabs --}}
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('admin.verifikasi-data', ['status' => 'Pending']) }}" 
               class="btn {{ $status === 'Pending' ? 'btn-warning text-dark fw-bold' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                <span class="badge {{ $status === 'Pending' ? 'bg-dark text-white' : 'bg-warning text-dark' }} ms-1">{{ $countPending }}</span>
            </a>
            <a href="{{ route('admin.verifikasi-data', ['status' => 'Diterima']) }}" 
               class="btn {{ $status === 'Diterima' ? 'btn-success fw-bold' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-check-circle-fill me-1"></i> Data Disetujui (Diterima)
                <span class="badge {{ $status === 'Diterima' ? 'bg-white text-success' : 'bg-success' }} ms-1">{{ $countDiterima }}</span>
            </a>
            <a href="{{ route('admin.verifikasi-data', ['status' => 'Ditolak']) }}" 
               class="btn {{ $status === 'Ditolak' ? 'btn-danger fw-bold' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-x-circle-fill me-1"></i> Data Ditolak
                <span class="badge {{ $status === 'Ditolak' ? 'bg-white text-danger' : 'bg-danger' }} ms-1">{{ $countDitolak }}</span>
            </a>
            <a href="{{ route('admin.verifikasi-data', ['status' => 'all']) }}" 
               class="btn {{ $status === 'all' ? 'btn-primary fw-bold' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-people-fill me-1"></i> Semua Calon Siswa
                <span class="badge {{ $status === 'all' ? 'bg-white text-primary' : 'bg-secondary' }} ms-1">{{ $countTotal }}</span>
            </a>
        </div>

        {{-- Search & Year Filter Form --}}
        <form method="GET" action="{{ route('admin.verifikasi-data') }}" class="row g-2 mb-4">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="col-md-6 col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama siswa, NISN, No. Peserta, email..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <select name="tahun_ajaran" class="form-select">
                    <option value="">-- Semua Tahun Ajaran --</option>
                    <option value="2026/2027" {{ request('tahun_ajaran') === '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                </select>
            </div>
            <div class="col-md-2 col-lg-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-filter me-1"></i> Terapkan
                </button>
            </div>
            @if(request('search') || request('tahun_ajaran'))
            <div class="col-md-2 col-lg-2">
                <a href="{{ route('admin.verifikasi-data', ['status' => $status]) }}" class="btn btn-outline-secondary w-100">
                    Reset Filter
                </a>
            </div>
            @endif
        </form>

        @if($students->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="12%">No. Peserta</th>
                            <th width="24%">Calon Siswa</th>
                            <th width="16%">Kontak &amp; Wali</th>
                            <th width="18%">Dokumen Berkas</th>
                            <th width="15%">Status Data</th>
                            <th width="15%" class="text-end">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <span class="font-monospace fw-bold text-dark">{{ $student->nomor_peserta_didik ?? '-' }}</span>
                                    <div class="small text-muted">{{ $student->tahun_ajaran }}</div>
                                </td>
                                <td>
                                    <strong class="text-dark">{{ $student->nama_lengkap ?? 'Belum Lengkap' }}</strong>
                                    <div class="small text-muted">
                                        {{ $student->jenis_kelamin ?? '-' }} &bull; {{ $student->tempat_lahir ?? '-' }}, {{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d/m/Y') : '-' }}
                                    </div>
                                    @if($student->asal_sekolah)
                                        <div class="small text-secondary"><i class="bi bi-building me-1"></i>{{ $student->asal_sekolah }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        @if($student->nama_ayah || $student->nama_ibu)
                                            <div><i class="bi bi-people me-1"></i>{{ $student->nama_ayah ?? $student->nama_ibu }}</div>
                                        @endif
                                        @if($student->no_telepon)
                                            <div><i class="bi bi-whatsapp text-success me-1"></i>{{ $student->no_telepon }}</div>
                                        @endif
                                        @if($student->email)
                                            <div class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $student->email }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <div class="small">
                                            @if($student->file_akta_kelahiran)
                                                <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Akta</span>
                                            @else
                                                <span class="text-muted opacity-50"><i class="bi bi-dash-circle me-1"></i>Akta</span>
                                            @endif
                                            &bull;
                                            @if($student->file_kartu_keluarga)
                                                <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>KK</span>
                                            @else
                                                <span class="text-muted opacity-50"><i class="bi bi-dash-circle me-1"></i>KK</span>
                                            @endif
                                            &bull;
                                            @if($student->file_foto_3x4)
                                                <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Foto</span>
                                            @else
                                                <span class="text-muted opacity-50"><i class="bi bi-dash-circle me-1"></i>Foto</span>
                                            @endif
                                        </div>
                                        <div>
                                            @if($student->dokumen_lengkap)
                                                <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25 rounded-pill" style="font-size:0.75rem;">
                                                    <i class="bi bi-check2-circle me-1"></i>Berkas Lengkap
                                                </span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-15 text-secondary border border-secondary border-opacity-25 rounded-pill" style="font-size:0.75rem;">
                                                    <i class="bi bi-clock me-1"></i>Belum Terverifikasi Lengkap
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($student->status_pendaftaran === 'Pending')
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                                        </span>
                                    @elseif($student->status_pendaftaran === 'Diterima')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="bi bi-check-circle-fill me-1"></i> Diterima
                                        </span>
                                        @if($student->tanggal_verifikasi_pendaftaran)
                                            <div class="small text-muted mt-1" style="font-size:0.75rem;">
                                                {{ $student->tanggal_verifikasi_pendaftaran->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                        </span>
                                    @endif

                                    @if($student->catatan_verifikasi_pendaftaran)
                                        <div class="small text-danger mt-1 text-truncate" style="max-width: 160px;" title="{{ $student->catatan_verifikasi_pendaftaran }}">
                                            <i class="bi bi-info-circle me-1"></i>{{ $student->catatan_verifikasi_pendaftaran }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.students.show', $student->id) }}#section-verifikasi-data" 
                                           class="btn btn-sm btn-primary fw-semibold px-3 py-1" title="Verifikasi Data Siswa">
                                            <i class="bi bi-shield-check me-1"></i> Verifikasi
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $students->appends(request()->query())->links() }}
            </div>
        @else
            <div class="alert alert-info text-center py-4 my-3 rounded-4">
                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                Tidak ada data calon siswa untuk filter status <strong>"{{ $status }}"</strong>.
            </div>
        @endif
    </div>
</div>
@endsection

