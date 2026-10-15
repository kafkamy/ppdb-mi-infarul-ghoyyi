<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StudentAuthController extends Controller
{
    /**
     * Tampilkan form login calon peserta didik.
     */
    public function showLoginForm()
    {
        if (Auth::guard('student')->check()) {
            return redirect()->route('siswa.dashboard');
        }
        return view('siswa.login');
    }

    /**
     * Tangani proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('student')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Buat akun baru langsung dengan email dan password.
     */
    public function register(Request $request)
    {
        $request->validate([
            'reg_email'    => ['required', 'email', 'unique:students,email'],
            'reg_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'reg_email.required'    => 'Email harus diisi.',
            'reg_email.email'       => 'Format email tidak valid.',
            'reg_email.unique'      => 'Email ini sudah terdaftar. Silakan login.',
            'reg_password.required' => 'Password harus diisi.',
            'reg_password.min'      => 'Password minimal 8 karakter.',
            'reg_password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $student = Student::create([
                'email'              => $request->reg_email,
                'password'           => Hash::make($request->reg_password),
                'email_verified'     => false,
                'tanggal_daftar'     => now(),
                'status_pendaftaran' => 'Pending',
            ]);

            Auth::guard('student')->login($student);

            return redirect()->route('siswa.dashboard')
                ->with('success', 'Akun pendaftaran berhasil dibuat. Silakan lengkapi formulir Anda.');
        } catch (\Exception $e) {
            Log::error('Create Student Error: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.')
                ->withInput()
                ->with('_tab', 'register');
        }
    }

    /**
     * Tampilkan dashboard calon peserta didik.
     */
    public function dashboard()
    {
        $student = Auth::guard('student')->user();
        $schoolSetting = SchoolSetting::get();
        $isCompleted = $student->isDataLengkap();

        return view('siswa.dashboard', compact('student', 'schoolSetting', 'isCompleted'));
    }

    /**
     * Tampilkan formulir pendaftaran (lengkapi data).
     */
    public function showFormulir()
    {
        $student = Auth::guard('student')->user();
        $schoolSetting = SchoolSetting::get();

        if (!$schoolSetting->isPendaftaranBuka() && !$student->isDataLengkap()) {
            return redirect()->route('siswa.dashboard')->with('error', 'Pendaftaran saat ini sedang ditutup.');
        }

        return view('siswa.formulir', compact('student', 'schoolSetting'));
    }

    /**
     * Simpan kelengkapan data pendaftaran.
     */
    public function storeFormulir(Request $request)
    {
        $student = Auth::guard('student')->user();
        $schoolSetting = SchoolSetting::get();

        // Validasi input (tanpa email karena email read-only)
        $validated = $request->validate([
            // Data Pribadi
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir' => 'required|string|max:255',
            'agama' => 'required|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'anak_ke' => 'nullable|integer|min:1',
            'jumlah_saudara' => 'nullable|integer|min:0',
            
            // Alamat
            'alamat' => 'required|string',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            
            // Kontak
            'no_telepon' => 'nullable|string|max:20',
            
            // Kesehatan
            'no_asuransi_kesehatan' => 'nullable|string|max:50',
            'riwayat_kesehatan' => 'nullable|string',
            
            // Ayah
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'nullable|string|max:20',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'no_telepon_ayah' => 'nullable|string|max:20',
            'alamat_ayah' => 'nullable|string',
            
            // Ibu
            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'nullable|string|max:20',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'no_telepon_ibu' => 'nullable|string|max:20',
            'alamat_ibu' => 'nullable|string',
            
            // Wali (opsional)
            'nama_wali' => 'nullable|string|max:255',
            'nik_wali' => 'nullable|string|max:20',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'no_telepon_wali' => 'nullable|string|max:20',
            'alamat_wali' => 'nullable|string',
            
            // Sekolah Asal
            'asal_sekolah' => 'nullable|string|max:255',
            'npsn_sekolah_asal' => 'nullable|string|max:20',
            'alamat_sekolah_asal' => 'nullable|string',
            'tingkat_sebelumnya' => 'nullable|in:TK,SD,Homeschool,Lainnya',
            
            // File Upload
            'file_akta_kelahiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_kartu_keluarga' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_foto_3x4' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'tanggal_lahir.before' => 'Tanggal lahir tidak valid',
            'tempat_lahir.required' => 'Tempat lahir harus diisi',
            'agama.required' => 'Agama harus dipilih',
            'alamat.required' => 'Alamat harus diisi',
            'kabupaten_kota.required' => 'Kabupaten/Kota harus diisi',
            'provinsi.required' => 'Provinsi harus diisi',
            'nama_ayah.required' => 'Nama ayah harus diisi',
            'nama_ibu.required' => 'Nama ibu harus diisi',
        ]);

        try {
            // Handle file uploads
            $filePaths = [];
            foreach (['file_akta_kelahiran', 'file_kartu_keluarga', 'file_foto_3x4'] as $fileField) {
                if ($request->hasFile($fileField)) {
                    $file = $request->file($fileField);
                    $fileName = Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePaths[$fileField] = $file->storeAs('documents', $fileName, 'public');
                }
            }

            // Merge file paths
            $validated = array_merge($validated, $filePaths);
            
            // Set additional info jika baru pertama melengkapi
            if (!$student->isDataLengkap()) {
                $validated['tahun_ajaran'] = $schoolSetting->tahun_ajaran_aktif ?? '2026/2027';
                $validated['kelas_pendaftaran'] = '1';
                $validated['tanggal_daftar'] = now()->toDateString();
                $validated['biaya_pendaftaran'] = $schoolSetting->biaya_pendaftaran;
                $validated['status_pendaftaran'] = 'Pending';
            }

            // Update student record
            $student->update($validated);

            // Generate nomor peserta didik jika belum ada
            if (empty($student->nomor_peserta_didik)) {
                $student->nomor_peserta_didik = Student::generateNomorPesertaDidik();
                $student->save();
            }

            return redirect()->route('siswa.dashboard')->with('success', 'Data pendaftaran Anda berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Complete Registration Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses data pendaftaran.')->withInput();
        }
    }

    /**
     * Tangani proses logout siswa.
     */
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar dari akun.');
    }
}
