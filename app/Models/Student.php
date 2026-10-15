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
        'biaya_pendaftaran',
        'tanggal_daftar',
        'nomor_peserta_didik',
        
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
        'email_verified' => 'boolean',
        'dokumen_lengkap' => 'boolean',
        'biaya_pendaftaran' => 'decimal:2',
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
     * Cek apakah data lengkap
     */
    public function isDataLengkap()
    {
        return !empty($this->nama_lengkap) && 
               !empty($this->jenis_kelamin) && 
               !empty($this->tanggal_lahir) &&
               !empty($this->alamat);
    }
}
