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
            $table->string('nama_lengkap')->nullable()->change();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->date('tanggal_daftar')->nullable()->change();
            
            $table->string('password')->nullable()->after('email');
            $table->rememberToken()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable(false)->change();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
            $table->date('tanggal_daftar')->nullable(false)->change();
            
            $table->dropColumn(['password', 'remember_token']);
        });
    }
};
