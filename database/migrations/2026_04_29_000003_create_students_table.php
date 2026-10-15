<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            
            // Data Pribadi Siswa
            $table->string('nisn')->unique()->nullable();
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('kewarganegaraan')->default('Indonesia');
            $table->string('anak_ke')->nullable();
            $table->string('jumlah_saudara')->nullable();
            
            // Alamat
            $table->text('alamat');
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            
            // Kontak
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            
            // Kesehatan
            $table->string('no_asuransi_kesehatan')->nullable();
            $table->text('riwayat_kesehatan')->nullable();
            
            // Data Orang Tua / Wali
            // Ayah
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('no_telepon_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            
            // Ibu
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('no_telepon_ibu')->nullable();
            $table->text('alamat_ibu')->nullable();
            
            // Wali (jika ada)
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('no_telepon_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            
            // Data Sekolah Asal
            $table->string('asal_sekolah')->nullable();
            $table->string('npsn_sekolah_asal')->nullable();
            $table->string('alamat_sekolah_asal')->nullable();
            $table->enum('tingkat_sebelumnya', ['TK', 'SD', 'Homeschool', 'Lainnya'])->nullable();
            
            // Data Pendaftaran
            $table->string('tahun_ajaran')->default('2026/2027');
            $table->string('kelas_pendaftaran')->default('1');
            $table->enum('status_pendaftaran', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
            $table->decimal('biaya_pendaftaran', 12, 2)->nullable();
            $table->date('tanggal_daftar');
            $table->string('nomor_peserta_didik')->unique()->nullable();
            
            // File Upload
            $table->string('file_akta_kelahiran')->nullable();
            $table->string('file_akte_keterlantaran')->nullable();
            $table->string('file_kartu_keluarga')->nullable();
            $table->string('file_foto_3x4')->nullable();
            
            // Status
            $table->boolean('email_verified')->default(false);
            $table->boolean('dokumen_lengkap')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
