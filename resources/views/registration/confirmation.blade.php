@extends('layouts.app')

@section('title', 'Konfirmasi Pendaftaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">✓ Pendaftaran Berhasil</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <strong>Selamat!</strong> Pendaftaran Anda telah berhasil diterima. 
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p>
                            <strong>Nomor Peserta Didik:</strong><br>
                            <span class="badge bg-primary fs-6">{{ $student->nomor_peserta_didik }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <strong>Tanggal Pendaftaran:</strong><br>
                            {{ $student->tanggal_daftar->format('d F Y') }}
                        </p>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Data yang Terdaftar:</h5>

                <table class="table table-sm">
                    <tr>
                        <td><strong>Nama Lengkap</strong></td>
                        <td>{{ $student->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td>{{ $student->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tempat, Tanggal Lahir</strong></td>
                        <td>{{ $student->tempat_lahir }}, {{ $student->tanggal_lahir->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Agama</strong></td>
                        <td>{{ $student->agama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>{{ $student->alamat }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kontak</strong></td>
                        <td>
                            {{ $student->no_telepon ?? '-' }}<br>
                            {{ $student->email ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Orang Tua / Wali</strong></td>
                        <td>
                            Ayah: {{ $student->nama_ayah }}<br>
                            Ibu: {{ $student->nama_ibu }}<br>
                            @if($student->nama_wali)
                                Wali: {{ $student->nama_wali }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Sekolah Asal</strong></td>
                        <td>{{ $student->asal_sekolah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tahun Ajaran</strong></td>
                        <td>{{ $student->tahun_ajaran }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status Pendaftaran</strong></td>
                        <td>
                            <span class="badge bg-warning text-dark">{{ $student->status_pendaftaran }}</span>
                        </td>
                    </tr>
                </table>

                <div class="alert alert-info mt-4">
                    <h6>📝 Langkah Berikutnya:</h6>
                    <ol class="mb-0">
                        <li>Simpan Nomor Peserta Didik Anda: <strong>{{ $student->nomor_peserta_didik }}</strong></li>
                        <li>Tunggu konfirmasi dari pihak sekolah melalui kontak yang Anda berikan</li>
                        <li>Persiapkan dokumen-dokumen yang diperlukan untuk verifikasi</li>
                        <li>Datang ke sekolah sesuai dengan jadwal yang telah ditentukan</li>
                    </ol>
                </div>

                <div class="alert alert-warning">
                    <strong>⚠️ Penting:</strong> Silahkan simpan atau catat Nomor Peserta Didik Anda untuk keperluan verifikasi selanjutnya. 
                    Anda dapat menggunakan nomor tersebut untuk memantau status pendaftaran Anda.
                </div>

                <div class="d-grid gap-2 mt-4">
                    <a href="{{ route('registration.index') }}" class="btn btn-primary">
                        ← Kembali ke Halaman Pendaftaran
                    </a>
                    <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-outline-primary">
                        📋 Lihat Detail Pendaftaran
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">📞 Hubungi Kami</h5>
            </div>
            <div class="card-body">
                <p>
                    <strong>{{ $schoolSetting->nama_sekolah }}</strong><br>
                    {{ $schoolSetting->alamat }}<br>
                    @if($schoolSetting->no_telepon)
                        Telepon: {{ $schoolSetting->no_telepon }}<br>
                    @endif
                    @if($schoolSetting->email)
                        Email: {{ $schoolSetting->email }}<br>
                    @endif
                    @if($schoolSetting->website)
                        Website: {{ $schoolSetting->website }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
