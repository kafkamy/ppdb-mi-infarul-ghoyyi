@extends('layouts.app')

@section('title', 'Lengkapi Formulir Pendaftaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-light text-secondary rounded-pill fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                Sesi: {{ $student->email }}
            </span>
        </div>

        <div class="card border-0 shadow-lg">
            <div class="card-header bg-transparent border-0 text-center pt-5 pb-3">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 70px; height: 70px;">
                    <i class="bi bi-person-check-fill fs-2"></i>
                </div>
                <h3 class="mb-1 fw-bold">Lengkapi Formulir Pendaftaran</h3>
                <p class="text-secondary mb-0">{{ $schoolSetting->nama_sekolah ?? 'MI Infarul Ghoyyi Kalijambe' }}</p>
            </div>
            
            <div class="card-body px-4 px-md-5 pb-5">
                <form action="{{ route('siswa.formulir') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Info Pendaftaran -->
                    <div class="alert alert-info d-flex align-items-center mb-5">
                        <i class="bi bi-info-circle-fill fs-4 me-3 text-primary"></i>
                        <div>
                            <strong>Tahun Ajaran:</strong> {{ $schoolSetting->tahun_ajaran_aktif ?? '2026/2027' }}<br>
                            <strong>Biaya Pendaftaran:</strong> Rp {{ number_format($schoolSetting->biaya_pendaftaran ?? 0, 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- BAGIAN 1: DATA PRIBADI SISWA -->
                    <div class="bg-light p-4 rounded-4 mb-4 border border-white">
                        <h5 class="mb-4 d-flex align-items-center text-primary">
                            <span class="badge bg-primary rounded-pill me-2">1</span> Data Pribadi Siswa
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $student->nama_lengkap) }}" required placeholder="Contoh: Ahmad Abdullah">
                                @error('nama_lengkap')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nama_panggilan" class="form-label">Nama Panggilan</label>
                                <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="{{ old('nama_panggilan', $student->nama_panggilan) }}" placeholder="Contoh: Ahmad">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                <select class="form-select @error('agama') is-invalid @enderror" 
                                        id="agama" name="agama" required>
                                    <option value="" selected disabled>-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama', $student->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama', $student->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama', $student->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama', $student->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama', $student->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama', $student->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $student->tempat_lahir) }}" required>
                                @error('tempat_lahir')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $student->tanggal_lahir ? $student->tanggal_lahir->format('Y-m-d') : '') }}" required>
                                @error('tanggal_lahir')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="anak_ke" class="form-label">Anak Ke-</label>
                                <input type="number" class="form-control" id="anak_ke" name="anak_ke" value="{{ old('anak_ke', $student->anak_ke) }}" min="1">
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah_saudara" class="form-label">Jumlah Saudara</label>
                                <input type="number" class="form-control" id="jumlah_saudara" name="jumlah_saudara" value="{{ old('jumlah_saudara', $student->jumlah_saudara) }}" min="0">
                            </div>
                            
                            <div class="col-md-12">
                                <label for="nisn" class="form-label">NISN (Nomor Induk Siswa Nasional)</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}" placeholder="Isi jika sudah memiliki NISN">
                                @error('nisn')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 2: ALAMAT -->
                    <div class="bg-light p-4 rounded-4 mb-4 border border-white">
                        <h5 class="mb-4 d-flex align-items-center text-primary">
                            <span class="badge bg-primary rounded-pill me-2">2</span> Alamat Tempat Tinggal
                        </h5>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" name="alamat" rows="3" required placeholder="Nama Jalan, RT/RW, Perumahan, dll">{{ old('alamat', $student->alamat) }}</textarea>
                                @error('alamat')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="desa_kelurahan" class="form-label">Desa / Kelurahan</label>
                                <input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan', $student->desa_kelurahan) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $student->kecamatan) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="kabupaten_kota" class="form-label">Kabupaten / Kota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kabupaten_kota') is-invalid @enderror" 
                                       id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota', $student->kabupaten_kota) }}" required>
                                @error('kabupaten_kota')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('provinsi') is-invalid @enderror" 
                                       id="provinsi" name="provinsi" value="{{ old('provinsi', $student->provinsi) }}" required>
                                @error('provinsi')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-3">
                                <label for="kode_pos" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $student->kode_pos) }}">
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 3 & 4: KONTAK & KESEHATAN -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="bg-light p-4 rounded-4 h-100 border border-white">
                                <h5 class="mb-4 d-flex align-items-center text-primary">
                                    <span class="badge bg-primary rounded-pill me-2">3</span> Kontak
                                </h5>
                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label">Nomor WhatsApp / HP</label>
                                    <input type="tel" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $student->no_telepon) }}" placeholder="Contoh: 08123456789">
                                </div>
                                <div>
                                    <label class="form-label">Email Terdaftar</label>
                                    <input type="email" class="form-control bg-light" value="{{ $student->email }}" disabled>
                                    <div class="form-text small text-muted">Email tidak dapat diubah setelah registrasi.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded-4 h-100 border border-white">
                                <h5 class="mb-4 d-flex align-items-center text-primary">
                                    <span class="badge bg-primary rounded-pill me-2">4</span> Kesehatan
                                </h5>
                                <div class="mb-3">
                                    <label for="no_asuransi_kesehatan" class="form-label">No. Asuransi (BPJS/Lainnya)</label>
                                    <input type="text" class="form-control" id="no_asuransi_kesehatan" name="no_asuransi_kesehatan" value="{{ old('no_asuransi_kesehatan', $student->no_asuransi_kesehatan) }}">
                                </div>
                                <div>
                                    <label for="riwayat_kesehatan" class="form-label">Riwayat Penyakit / Alergi</label>
                                    <textarea class="form-control" id="riwayat_kesehatan" name="riwayat_kesehatan" rows="2">{{ old('riwayat_kesehatan', $student->riwayat_kesehatan) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 5: DATA ORANG TUA -->
                    <div class="bg-light p-4 rounded-4 mb-4 border border-white">
                        <h5 class="mb-4 d-flex align-items-center text-primary">
                            <span class="badge bg-primary rounded-pill me-2">5</span> Data Orang Tua / Wali
                        </h5>

                        <h6 class="text-secondary fw-bold mb-3"><i class="bi bi-person-fill me-2"></i>Ayah Kandung</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="nama_ayah" class="form-label">Nama Ayah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" 
                                       id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $student->nama_ayah) }}" required>
                                @error('nama_ayah')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nik_ayah" class="form-label">NIK Ayah</label>
                                <input type="text" class="form-control" id="nik_ayah" name="nik_ayah" value="{{ old('nik_ayah', $student->nik_ayah) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $student->pekerjaan_ayah) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="no_telepon_ayah" class="form-label">Nomor Telepon Ayah</label>
                                <input type="tel" class="form-control" id="no_telepon_ayah" name="no_telepon_ayah" value="{{ old('no_telepon_ayah', $student->no_telepon_ayah) }}">
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        <h6 class="text-secondary fw-bold mb-3 mt-4"><i class="bi bi-person-fill me-2"></i>Ibu Kandung</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_ibu" class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" 
                                       id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $student->nama_ibu) }}" required>
                                @error('nama_ibu')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nik_ibu" class="form-label">NIK Ibu</label>
                                <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" value="{{ old('nik_ibu', $student->nik_ibu) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $student->pekerjaan_ibu) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="no_telepon_ibu" class="form-label">Nomor Telepon Ibu</label>
                                <input type="tel" class="form-control" id="no_telepon_ibu" name="no_telepon_ibu" value="{{ old('no_telepon_ibu', $student->no_telepon_ibu) }}">
                            </div>
                        </div>
                    </div>

                    <!-- BAGIAN 6 & 7: SEKOLAH & DOKUMEN -->
                    <div class="row mb-5">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="bg-light p-4 rounded-4 h-100 border border-white">
                                <h5 class="mb-4 d-flex align-items-center text-primary">
                                    <span class="badge bg-primary rounded-pill me-2">6</span> Asal Sekolah
                                </h5>
                                <div class="mb-3">
                                    <label for="asal_sekolah" class="form-label">Nama Sekolah Asal</label>
                                    <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah', $student->asal_sekolah) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tingkat_sebelumnya" class="form-label">Tingkat Sebelumnya</label>
                                    <select class="form-select" id="tingkat_sebelumnya" name="tingkat_sebelumnya">
                                        <option value="">-- Pilih --</option>
                                        <option value="TK" {{ old('tingkat_sebelumnya', $student->tingkat_sebelumnya) == 'TK' ? 'selected' : '' }}>TK</option>
                                        <option value="SD" {{ old('tingkat_sebelumnya', $student->tingkat_sebelumnya) == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="Homeschool" {{ old('tingkat_sebelumnya', $student->tingkat_sebelumnya) == 'Homeschool' ? 'selected' : '' }}>Homeschool</option>
                                        <option value="Lainnya" {{ old('tingkat_sebelumnya', $student->tingkat_sebelumnya) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded-4 h-100 border border-white">
                                <h5 class="mb-4 d-flex align-items-center text-primary">
                                    <span class="badge bg-primary rounded-pill me-2">7</span> Dokumen Upload
                                </h5>
                                <div class="mb-3">
                                    <label for="file_akta_kelahiran" class="form-label">Akta Kelahiran (PDF/Img)</label>
                                    @if($student->file_akta_kelahiran)
                                        <div class="mb-2"><span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Sudah diupload</span></div>
                                    @endif
                                    <input type="file" class="form-control form-control-sm" id="file_akta_kelahiran" name="file_akta_kelahiran" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <div class="mb-3">
                                    <label for="file_kartu_keluarga" class="form-label">Kartu Keluarga (PDF/Img)</label>
                                    @if($student->file_kartu_keluarga)
                                        <div class="mb-2"><span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Sudah diupload</span></div>
                                    @endif
                                    <input type="file" class="form-control form-control-sm" id="file_kartu_keluarga" name="file_kartu_keluarga" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <div class="mb-3">
                                    <label for="file_foto_3x4" class="form-label">Pas Foto 3x4 (Img)</label>
                                    @if($student->file_foto_3x4)
                                        <div class="mb-2"><span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Sudah diupload</span></div>
                                    @endif
                                    <input type="file" class="form-control form-control-sm" id="file_foto_3x4" name="file_foto_3x4" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-primary btn-lg py-3 rounded-pill fw-bold shadow-lg">
                            <i class="bi bi-save-fill me-2"></i> Simpan Data Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
