<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat',
        'no_telepon',
        'email',
        'website',
        'visi',
        'misi',
        'tahun_ajaran_aktif',
        'kuota_siswa_baru',
        'tanggal_buka_pendaftaran',
        'tanggal_tutup_pendaftaran',
        'pendaftaran_dibuka',
        'biaya_pendaftaran',
        'informasi_tambahan',
        'logo',
    ];

    protected $casts = [
        'tanggal_buka_pendaftaran' => 'date',
        'tanggal_tutup_pendaftaran' => 'date',
        'pendaftaran_dibuka' => 'boolean',
        'biaya_pendaftaran' => 'decimal:2',
    ];

    /**
     * Get single school setting
     */
    public static function get()
    {
        return self::first() ?? self::create([
            'nama_sekolah' => 'MI Infarul Ghoyyi Kalijambe',
            'alamat' => 'Kalijambe',
            'pendaftaran_dibuka' => true,
        ]);
    }

    /**
     * Check if registration is open
     */
    public function isPendaftaranBuka()
    {
        if (!$this->pendaftaran_dibuka) {
            return false;
        }

        $now = now()->toDateString();
        
        if ($this->tanggal_buka_pendaftaran && $now < $this->tanggal_buka_pendaftaran->toDateString()) {
            return false;
        }

        if ($this->tanggal_tutup_pendaftaran && $now > $this->tanggal_tutup_pendaftaran->toDateString()) {
            return false;
        }

        return true;
    }
}
