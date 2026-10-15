<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Show registration page
     */
    public function index()
    {
        $schoolSetting = SchoolSetting::get();

        if (!$schoolSetting->isPendaftaranBuka()) {
            return view('registration.closed', compact('schoolSetting'));
        }

        return view('registration.form', compact('schoolSetting'));
    }

    /**
     * Store registration data
     */
    public function store(Request $request)
    {
        $schoolSetting = SchoolSetting::get();

        if (!$schoolSetting->isPendaftaranBuka()) {
            return redirect()->route('registration.index')
                ->with('error', 'Pendaftaran saat ini sedang ditutup.');
        }

        // Validasi input
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
            'email' => 'nullable|email|max:255',
            
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

            // Merge file paths dengan validated data
            $validated = array_merge($validated, $filePaths);
            
            // Set additional data
            $validated['tahun_ajaran'] = $schoolSetting->tahun_ajaran_aktif ?? '2026/2027';
            $validated['kelas_pendaftaran'] = '1';
            $validated['tanggal_daftar'] = now()->toDateString();
            $validated['biaya_pendaftaran'] = $schoolSetting->biaya_pendaftaran;
            $validated['status_pendaftaran'] = 'Pending';

            // Create student record
            $student = Student::create($validated);

            // Generate nomor peserta didik
            $student->nomor_peserta_didik = Student::generateNomorPesertaDidik();
            $student->save();

            return redirect()->route('registration.confirmation', $student->id)
                ->with('success', 'Pendaftaran berhasil! Silahkan tunggu konfirmasi dari sekolah.');

        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pendaftaran.')
                ->withInput();
        }
    }

    /**
     * Show confirmation page
     */
    public function confirmation($id)
    {
        $student = Student::findOrFail($id);
        $schoolSetting = SchoolSetting::get();

        return view('registration.confirmation', compact('student', 'schoolSetting'));
    }

    /**
     * Download confirmation letter (admin only)
     */
    public function downloadLetter($id)
    {
        $student = Student::findOrFail($id);
        
        // Generate PDF (memerlukan barryvdh/laravel-dompdf)
        return view('registration.letter', compact('student'));
    }
}
