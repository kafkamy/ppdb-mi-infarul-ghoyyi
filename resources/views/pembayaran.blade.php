@extends('layouts.app')

@section('title', 'Informasi & Bukti Pembayaran')

@section('styles')
<style>
    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 1rem;
        background: #f8fafc;
        padding: 2rem 1.5rem;
        text-align: center;
        transition: all 0.25s ease;
        cursor: pointer;
    }
    .upload-zone:hover, .upload-zone.dragover {
        border-color: var(--primary);
        background: rgba(21, 128, 61, 0.05);
    }
    .status-badge {
        font-size: 0.95rem;
        padding: 0.5rem 1.25rem;
        border-radius: 9999px;
    }
    .copy-btn {
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .copy-btn:active {
        transform: scale(0.95);
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center mt-3 mb-5">
    <div class="col-lg-10 animate-fade-in">

        {{-- Header Kartu Pembayaran --}}
        <div class="card border-0 mb-4 overflow-hidden"
             style="border-radius:1.25rem; background: linear-gradient(135deg, var(--primary) 0%, #059669 100%);">
            <div class="card-body p-4 p-md-5 text-white">
                <div class="d-md-flex align-items-center justify-content-between gap-3">
                    <div>
                        <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 rounded-pill fw-semibold mb-2">
                            <i class="bi bi-credit-card-2-front me-1"></i> PPDB MI Infarul Ghoyyi
                        </span>
                        <h2 class="fw-bold mb-1">Informasi &amp; Upload Bukti Pembayaran</h2>
                        <p class="mb-0 opacity-80 small">
                            Calon Siswa: <strong>{{ $student->nama_lengkap ?? 'Calon Peserta' }}</strong>
                            @if($student->nomor_peserta_didik)
                                &nbsp;·&nbsp; No. Pendaftaran: <strong>{{ $student->nomor_peserta_didik }}</strong>
                            @endif
                            @if($student->nis)
                                &nbsp;·&nbsp; <span class="badge bg-white text-success fw-bold px-2 py-1"><i class="bi bi-person-badge-fill me-1"></i>NIS: {{ $student->nis }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-end">
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-light text-primary fw-bold rounded-pill px-4">
                            <i class="bi bi-arrow-left me-1"></i> Ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifikasi Flash --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5 text-success align-middle"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-danger align-middle"></i>
                <strong>Perhatian:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger shadow-sm mb-4">
                <div class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-1"></i> Terjadi kesalahan validasi:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- STATUS PEMBAYARAN SAAT INI --}}
        @php
            $statusBayar = $student->status_pembayaran ?? 'Belum Bayar';
        @endphp

        <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold d-block mb-1">Status Pembayaran Saat Ini</span>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            @if($statusBayar === 'Terverifikasi' || $statusBayar === 'Lunas')
                                <span class="badge bg-success status-badge text-white">
                                    <i class="bi bi-check-circle-fill me-1"></i> Pembayaran Terverifikasi (Lunas)
                                </span>
                            @elseif($statusBayar === 'Menunggu Verifikasi')
                                <span class="badge bg-warning status-badge text-dark">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi Panitia
                                </span>
                            @elseif($statusBayar === 'Ditolak')
                                <span class="badge bg-danger status-badge text-white">
                                    <i class="bi bi-x-circle-fill me-1"></i> Bukti Pembayaran Ditolak
                                </span>
                            @else
                                <span class="badge bg-secondary status-badge text-white">
                                    <i class="bi bi-clock me-1"></i> Belum Melakukan Pembayaran
                                </span>
                            @endif

                            @if($student->jumlah_pembayaran)
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                    Nominal: <strong>Rp {{ number_format($student->jumlah_pembayaran, 0, ',', '.') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($student->bukti_pembayaran)
                        <div class="d-flex gap-2">
                            <a href="{{ asset('storage/' . $student->bukti_pembayaran) }}" target="_blank" class="btn btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-file-earmark-image me-1"></i> Lihat Bukti Terunggah
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Deskripsi Status --}}
                <hr class="my-3">
                @if($statusBayar === 'Terverifikasi' || $statusBayar === 'Lunas')
                    <div class="alert alert-success bg-success bg-opacity-10 border-0 mb-0">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-patch-check-fill text-success fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-success mb-1">Alhamdulillah! Pembayaran Anda telah terverifikasi.</h6>
                                <p class="mb-2 small text-dark">
                                    Terima kasih, administrasi pembayaran pendaftaran peserta didik baru telah diterima dan disahkan oleh panitia PPDB MI Infarul Ghoyyi.
                                </p>
                                @if($student->nis)
                                    <div class="p-3 bg-white rounded-3 border border-success border-opacity-50 mb-2">
                                        <div class="small text-muted text-uppercase fw-semibold">Nomor Induk Siswa (NIS) Resmi Anda:</div>
                                        <div class="fs-4 fw-bold text-success font-monospace my-1">
                                            <i class="bi bi-person-badge-fill me-1"></i>{{ $student->nis }}
                                        </div>
                                        <small class="text-muted">Simpan dan catat NIS ini sebagai identitas resmi siswa di MI Infarul Ghoyyi Kalijambe.</small>
                                    </div>
                                @endif
                                @if($student->tanggal_verifikasi_pembayaran)
                                    <span class="text-muted small">
                                        <i class="bi bi-calendar-check me-1"></i>Diverifikasi pada: {{ $student->tanggal_verifikasi_pembayaran->format('d F Y, H:i') }} WIB
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($statusBayar === 'Menunggu Verifikasi')
                    <div class="alert alert-warning bg-warning bg-opacity-10 border-0 mb-0">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-hourglass-split text-warning fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Bukti pembayaran Anda sedang diproses.</h6>
                                <p class="mb-1 small text-dark">
                                    Bukti pembayaran telah berhasil terkirim pada {{ $student->tanggal_pembayaran ? $student->tanggal_pembayaran->format('d F Y, H:i') : now()->format('d F Y') }} WIB. Panitia akan memeriksa kesesuaian data transfer dalam waktu 1x24 jam kerja.
                                </p>
                                <span class="text-muted small">Jika ada kekeliruan file bukti, Anda dapat mengunggah ulang form bukti transfer di bawah.</span>
                            </div>
                        </div>
                    </div>
                @elseif($statusBayar === 'Ditolak')
                    <div class="alert alert-danger bg-danger bg-opacity-10 border-0 mb-0">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-octagon-fill text-danger fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-danger mb-1">Bukti transfer belum dapat disetujui.</h6>
                                <p class="mb-1 small text-dark">
                                    <strong>Catatan Panitia:</strong> {{ $student->catatan_verifikasi_pembayaran ?: 'Bukti transfer tidak terbaca / nominal tidak sesuai. Silakan upload ulang bukti yang sah.' }}
                                </p>
                                <span class="text-muted small">Silakan periksa kembali struk transfer Anda dan unggah ulang bukti yang benar pada formulir di bawah ini.</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-primary bg-primary bg-opacity-10 border-0 mb-0">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Silakan lakukan pembayaran sesuai rincian biaya di bawah, kemudian upload foto atau scan struk transfer pada formulir yang tersedia.
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-4">
            {{-- KOLOM KIRI: RINCIAN BIAYA & INSTRUKSI REKENING --}}
            <div class="col-lg-6">
                {{-- Rincian Biaya --}}
                <div class="card border-0 shadow-sm h-100" style="border-radius:1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-receipt text-primary me-2"></i>Rincian Biaya Masuk
                        </h5>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Komponen Biaya</th>
                                        <th class="text-end">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>Formulir &amp; Administrasi</td>
                                        <td class="text-end fw-semibold">Rp 100.000</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>Seragam Sekolah (3 Stel Lengkap)</td>
                                        <td class="text-end fw-semibold">Rp 650.000</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>Buku Paket &amp; Modul Semester 1</td>
                                        <td class="text-end fw-semibold">Rp 450.000</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td>Kegiatan Ekstrakurikuler (1 Tahun)</td>
                                        <td class="text-end fw-semibold">Rp 200.000</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">5</td>
                                        <td>Infaq SPP Bulan Pertama (Juli)</td>
                                        <td class="text-end fw-semibold">Rp 150.000</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="table-light border-top">
                                        <td colspan="2" class="fw-bold text-end">Total Biaya:</td>
                                        <td class="text-end fw-bold text-success fs-6">
                                            Rp {{ number_format($schoolSetting->biaya_pendaftaran ?? 1550000, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <h6 class="fw-bold mt-4 mb-3 text-dark">
                            <i class="bi bi-wallet2 text-primary me-2"></i>Tujuan Transfer
                        </h6>

                        <div class="card bg-light border-0 p-3 mb-3" style="border-radius: 0.75rem;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                        <i class="bi bi-bank fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">Bank Syariah Indonesia (BSI)</div>
                                        <div class="font-monospace text-primary fw-bold fs-5" id="rekBsi">1234567890</div>
                                        <small class="text-muted">a.n. MI Infarul Ghoyyi Kalijambe</small>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill copy-btn" onclick="copyRekening('1234567890', this)">
                                    <i class="bi bi-clipboard me-1"></i> Salin
                                </button>
                            </div>
                        </div>

                        <div class="card bg-light border-0 p-3" style="border-radius: 0.75rem;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-success text-white p-2 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                    <i class="bi bi-cash-coin fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-1">Pembayaran Tunai di Loket TU</div>
                                    <p class="text-muted small mb-0">
                                        Bagi wali murid yang ingin membayar secara tunai, silakan datang langsung ke kantor TU MI Infarul Ghoyyi pada jam kerja (Senin - Sabtu, 08:00 - 14:00 WIB). Kuitansi dari TU dapat difoto lalu diunggah di sini.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORMULIR UPLOAD BUKTI PEMBAYARAN --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100" style="border-radius:1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-cloud-arrow-up text-primary me-2"></i>
                            @if($statusBayar === 'Terverifikasi' || $statusBayar === 'Lunas')
                                Bukti Pembayaran Terverifikasi
                            @elseif($statusBayar === 'Menunggu Verifikasi')
                                Perbarui / Unggah Ulang Bukti Pembayaran
                            @else
                                Unggah Bukti Pembayaran
                            @endif
                        </h5>
                    </div>
                    <div class="card-body px-4 pb-4">

                        {{-- Tampilan Bukti yang sudah ada jika sudah terverifikasi / pending --}}
                        @if($student->bukti_pembayaran)
                            <div class="p-3 bg-light rounded-3 mb-4 border">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="small fw-bold text-muted text-uppercase">Bukti Saat Ini:</span>
                                    <a href="{{ asset('storage/' . $student->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-link text-primary p-0">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka File Penuh
                                    </a>
                                </div>
                                @php
                                    $ext = pathinfo($student->bukti_pembayaran, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
                                @endphp
                                @if($isImage)
                                    <div class="text-center bg-white p-2 rounded border">
                                        <img src="{{ asset('storage/' . $student->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 180px; object-fit: contain;">
                                    </div>
                                @else
                                    <div class="text-center p-3 bg-white rounded border">
                                        <i class="bi bi-file-earmark-pdf text-danger display-5"></i>
                                        <p class="small text-muted mb-0 mt-2">Dokumen Bukti (PDF)</p>
                                    </div>
                                @endif
                                <div class="row g-2 mt-2 small text-muted">
                                    <div class="col-6"><strong>Pengirim:</strong> {{ $student->nama_pengirim_pembayaran ?? '-' }}</div>
                                    <div class="col-6"><strong>Metode:</strong> {{ $student->bank_tujuan_pembayaran ?? '-' }}</div>
                                    <div class="col-6"><strong>Nominal:</strong> Rp {{ number_format($student->jumlah_pembayaran ?? 0, 0, ',', '.') }}</div>
                                    <div class="col-6"><strong>Tanggal:</strong> {{ $student->tanggal_pembayaran ? $student->tanggal_pembayaran->format('d/m/Y') : '-' }}</div>
                                </div>
                            </div>
                        @endif

                        @if($statusBayar === 'Terverifikasi' || $statusBayar === 'Lunas')
                            <div class="text-center py-3">
                                <div class="text-success mb-2"><i class="bi bi-shield-fill-check display-4"></i></div>
                                <h6 class="fw-bold text-dark">Pembayaran Telah Selesai</h6>
                                <p class="text-muted small mb-3">Tidak perlu melakukan unggah ulang kecuali diminta oleh pihak panitia sekolah.</p>
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="document.getElementById('formUploadSection').classList.toggle('d-none')">
                                    <i class="bi bi-pencil-square me-1"></i> Tampilkan Form Unggah Ulang
                                </button>
                            </div>
                        @endif

                        <div id="formUploadSection" class="{{ ($statusBayar === 'Terverifikasi' || $statusBayar === 'Lunas') ? 'd-none' : '' }}">
                            <form action="{{ route('pembayaran.upload') }}" method="POST" enctype="multipart/form-data" id="paymentUploadForm">
                                @csrf

                                {{-- Drag & Drop / File Input Bukti --}}
                                <div class="mb-3">
                                    <label class="form-label">
                                        File Bukti Transfer / Pembayaran <span class="text-danger">*</span>
                                    </label>
                                    <div class="upload-zone" id="dropZone" onclick="document.getElementById('bukti_pembayaran').click();">
                                        <i class="bi bi-cloud-arrow-up display-5 text-primary mb-2 d-block"></i>
                                        <div class="fw-semibold text-dark mb-1" id="fileNameDisplay">
                                            Klik untuk pilih file atau seret ke sini
                                        </div>
                                        <small class="text-muted d-block">Mendukung format JPG, PNG, atau PDF (Maks. 5 MB)</small>
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="d-none" accept=".jpg,.jpeg,.png,.pdf" required onchange="handleFileSelected(this)">
                                    </div>
                                    {{-- Image Preview Container --}}
                                    <div id="imagePreviewContainer" class="d-none mt-2 text-center p-2 bg-light rounded border">
                                        <img id="imagePreview" src="" alt="Pratinjau" class="img-fluid rounded" style="max-height: 180px;">
                                        <div class="small text-muted mt-1">Pratinjau Bukti Baru</div>
                                    </div>
                                </div>

                                {{-- Input Nominal & Metode --}}
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="jumlah_pembayaran" class="form-label">Nominal Transfer (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" name="jumlah_pembayaran" id="jumlah_pembayaran" class="form-control"
                                               value="{{ old('jumlah_pembayaran', $student->jumlah_pembayaran ?? $schoolSetting->biaya_pendaftaran ?? 1550000) }}"
                                               placeholder="Contoh: 1550000" min="0" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bank_tujuan_pembayaran" class="form-label">Metode Pembayaran</label>
                                        <select name="bank_tujuan_pembayaran" id="bank_tujuan_pembayaran" class="form-select">
                                            <option value="Transfer Bank BSI" {{ old('bank_tujuan_pembayaran', $student->bank_tujuan_pembayaran) === 'Transfer Bank BSI' ? 'selected' : '' }}>
                                                Transfer Bank BSI
                                            </option>
                                            <option value="Tunai di Loket TU" {{ old('bank_tujuan_pembayaran', $student->bank_tujuan_pembayaran) === 'Tunai di Loket TU' ? 'selected' : '' }}>
                                                Tunai di Loket TU
                                            </option>
                                            <option value="Transfer Bank Lain" {{ old('bank_tujuan_pembayaran', $student->bank_tujuan_pembayaran) === 'Transfer Bank Lain' ? 'selected' : '' }}>
                                                Transfer Antar Bank
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Nama Pengirim & Tanggal Bayar --}}
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="nama_pengirim_pembayaran" class="form-label">Nama Pengirim / Pemilik Rekening</label>
                                        <input type="text" name="nama_pengirim_pembayaran" id="nama_pengirim_pembayaran" class="form-control"
                                               value="{{ old('nama_pengirim_pembayaran', $student->nama_pengirim_pembayaran ?? $student->nama_ayah ?? $student->nama_lengkap) }}"
                                               placeholder="Contoh: Budi Santoso (Ayah)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tanggal_pembayaran" class="form-label">Tanggal Transfer</label>
                                        <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control"
                                               value="{{ old('tanggal_pembayaran', $student->tanggal_pembayaran ? $student->tanggal_pembayaran->format('Y-m-d') : date('Y-m-d')) }}">
                                    </div>
                                </div>

                                {{-- Catatan Tambahan --}}
                                <div class="mb-4">
                                    <label for="catatan_pembayaran" class="form-label">Catatan Tambahan (Opsional)</label>
                                    <textarea name="catatan_pembayaran" id="catatan_pembayaran" rows="2" class="form-control"
                                              placeholder="Contoh: Transfer melalui ATM BSI / kuitansi lunas dari TU">{{ old('catatan_pembayaran', $student->catatan_pembayaran) }}</textarea>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-3 rounded-pill fw-bold shadow-sm" id="btnSubmitPayment">
                                        <i class="bi bi-upload me-1"></i> Kirim Bukti Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyRekening(rek, btn) {
        navigator.clipboard.writeText(rek).then(function() {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check2"></i> Tersalin!';
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-success');
            setTimeout(function() {
                btn.innerHTML = originalText;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-primary');
            }, 2000);
        });
    }

    function handleFileSelected(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            fileNameDisplay.innerHTML = '<i class="bi bi-file-earmark-check-fill text-success me-1"></i> ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');

            if (file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('d-none');
            }
        }
    }

    // Drag and drop support
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('bukti_pembayaran');

    if (dropZone && fileInput) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('dragover');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelected(fileInput);
            }
        }, false);
    }
</script>
@endsection
