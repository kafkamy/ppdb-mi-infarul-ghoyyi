<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard - tampilkan statistik
     */
    public function dashboard()
    {
        $schoolSetting = SchoolSetting::get();
        $totalPendaftar = Student::count();
        $pendaftarPending = Student::byStatus('Pending')->count();
        $pendaftarDiterima = Student::byStatus('Diterima')->count();
        $pendaftarDitolak = Student::byStatus('Ditolak')->count();

        return view('admin.dashboard', compact(
            'schoolSetting',
            'totalPendaftar',
            'pendaftarPending',
            'pendaftarDiterima',
            'pendaftarDitolak'
        ));
    }

    /**
     * List all students
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_pendaftaran', $request->status);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%")
                  ->orWhere('nisn', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('nomor_peserta_didik', 'like', "%$search%");
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);
        $schoolSetting = SchoolSetting::get();

        return view('admin.students.index', compact('students', 'schoolSetting'));
    }

    /**
     * Show student detail
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        $schoolSetting = SchoolSetting::get();

        return view('admin.students.show', compact('student', 'schoolSetting'));
    }

    /**
     * Edit student
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $schoolSetting = SchoolSetting::get();

        return view('admin.students.edit', compact('student', 'schoolSetting'));
    }

    /**
     * Update student
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'status_pendaftaran' => 'required|in:Pending,Diterima,Ditolak',
            'dokumen_lengkap' => 'boolean',
            'email_verified' => 'boolean',
        ]);

        $validated['dokumen_lengkap'] = $request->has('dokumen_lengkap');
        $validated['email_verified'] = $request->has('email_verified');

        $student->update($validated);

        return redirect()->route('admin.students.show', $student->id)
            ->with('success', 'Data peserta didik berhasil diperbarui');
    }

    /**
     * Delete student
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Data peserta didik berhasil dihapus');
    }

    /**
     * Settings - manage school information
     */
    public function settings()
    {
        $schoolSetting = SchoolSetting::get();
        
        return view('admin.settings', compact('schoolSetting'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'tahun_ajaran_aktif' => 'required|string|max:20',
            'kuota_siswa_baru' => 'nullable|integer|min:1',
            'tanggal_buka_pendaftaran' => 'nullable|date',
            'tanggal_tutup_pendaftaran' => 'nullable|date',
            'pendaftaran_dibuka' => 'boolean',
            'biaya_pendaftaran' => 'nullable|numeric|min:0',
            'informasi_tambahan' => 'nullable|string',
        ]);

        $schoolSetting = SchoolSetting::get();
        $validated['pendaftaran_dibuka'] = $request->has('pendaftaran_dibuka');
        $schoolSetting->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Pengaturan sekolah berhasil diperbarui');
    }

    /**
     * Export students data to CSV
     */
    public function export(Request $request)
    {
        $query = Student::query();

        if ($request->filled('status')) {
            $query->where('status_pendaftaran', $request->status);
        }

        $students = $query->orderBy('created_at', 'desc')->get();

        $filename = 'pendaftar_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'Nomor Peserta', 'Nama', 'L/P', 'Tempat, Tgl Lahir', 'Agama',
            'Alamat', 'Ayah', 'Ibu', 'Asal Sekolah', 'Status', 'Tanggal Daftar'
        ];

        $callback = function () use ($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->nomor_peserta_didik,
                    $student->nama_lengkap,
                    $student->jenis_kelamin,
                    $student->tempat_lahir . ($student->tanggal_lahir ? ', ' . $student->tanggal_lahir->format('d-m-Y') : ''),
                    $student->agama,
                    $student->alamat,
                    $student->nama_ayah,
                    $student->nama_ibu,
                    $student->asal_sekolah,
                    $student->status_pendaftaran,
                    $student->tanggal_daftar ? $student->tanggal_daftar->format('d-m-Y') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
