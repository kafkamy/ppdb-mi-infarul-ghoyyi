@extends('layouts.app')

@section('title', 'Verifikasi Bukti Pembayaran')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white py-3">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0 fw-bold"><i class="bi bi-credit-card-2-front-fill me-2"></i>Verifikasi Bukti Pembayaran</h5>
                <small class="opacity-75">Validasi bukti transfer, rincian biaya pendaftaran/daftar ulang, dan penerbitan Nomor Induk Siswa (NIS)</small>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.verifikasi-data') }}" class="btn btn-sm btn-info text-white fw-semibold">
                    <i class="bi bi-person-check-fill me-1"></i> Ke Verifikasi Data Siswa
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
            <a href="{{ route('admin.verifikasi-pembayaran', ['status_pembayaran' => 'Menunggu Verifikasi']) }}" 
               class="btn {{ $statusPembayaran === 'Menunggu Verifikasi' ? 'btn-warning text-dark fw-bold' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                <span class="badge {{ $statusPembayaran === 'Menunggu Verifikasi' ? 'bg-dark text-white' : 'bg-warning text-dark' }} ms-1">{{ $countMenunggu }}</span>
            </a>
            <a href="{{ route('admin.verifikasi-pembayaran', ['status_pembayaran' => 'Terverifikasi']) }}" 
               class="btn {{ $statusPembayaran === 'Terverifikasi' ? 'btn-success fw-bold' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi (Lunas)
                <span class="badge {{ $statusPembayaran === 'Terverifikasi' ? 'bg-white text-success' : 'bg-success' }} ms-1">{{ $countLunas }}</span>
            </a>
            <a href="{{ route('admin.verifikasi-pembayaran', ['status_pembayaran' => 'Ditolak']) }}" 
               class="btn {{ $statusPembayaran === 'Ditolak' ? 'btn-danger fw-bold' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-x-circle-fill me-1"></i> Pembayaran Ditolak
                <span class="badge {{ $statusPembayaran === 'Ditolak' ? 'bg-white text-danger' : 'bg-danger' }} ms-1">{{ $countDitolak }}</span>
            </a>
            <a href="{{ route('admin.verifikasi-pembayaran', ['status_pembayaran' => 'Belum Bayar']) }}" 
               class="btn {{ $statusPembayaran === 'Belum Bayar' ? 'btn-secondary fw-bold text-white' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-dash-circle me-1"></i> Belum Bayar
                <span class="badge {{ $statusPembayaran === 'Belum Bayar' ? 'bg-white text-dark' : 'bg-secondary' }} ms-1">{{ $countBelum }}</span>
            </a>
            <a href="{{ route('admin.verifikasi-pembayaran', ['status_pembayaran' => 'all']) }}" 
               class="btn {{ $statusPembayaran === 'all' ? 'btn-primary fw-bold' : 'btn-outline-secondary' }} rounded-pill px-3 py-2">
                <i class="bi bi-cash-stack me-1"></i> Semua Data
            </a>
        </div>

        {{-- Search & Filter Form --}}
        <form method="GET" action="{{ route('admin.verifikasi-pembayaran') }}" class="row g-2 mb-4">
            <input type="hidden" name="status_pembayaran" value="{{ $statusPembayaran }}">
            <div class="col-md-6 col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama siswa, pengirim, NISN, NIS, No. Peserta..." 
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
                <a href="{{ route('admin.verifikasi-pembayaran', ['status_pembayaran' => $statusPembayaran]) }}" class="btn btn-outline-secondary w-100">
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
                            <th width="14%">No. Peserta / NIS</th>
                            <th width="20%">Calon Siswa</th>
                            <th width="18%">Rincian Pembayaran</th>
                            <th width="16%">Bukti Transfer</th>
                            <th width="16%">Status Pembayaran</th>
                            <th width="16%" class="text-end">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <span class="font-monospace fw-bold text-dark">{{ $student->nomor_peserta_didik ?? '-' }}</span>
                                    @if($student->nis)
                                        <div class="mt-1">
                                            <span class="badge bg-success font-monospace px-2 py-1"><i class="bi bi-person-badge me-1"></i>NIS: {{ $student->nis }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-dark">{{ $student->nama_lengkap ?? 'Calon Siswa' }}</strong>
                                    <div class="small text-muted">{{ $student->email ?? '-' }}</div>
                                    @if($student->no_telepon)
                                        <div class="small text-muted"><i class="bi bi-whatsapp text-success me-1"></i>{{ $student->no_telepon }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">
                                        {{ $student->jumlah_pembayaran ? 'Rp ' . number_format($student->jumlah_pembayaran, 0, ',', '.') : 'Rp ' . number_format($student->biaya_pendaftaran ?? 1550000, 0, ',', '.') }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $student->bank_tujuan_pembayaran ?? '-' }}
                                    </div>
                                    @if($student->nama_pengirim_pembayaran)
                                        <div class="small text-secondary">
                                            a.n: <strong>{{ $student->nama_pengirim_pembayaran }}</strong>
                                        </div>
                                    @endif
                                    @if($student->tanggal_pembayaran)
                                        <div class="small text-muted" style="font-size: 0.75rem;">
                                            {{ $student->tanggal_pembayaran->format('d/m/Y H:i') }} WIB
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($student->bukti_pembayaran)
                                        @php
                                            $ext = pathinfo($student->bukti_pembayaran, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
                                        @endphp
                                        <div class="d-flex align-items-center gap-2">
                                            @if($isImage)
                                                <a href="{{ asset('storage/' . $student->bukti_pembayaran) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $student->bukti_pembayaran) }}" alt="Bukti" class="rounded border shadow-sm" style="width: 48px; height: 48px; object-fit: cover;">
                                                </a>
                                            @else
                                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-2"></i>
                                            @endif
                                            <div>
                                                <a href="{{ asset('storage/' . $student->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size:0.75rem;">
                                                    <i class="bi bi-box-arrow-up-right me-1"></i>Lihat
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <span class="badge bg-light text-muted border">Belum Upload</span>
                                    @endif
                                </td>
                                <td>
                                    @if($student->status_pembayaran === 'Terverifikasi' || $student->status_pembayaran === 'Lunas')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="bi bi-patch-check-fill me-1"></i> Terverifikasi (Lunas)
                                        </span>
                                        @if($student->tanggal_verifikasi_pembayaran)
                                            <div class="small text-muted mt-1" style="font-size:0.75rem;">
                                                {{ $student->tanggal_verifikasi_pembayaran->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    @elseif($student->status_pembayaran === 'Menunggu Verifikasi')
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                                        </span>
                                    @elseif($student->status_pembayaran === 'Ditolak')
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">
                                            <i class="bi bi-dash-circle me-1"></i> Belum Bayar
                                        </span>
                                    @endif

                                    @if($student->catatan_verifikasi_pembayaran)
                                        <div class="small text-danger mt-1 text-truncate" style="max-width: 160px;" title="{{ $student->catatan_verifikasi_pembayaran }}">
                                            <i class="bi bi-info-circle me-1"></i>{{ $student->catatan_verifikasi_pembayaran }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.students.show', $student->id) }}#section-verifikasi-pembayaran" 
                                           class="btn btn-sm btn-warning text-dark fw-bold px-3 py-1" title="Verifikasi Bukti Pembayaran">
                                            <i class="bi bi-credit-card me-1"></i> Verifikasi
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
                Tidak ada data pembayaran untuk filter status <strong>"{{ $statusPembayaran }}"</strong>.
            </div>
        @endif
    </div>
</div>
@endsection

