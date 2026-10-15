@extends('layouts.app')

@section('title', 'Informasi Pembayaran')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-lg-8 animate-fade-in">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-info text-white text-center py-4">
                <h2 class="fw-bold mb-0"><i class="bi bi-credit-card me-2"></i>Informasi Pembayaran</h2>
            </div>
            <div class="card-body p-5">
                <div class="alert alert-primary mb-5" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i> 
                    <strong>Pemberitahuan:</strong> Berikut adalah rincian biaya pendaftaran peserta didik baru MI Infarul Ghoyyi Kalijambe. Pembayaran dilakukan setelah proses pendaftaran awal disetujui.
                </div>

                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Rincian Biaya</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>Formulir & Administrasi Pendaftaran</td>
                                <td class="text-end">Rp 100.000</td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>Seragam Sekolah (3 Stel)</td>
                                <td class="text-end">Rp 650.000</td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>Buku Paket & Modul (Semester 1)</td>
                                <td class="text-end">Rp 450.000</td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>Kegiatan Ekstrakurikuler (1 Tahun)</td>
                                <td class="text-end">Rp 200.000</td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td>SPP Bulan Juli</td>
                                <td class="text-end">Rp 150.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold table-light">
                                <td colspan="2" class="text-end">Total Biaya Masuk:</td>
                                <td class="text-end text-primary fs-5">Rp 1.550.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <h4 class="fw-bold border-bottom pb-2 mb-4">Metode Pembayaran</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-primary h-100">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-bank2 fs-1 text-primary mb-3"></i>
                                <h5 class="fw-bold mb-3">Transfer Bank</h5>
                                <p class="mb-1 text-secondary">Bank Syariah Indonesia (BSI)</p>
                                <h4 class="fw-bold text-dark font-monospace mb-2">1234 5678 90</h4>
                                <p class="mb-0 text-secondary">a.n. MI Infarul Ghoyyi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success h-100">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-cash-coin fs-1 text-success mb-3"></i>
                                <h5 class="fw-bold mb-3">Pembayaran Tunai</h5>
                                <p class="mb-0 text-secondary">Pembayaran dapat dilakukan langsung di loket Tata Usaha (TU) MI Infarul Ghoyyi pada jam kerja (Senin - Sabtu, 08:00 - 14:00 WIB).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
