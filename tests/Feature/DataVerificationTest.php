<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_verifikasi_data_page(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $response = $this->actingAs($admin)->get(route('admin.verifikasi-data'));
        $response->assertStatus(200);
        $response->assertSee('Verifikasi Data Calon Siswa');
    }

    public function test_admin_can_access_verifikasi_pembayaran_page(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $response = $this->actingAs($admin)->get(route('admin.verifikasi-pembayaran'));
        $response->assertStatus(200);
        $response->assertSee('Verifikasi Bukti Pembayaran');
    }

    public function test_admin_can_verify_and_accept_student_data_independently(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $student = Student::create([
            'email' => 'calon_siswa@example.com',
            'nama_lengkap' => 'Budi Santoso',
            'password' => bcrypt('password123'),
            'status_pendaftaran' => 'Pending',
            'status_pembayaran' => 'Belum Bayar',
            'tanggal_daftar' => now(),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.students.verify-data', $student->id), [
            'status_pendaftaran' => 'Diterima',
            'dokumen_lengkap' => 1,
            'catatan_verifikasi_pendaftaran' => 'Biodata dan berkas telah lengkap dan sah.',
        ]);

        $response->assertRedirect(route('admin.students.show', $student->id));
        $response->assertSessionHas('success');

        $student->refresh();
        $this->assertEquals('Diterima', $student->status_pendaftaran);
        $this->assertTrue($student->dokumen_lengkap);
        $this->assertNotNull($student->tanggal_verifikasi_pendaftaran);
        $this->assertEquals('Biodata dan berkas telah lengkap dan sah.', $student->catatan_verifikasi_pendaftaran);
        // Pastikan status pembayaran tetap terpisah (tidak berubah jadi apa pun)
        $this->assertEquals('Belum Bayar', $student->status_pembayaran);
    }

    public function test_admin_can_reject_student_data_with_notes(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $student = Student::create([
            'email' => 'calon_siswa_tolak@example.com',
            'nama_lengkap' => 'Calon Ditolak',
            'password' => bcrypt('password123'),
            'status_pendaftaran' => 'Pending',
            'tanggal_daftar' => now(),
        ]);

        $response = $this->actingAs($admin)->post(route('admin.students.verify-data', $student->id), [
            'status_pendaftaran' => 'Ditolak',
            'catatan_verifikasi_pendaftaran' => 'Akta kelahiran buram dan KK tidak sesuai.',
        ]);

        $response->assertRedirect(route('admin.students.show', $student->id));
        $student->refresh();
        $this->assertEquals('Ditolak', $student->status_pendaftaran);
        $this->assertEquals('Akta kelahiran buram dan KK tidak sesuai.', $student->catatan_verifikasi_pendaftaran);
    }

    public function test_verify_payment_does_not_force_change_status_pendaftaran(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $student = Student::create([
            'email' => 'calon_terpisah@example.com',
            'nama_lengkap' => 'Zahra',
            'password' => bcrypt('password123'),
            'status_pendaftaran' => 'Pending', // Masih pending data
            'status_pembayaran' => 'Menunggu Verifikasi',
            'bukti_pembayaran' => 'payments/test.jpg',
            'tanggal_daftar' => now(),
        ]);

        // Verifikasi pembayaran disetujui
        $response = $this->actingAs($admin)->post(route('admin.students.verify-payment', $student->id), [
            'status_pembayaran' => 'Terverifikasi',
        ]);

        $student->refresh();
        $this->assertEquals('Terverifikasi', $student->status_pembayaran);
        // Status pendaftaran harus TETAP Pending karena verifikasi data terpisah!
        $this->assertEquals('Pending', $student->status_pendaftaran);
    }
}

