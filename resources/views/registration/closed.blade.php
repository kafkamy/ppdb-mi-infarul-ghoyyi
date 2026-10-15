@extends('layouts.app')

@section('title', 'Pendaftaran Ditutup')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">⚠️ Pendaftaran Ditutup</h4>
            </div>
            <div class="card-body text-center">
                <p class="fs-5">Maaf, pendaftaran peserta didik baru saat ini sedang tidak dibuka.</p>

                <div class="alert alert-info">
                    @if($schoolSetting->tanggal_buka_pendaftaran)
                        <p class="mb-1">
                            <strong>Pendaftaran dibuka tanggal:</strong><br>
                            {{ $schoolSetting->tanggal_buka_pendaftaran->format('d F Y') }}
                        </p>
                    @endif

                    @if($schoolSetting->tanggal_tutup_pendaftaran)
                        <p class="mb-0">
                            <strong>Pendaftaran ditutup tanggal:</strong><br>
                            {{ $schoolSetting->tanggal_tutup_pendaftaran->format('d F Y') }}
                        </p>
                    @endif
                </div>

                <p class="text-muted">
                    Silahkan kembali lagi pada jadwal pendaftaran yang telah ditentukan.
                </p>

                <h6 class="mt-4">Hubungi Kami untuk Informasi Lebih Lanjut:</h6>
                <p>
                    <strong>{{ $schoolSetting->nama_sekolah }}</strong><br>
                    {{ $schoolSetting->alamat }}<br>
                    @if($schoolSetting->no_telepon)
                        <strong>Telepon:</strong> {{ $schoolSetting->no_telepon }}<br>
                    @endif
                    @if($schoolSetting->email)
                        <strong>Email:</strong> {{ $schoolSetting->email }}
                    @endif
                </p>

                <a href="/" class="btn btn-primary mt-3">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
