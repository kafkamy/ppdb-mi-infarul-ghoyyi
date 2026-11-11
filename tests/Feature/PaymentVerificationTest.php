<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\SchoolSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_student_can_view_payment_page(): void
    {
        $student = Student::create([
            'email' => 'siswa_test@example.com',
            'nama_lengkap' => 'Ahmad Fulan',
            'password' => bcrypt('password123'),
            'status_pendaftaran' => 'Pending',
            'tanggal_daftar' => now(),
        ]);

        $response = $this->actingAs($student, 'student')->get(route('pembayaran'));
        $response->assertStatus(200);
        $response->assertSee('Informasi &amp; Upload Bukti Pembayaran', false);
        $response->assertSee('Ahmad Fulan');
    }

    public function test_student_can_upload_payment_proof(): void
    {
        $student = Student::create([
            'email' => 'siswa_test2@example.com',
            'nama_lengkap' => 'Siti Nurhaliza',
            'password' => bcrypt('password123'),
            'status_pendaftaran' => 'Pending',
            'tanggal_daftar' => now(),
        ]);

        $file = UploadedFile::fake()->create('struk_transfer.pdf', 500, 'application/pdf');

        $response = $this->actingAs($student, 'student')->post(route('pembayaran.upload'), [
            'bukti_pembayaran' => $file,
            'nama_pengirim_pembayaran' => 'Bapak Nurhaliza',
            'bank_tujuan_pembayaran' => 'Transfer Bank BSI',
            'jumlah_pembayaran' => 1550000,
            'tanggal_pembayaran' => '2026-10-19',
            'catatan_pembayaran' => 'Pembayaran lunas seragam dan formulir',
        ]);

        $response->assertRedirect(route('pembayaran'));
        $response->assertSessionHas('success');

        $student->refresh();
        $this->assertNotNull($student->bukti_pembayaran);
        $this->assertEquals('Menunggu Verifikasi', $student->status_pembayaran);
        $this->assertEquals('Bapak Nurhaliza', $student->nama_pengirim_pembayaran);
        $this->assertEquals(1550000, $student->jumlah_pembayaran);
        Storage::disk('public')->assertExists($student->bukti_pembayaran);
    }

    public function test_admin_can_verify_and_approve_payment(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $student = Student::create([
            'email' => 'siswa_test3@example.com',
            'nama_lengkap' => 'Muhammad Yusuf',
            'password' => bcrypt('password123'),
            'status_pendaftaran' => 'Diterima',
            'status_pembayaran' => 'Menunggu Verifikasi',
            'bukti_pembayaran' => 'payments/test_bukti.jpg',
            'jumlah_pembayaran' => 1550000,
            'tanggal_daftar' => now(),
        ]);

        // Admin views student detail
        $showResponse = $this->actingAs($admin)->get(route('admin.students.show', $student->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Bukti &amp; Verifikasi Pembayaran', false);
        $showResponse->assertSee('Setujui &amp; Verifikasi (Lunas)', false);

        // Admin verifies payment
        $verifyResponse = $this->actingAs($admin)->post(route('admin.students.verify-payment', $student->id), [
            'status_pembayaran' => 'Terverifikasi',
        ]);

        $verifyResponse->assertRedirect(route('admin.students.show', $student->id));
        $verifyResponse->assertSessionHas('success');

        $student->refresh();
        $this->assertEquals('Terverifikasi', $student->status_pembayaran);
        $this->assertNotNull($student->tanggal_verifikasi_pembayaran);
    }

    public function test_admin_can_reject_payment_with_reason(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $student = Student::create([
            'email' => 'siswa_test4@example.com',
            'nama_lengkap' => 'Khadijah',
            'password' => bcrypt('password123'),
            'status_pendaftaran' => 'Diterima',
            'status_pembayaran' => 'Menunggu Verifikasi',
            'bukti_pembayaran' => 'payments/test_bukti2.jpg',
            'tanggal_daftar' => now(),
        ]);

        // Admin rejects payment
        $rejectResponse = $this->actingAs($admin)->post(route('admin.students.verify-payment', $student->id), [
            'status_pembayaran' => 'Ditolak',
            'catatan_verifikasi_pembayaran' => 'Foto bukti buram dan nominal tidak terbaca.',
        ]);

        $rejectResponse->assertRedirect(route('admin.students.show', $student->id));
        $student->refresh();
        $this->assertEquals('Ditolak', $student->status_pembayaran);
        $this->assertEquals('Foto bukti buram dan nominal tidak terbaca.', $student->catatan_verifikasi_pembayaran);
    }

    public function test_admin_can_filter_students_by_payment_status(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin_test@example.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );

        $response = $this->actingAs($admin)->get(route('admin.students.index', ['status_pembayaran' => 'Menunggu Verifikasi']));
        $response->assertStatus(200);
        $response->assertSee('Status Pembayaran');
    }
}
