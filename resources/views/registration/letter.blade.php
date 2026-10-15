@extends('layouts.app')

@section('title', 'Surat Konfirmasi Pendaftaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Surat Konfirmasi Pendaftaran</h4>
            </div>
            <div class="card-body">
                <p>Berikut ini adalah konfirmasi pendaftaran untuk:</p>
                <ul>
                    <li><strong>Nama:</strong> {{ $student->nama_lengkap }}</li>
                    <li><strong>Nomor Peserta Didik:</strong> {{ $student->nomor_peserta_didik }}</li>
                    <li><strong>Tanggal Daftar:</strong> {{ $student->tanggal_daftar->format('d F Y') }}</li>
                    <li><strong>Status:</strong> {{ $student->status_pendaftaran }}</li>
                </ul>
                <p>Silahkan cetak halaman ini sebagai bukti pendaftaran. Hubungi pihak sekolah jika ada pertanyaan lebih lanjut.</p>
                <div class="d-grid gap-2 mt-4">
                    <button onclick="window.print()" class="btn btn-primary">Cetak Surat Konfirmasi</button>
                    <a href="{{ route('registration.confirmation', $student->id) }}" class="btn btn-outline-secondary">Kembali ke Halaman Konfirmasi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
