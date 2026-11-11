<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        // Data Pribadi
        'nis',
        'nisn',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'agama',
        'kewarganegaraan',
        'anak_ke',
        'jumlah_saudara',
        
        // Alamat
        'alamat',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        
        // Kontak
        'no_telepon',
        'email',
        
        // Kesehatan
        'no_asuransi_kesehatan',
        'riwayat_kesehatan',
        
        // Ayah
        'nama_ayah',
        'nik_ayah',
        'pekerjaan_ayah',
        'pendidikan_ayah',
        'no_telepon_ayah',
        'alamat_ayah',
        
        // Ibu
        'nama_ibu',
        'nik_ibu',
        'pekerjaan_ibu',
        'pendidikan_ibu',
        'no_telepon_ibu',
        'alamat_ibu',
        
        // Wali
        'nama_wali',
        'nik_wali',
        'pekerjaan_wali',
        'no_telepon_wali',
        'alamat_wali',
        
        // Sekolah Asal
        'asal_sekolah',
        'npsn_sekolah_asal',
        'alamat_sekolah_asal',
        'tingkat_sebelumnya',
        
        // Pendaftaran
        'tahun_ajaran',
        'kelas_pendaftaran',
        'status_pendaftaran',
        'catatan_verifikasi_pendaftaran',
        'tanggal_verifikasi_pendaftaran',
        'biaya_pendaftaran',
        'tanggal_daftar',
        'nomor_peserta_didik',
        
        // Pembayaran
        'bukti_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran',
        'nama_pengirim_pembayaran',
        'bank_tujuan_pembayaran',
        'jumlah_pembayaran',
        'catatan_pembayaran',
        'catatan_verifikasi_pembayaran',
        'tanggal_verifikasi_pembayaran',

        // File
        'file_akta_kelahiran',
        'file_akte_keterlantaran',
        'file_kartu_keluarga',
        'file_foto_3x4',
        
        // Status
        'email_verified',
        'dokumen_lengkap',
        
        // Auth
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
        'tanggal_verifikasi_pendaftaran' => 'datetime',
        'tanggal_pembayaran' => 'datetime',
        'tanggal_verifikasi_pembayaran' => 'datetime',
        'email_verified' => 'boolean',
        'dokumen_lengkap' => 'boolean',
        'biaya_pendaftaran' => 'decimal:2',
        'jumlah_pembayaran' => 'decimal:2',
        'password' => 'hashed',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Generate nomor peserta didik otomatis
     */
    public static function generateNomorPesertaDidik()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $lastStudent = self::latest('id')->first();
        $sequence = $lastStudent ? intval($lastStudent->id) + 1 : 1;
        return sprintf('%s%s%05d', $tahun, $bulan, $sequence);
    }

    /**
     * Generate Nomor Induk Siswa (NIS) otomatis setelah pembayaran diverifikasi
     * Format: YYYY + 4 digit urutan (contoh: 20260001, 20260002)
     */
    public static function generateNis($tahunAjaran = null)
    {
        $tahun = date('Y');
        if ($tahunAjaran && preg_match('/^(\d{4})/', $tahunAjaran, $matches)) {
            $tahun = $matches[1];
        }

        // Cari siswa terakhir yang sudah memiliki NIS dengan prefix tahun tersebut
        $lastStudent = self::withTrashed()
            ->whereNotNull('nis')
            ->where('nis', 'like', $tahun . '%')
            ->orderBy('nis', 'desc')
            ->first();

        if ($lastStudent && preg_match('/^' . $tahun . '(\d+)$/', $lastStudent->nis, $matches)) {
            $sequence = intval($matches[1]) + 1;
        } else {
            $countThisYear = self::withTrashed()
                ->whereNotNull('nis')
                ->where('nis', 'like', $tahun . '%')
                ->count();
            $sequence = $countThisYear + 1;
        }

        $nis = sprintf('%s%04d', $tahun, $sequence);

        // Pastikan NIS benar-benar unik
        while (self::withTrashed()->where('nis', $nis)->exists()) {
            $sequence++;
            $nis = sprintf('%s%04d', $tahun, $sequence);
        }

        return $nis;
    }

    /**
     * Scope untuk filter berdasarkan tahun ajaran
     */
    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }

    /**
     * Scope untuk filter berdasarkan status pendaftaran
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pendaftaran', $status);
    }

    /**
     * Scope untuk filter berdasarkan status pembayaran
     */
    public function scopeByStatusPembayaran($query, $status)
    {
        return $query->where('status_pembayaran', $status);
    }

    /**
     * Cek apakah pembayaran sudah terverifikasi / lunas
     */
    public function isPembayaranLunas()
    {
        return in_array($this->status_pembayaran, ['Terverifikasi', 'Lunas']);
    }

    /**
     * Cek apakah pembayaran sedang menunggu verifikasi
     */
    public function isPembayaranMenunggu()
    {
        return $this->status_pembayaran === 'Menunggu Verifikasi';
    }

    /**
     * Cek apakah pembayaran ditolak
     */
    public function isPembayaranDitolak()
    {
        return $this->status_pembayaran === 'Ditolak';
    }

    /**
     * Cek apakah data lengkap
     */
    public function isDataLengkap()
    {
        return !empty($this->nama_lengkap) && 
                !empty($this->jenis_kelamin) && 
                !empty($this->tanggal_lahir) &&
                !empty($this->alamat);
    }

    /**
     * Cek apakah pendaftaran sudah diterima
     */
    public function isPendaftaranDiterima()
    {
        return $this->status_pendaftaran === 'Diterima';
    }

    /**
     * Cek apakah pendaftaran menunggu verifikasi data
     */
    public function isPendaftaranMenunggu()
    {
        return $this->status_pendaftaran === 'Pending';
    }

    /**
     * Cek apakah pendaftaran ditolak
     */
    public function isPendaftaranDitolak()
    {
        return $this->status_pendaftaran === 'Ditolak';
    }
}
