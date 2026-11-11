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
        Schema::table('students', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('biaya_pendaftaran');
            $table->string('status_pembayaran')->default('Belum Bayar')->after('bukti_pembayaran');
            $table->datetime('tanggal_pembayaran')->nullable()->after('status_pembayaran');
            $table->string('nama_pengirim_pembayaran')->nullable()->after('tanggal_pembayaran');
            $table->string('bank_tujuan_pembayaran')->nullable()->after('nama_pengirim_pembayaran');
            $table->decimal('jumlah_pembayaran', 12, 2)->nullable()->after('bank_tujuan_pembayaran');
            $table->text('catatan_pembayaran')->nullable()->after('jumlah_pembayaran');
            $table->text('catatan_verifikasi_pembayaran')->nullable()->after('catatan_pembayaran');
            $table->datetime('tanggal_verifikasi_pembayaran')->nullable()->after('catatan_verifikasi_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'bukti_pembayaran',
                'status_pembayaran',
                'tanggal_pembayaran',
                'nama_pengirim_pembayaran',
                'bank_tujuan_pembayaran',
                'jumlah_pembayaran',
                'catatan_pembayaran',
                'catatan_verifikasi_pembayaran',
                'tanggal_verifikasi_pembayaran',
            ]);
        });
    }
};
