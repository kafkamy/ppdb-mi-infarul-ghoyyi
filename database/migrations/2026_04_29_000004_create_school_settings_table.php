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
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('MI Infarul Ghoyyi Kalijambe');
            $table->string('npsn')->nullable();
            $table->text('alamat');
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('tahun_ajaran_aktif')->default('2026/2027');
            $table->integer('kuota_siswa_baru')->nullable();
            $table->date('tanggal_buka_pendaftaran')->nullable();
            $table->date('tanggal_tutup_pendaftaran')->nullable();
            $table->boolean('pendaftaran_dibuka')->default(true);
            $table->decimal('biaya_pendaftaran', 12, 2)->nullable();
            $table->text('informasi_tambahan')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};
