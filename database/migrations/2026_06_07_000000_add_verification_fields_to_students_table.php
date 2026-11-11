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
            $table->text('catatan_verifikasi_pendaftaran')->nullable()->after('status_pendaftaran');
            $table->datetime('tanggal_verifikasi_pendaftaran')->nullable()->after('catatan_verifikasi_pendaftaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'catatan_verifikasi_pendaftaran',
                'tanggal_verifikasi_pendaftaran',
            ]);
        });
    }
};

