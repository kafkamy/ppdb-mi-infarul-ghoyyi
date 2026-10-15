@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('styles')
<style>
    .stat-card {
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,.07);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.1); }
    .stat-icon {
        width: 52px; height: 52px; border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; flex-shrink: 0;
    }
    .doc-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 0.75rem 1rem; border-radius: 0.75rem; background: #f8fafc;
        border: 1px solid #e2e8f0; margin-bottom: 0.5rem;
    }
    .doc-item:last-child { margin-bottom: 0; }

    /* Step tracker */
    .steps { display: flex; flex-direction: column; gap: 0; }
    .step-row { display: flex; align-items: flex-start; gap: .75rem; }
    .step-col { display: flex; flex-direction: column; align-items: center; }
    .step-circle {
        width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .75rem;
    }
    .step-circle.done   { background: var(--primary); color: #fff; }
    .step-circle.active { background: #f59e0b; color: #fff; box-shadow: 0 0 0 4px rgba(245,158,11,.2); }
    .step-circle.todo   { background: #e2e8f0; color: #94a3b8; }
    .step-connector { width: 2px; height: 28px; margin: 2px 0; }
    .step-connector.done { background: var(--primary); }
    .step-connector.todo { background: #e2e8f0; }
    .step-text { padding-top: 4px; padding-bottom: 20px; }
    .step-text h6 { font-size: .85rem; font-weight: 600; margin-bottom: 1px; }
    .step-text p  { font-size: .75rem; color: #94a3b8; margin-bottom: 0; }
</style>
@endsection

@section('content')

@php
    $namaDepan = $student->nama_lengkap
        ? implode(' ', array_slice(explode(' ', $student->nama_lengkap), 0, 2))
        : null;
    $statusMap = [
        'Pending'  => ['icon'=>'bi-hourglass-split',   'color'=>'warning', 'label'=>'Menunggu Verifikasi'],
        'Diterima' => ['icon'=>'bi-check-circle-fill',  'color'=>'success', 'label'=>'Diterima'],
        'Ditolak'  => ['icon'=>'bi-x-circle-fill',      'color'=>'danger',  'label'=>'Ditolak / Ditangguhkan'],
    ];
    $s = $statusMap[$student->status_pendaftaran] ?? $statusMap['Pending'];

    $step1Done = true;
    $step2Done = $isCompleted;
    $step3Done = $student->status_pendaftaran === 'Diterima';
@endphp

{{-- ── HEADER SELAMAT DATANG ── --}}
<div class="card border-0 mb-4 animate-fade-in overflow-hidden"
     style="border-radius:1.25rem; background: linear-gradient(135deg, var(--primary) 0%, #10b981 100%); animation-delay:.1s;">
    <div class="card-body p-4 p-md-5">
        <div class="d-md-flex align-items-center justify-content-between gap-3">
            <div class="text-white mb-3 mb-md-0">
                <p class="fw-semibold opacity-75 small text-uppercase mb-1" style="letter-spacing:.08em;">
                    <i class="bi bi-mortarboard-fill me-1"></i> Portal Calon Peserta Didik
                </p>
                <h2 class="fw-bold mb-1">
                    {{ $namaDepan ? 'Halo, '.$namaDepan.'!' : 'Selamat Datang!' }}
                </h2>
                <p class="mb-0 opacity-80 small">
                    <i class="bi bi-envelope-fill me-1"></i>{{ $student->email }}
                    @if($student->nomor_peserta_didik)
                        &nbsp;·&nbsp;<i class="bi bi-card-list me-1"></i>No. <strong>{{ $student->nomor_peserta_didik }}</strong>
                    @endif
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                @if($isCompleted)
                <a href="{{ route('registration.letter', $student->id) }}" target="_blank"
                   class="btn btn-light text-primary fw-bold rounded-pill px-4">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak Bukti
                </a>
                @endif
                <form action="{{ route('siswa.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light rounded-pill px-4 fw-semibold">
                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- ── KIRI: Status & Langkah ── --}}
    <div class="col-lg-4">

        {{-- Status Pendaftaran --}}
        <div class="card border-0 shadow-sm mb-4 animate-fade-in" style="border-radius:1rem; animation-delay:.2s;">
            <div class="card-body p-4">
                <p class="text-muted text-uppercase fw-semibold mb-3" style="font-size:.72rem; letter-spacing:.08em;">Status Pendaftaran</p>

                @if(!$isCompleted)
                    <div class="text-center py-2">
                        <div class="d-inline-flex bg-warning bg-opacity-10 rounded-3 p-3 mb-3">
                            <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-1">Formulir Belum Lengkap</h6>
                        <p class="text-muted small mb-3">Silakan lengkapi seluruh data diri, orang tua, dan dokumen.</p>
                        <a href="{{ route('siswa.formulir') }}" class="btn btn-primary rounded-pill w-100 fw-bold py-2">
                            <i class="bi bi-pencil-square me-1"></i> Lengkapi Sekarang
                        </a>
                    </div>
                @else
                    <div class="text-center py-2">
                        <div class="d-inline-flex bg-{{ $s['color'] }} bg-opacity-10 rounded-3 p-3 mb-3">
                            <i class="bi {{ $s['icon'] }} text-{{ $s['color'] }} fs-1"></i>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-{{ $s['color'] }} bg-opacity-15 text-{{ $s['color'] }} px-3 py-2 rounded-pill fw-semibold" style="font-size:.85rem;">
                                {{ $s['label'] }}
                            </span>
                        </div>
                        @if($student->status_pendaftaran === 'Pending')
                            <p class="text-muted small mb-3">Data Anda sedang diverifikasi oleh panitia PPDB. Harap menunggu.</p>
                        @elseif($student->status_pendaftaran === 'Diterima')
                            <p class="text-muted small mb-3">Selamat! Anda <strong class="text-success">DITERIMA</strong>. Lakukan daftar ulang sesuai jadwal.</p>
                        @else
                            <p class="text-muted small mb-3">Mohon maaf, berkas belum memenuhi syarat. Hubungi admin sekolah.</p>
                        @endif
                        <a href="{{ route('siswa.formulir') }}" class="btn btn-outline-primary rounded-pill w-100 fw-semibold">
                            <i class="bi bi-eye me-1"></i> Lihat / Edit Formulir
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Alur Pendaftaran --}}
        <div class="card border-0 shadow-sm animate-fade-in" style="border-radius:1rem; animation-delay:.3s;">
            <div class="card-body p-4">
                <p class="text-muted text-uppercase fw-semibold mb-4" style="font-size:.72rem; letter-spacing:.08em;">Alur Pendaftaran</p>
                <div class="steps">
                    {{-- Step 1 --}}
                    <div class="step-row">
                        <div class="step-col">
                            <div class="step-circle done"><i class="bi bi-check2"></i></div>
                            <div class="step-connector {{ $step2Done ? 'done' : 'todo' }}"></div>
                        </div>
                        <div class="step-text">
                            <h6 class="text-success">Buat Akun <i class="bi bi-check-circle-fill text-success" style="font-size:.8rem;"></i></h6>
                            <p>Registrasi email &amp; password</p>
                        </div>
                    </div>
                    {{-- Step 2 --}}
                    <div class="step-row">
                        <div class="step-col">
                            <div class="step-circle {{ $step2Done ? 'done' : 'active' }}">
                                @if($step2Done)<i class="bi bi-check2"></i>@else 2 @endif
                            </div>
                            <div class="step-connector {{ $step3Done ? 'done' : 'todo' }}"></div>
                        </div>
                        <div class="step-text">
                            <h6 class="{{ $step2Done ? 'text-success' : 'text-warning' }}">
                                Isi Formulir @if($step2Done)<i class="bi bi-check-circle-fill" style="font-size:.8rem;"></i>@endif
                            </h6>
                            <p>Data diri, orang tua &amp; dokumen</p>
                        </div>
                    </div>
                    {{-- Step 3 --}}
                    <div class="step-row">
                        <div class="step-col">
                            <div class="step-circle {{ $step3Done ? 'done' : 'todo' }}">
                                @if($step3Done)<i class="bi bi-check2"></i>@else 3 @endif
                            </div>
                            <div class="step-connector todo"></div>
                        </div>
                        <div class="step-text">
                            <h6 class="{{ $step3Done ? 'text-success' : 'text-muted' }}">
                                Verifikasi Panitia
                            </h6>
                            <p>Status diterima / ditolak</p>
                        </div>
                    </div>
                    {{-- Step 4 --}}
                    <div class="step-row">
                        <div class="step-col">
                            <div class="step-circle todo">4</div>
                        </div>
                        <div class="step-text" style="padding-bottom:0;">
                            <h6 class="text-muted">Daftar Ulang</h6>
                            <p>Pembayaran &amp; daftar ulang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── KANAN: Statistik, Data, Dokumen ── --}}
    <div class="col-lg-8">

        {{-- Stats Row --}}
        <div class="row g-3 mb-4">
            <div class="col-sm-4">
                <div class="card stat-card animate-fade-in" style="animation-delay:.2s;">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-calendar3"></i></div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size:.75rem;">Tahun Ajaran</div>
                        <div class="fw-bold" style="font-size:1rem;">{{ $student->tahun_ajaran ?? '2026/2027' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card stat-card animate-fade-in" style="animation-delay:.25s;">
                    <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-cash-coin"></i></div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size:.75rem;">Biaya Pendaftaran</div>
                        <div class="fw-bold" style="font-size:1rem;">
                            {{ $student->biaya_pendaftaran ? 'Rp '.number_format($student->biaya_pendaftaran, 0, ',', '.') : '—' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card stat-card animate-fade-in" style="animation-delay:.3s;">
                    <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-person-vcard"></i></div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size:.75rem;">No. Peserta</div>
                        <div class="fw-bold" style="font-size:.9rem;">{{ $student->nomor_peserta_didik ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Calon Peserta --}}
        <div class="card border-0 shadow-sm mb-4 animate-fade-in" style="border-radius:1rem; animation-delay:.35s;">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i>Data Calon Peserta</h6>
                <a href="{{ route('siswa.formulir') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
            </div>
            <div class="card-body px-4 pb-4 pt-3">
                @if(!$isCompleted)
                    <div class="text-center py-4">
                        <i class="bi bi-folder-x display-3 text-muted opacity-25"></i>
                        <p class="text-muted mt-3 mb-0 small">
                            Data belum diisi.
                            <a href="{{ route('siswa.formulir') }}" class="text-primary fw-semibold">Isi Formulir →</a>
                        </p>
                    </div>
                @else
                    <table class="table table-borderless align-middle mb-0" style="font-size:.88rem;">
                        <tbody>
                            <tr>
                                <td class="text-muted py-1" width="35%">Nama Lengkap</td>
                                <td class="fw-semibold py-1">{{ $student->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1">Jenis Kelamin</td>
                                <td class="py-1">{{ $student->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1">Tempat, Tgl Lahir</td>
                                <td class="py-1">
                                    {{ $student->tempat_lahir }},
                                    {{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d-m-Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1">Agama</td>
                                <td class="py-1">{{ $student->agama }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1">Alamat</td>
                                <td class="py-1 small">
                                    {{ $student->alamat }}@if($student->kecamatan), Kec. {{ $student->kecamatan }}@endif,
                                    {{ $student->kabupaten_kota }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1">Orang Tua</td>
                                <td class="py-1">{{ $student->nama_ayah }} / {{ $student->nama_ibu }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted py-1">Asal Sekolah</td>
                                <td class="py-1">{{ $student->asal_sekolah ?: '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Kelengkapan Dokumen --}}
        <div class="card border-0 shadow-sm animate-fade-in" style="border-radius:1rem; animation-delay:.4s;">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="bi bi-folder2-open text-primary me-2"></i>Kelengkapan Dokumen</h6>
                <a href="{{ route('siswa.formulir') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-cloud-upload me-1"></i> Upload
                </a>
            </div>
            <div class="card-body px-4 pb-4 pt-3">
                @php
                    $docs = [
                        ['label'=>'Akta Kelahiran',   'icon'=>'bi-file-earmark-person-fill', 'color'=>'text-primary', 'field'=>$student->file_akta_kelahiran],
                        ['label'=>'Kartu Keluarga',   'icon'=>'bi-people-fill',              'color'=>'text-info',    'field'=>$student->file_kartu_keluarga],
                        ['label'=>'Pas Foto 3×4',     'icon'=>'bi-image-fill',               'color'=>'text-success', 'field'=>$student->file_foto_3x4],
                    ];
                @endphp
                @foreach($docs as $doc)
                <div class="doc-item">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi {{ $doc['icon'] }} fs-4 {{ $doc['color'] }}"></i>
                        <span class="fw-semibold" style="font-size:.88rem;">{{ $doc['label'] }}</span>
                    </div>
                    @if($doc['field'])
                        <span class="badge bg-success rounded-pill px-3"><i class="bi bi-check-circle-fill me-1"></i>Terunggah</span>
                    @else
                        <span class="badge bg-light text-secondary border rounded-pill px-3"><i class="bi bi-dash-circle me-1"></i>Belum ada</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>{{-- end col-lg-8 --}}
</div>{{-- end row --}}
@endsection
