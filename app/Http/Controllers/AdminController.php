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
        $pembayaranPending = Student::byStatusPembayaran('Menunggu Verifikasi')->count();
        $pembayaranTerverifikasi = Student::whereIn('status_pembayaran', ['Terverifikasi', 'Lunas'])->count();

        return view('admin.dashboard', compact(
            'schoolSetting',
            'totalPendaftar',
            'pendaftarPending',
            'pendaftarDiterima',
            'pendaftarDitolak',
            'pembayaranPending',
            'pembayaranTerverifikasi'
        ));
    }

    /**
     * Halaman khusus Verifikasi Data Calon Siswa
     */
    public function verifikasiDataIndex(Request $request)
    {
        $query = Student::query();

        // Default tampilkan yang Pending (Menunggu Verifikasi Data) jika status tidak ditentukan
        $status = $request->get('status', 'Pending');
        if ($status !== 'all' && in_array($status, ['Pending', 'Diterima', 'Ditolak'])) {
            $query->where('status_pendaftaran', $status);
        }

        // Filter tahun ajaran
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%")
                  ->orWhere('nisn', 'like', "%$search%")
                  ->orWhere('nis', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('nomor_peserta_didik', 'like', "%$search%");
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);
        $schoolSetting = SchoolSetting::get();

        $countPending = Student::byStatus('Pending')->count();
        $countDiterima = Student::byStatus('Diterima')->count();
        $countDitolak = Student::byStatus('Ditolak')->count();
        $countTotal = Student::count();

        return view('admin.students.verifikasi-data', compact(
            'students',
            'schoolSetting',
            'status',
            'countPending',
            'countDiterima',
            'countDitolak',
            'countTotal'
        ));
    }

    /**
     * Halaman khusus Verifikasi Bukti Pembayaran
     */
    public function verifikasiPembayaranIndex(Request $request)
    {
        $query = Student::query();

        // Default tampilkan yang Menunggu Verifikasi jika filter tidak diisi
        $statusPembayaran = $request->get('status_pembayaran', 'Menunggu Verifikasi');
        if ($statusPembayaran !== 'all' && in_array($statusPembayaran, ['Menunggu Verifikasi', 'Terverifikasi', 'Belum Bayar', 'Ditolak'])) {
            $query->where('status_pembayaran', $statusPembayaran);
        }

        // Filter tahun ajaran
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%")
                  ->orWhere('nisn', 'like', "%$search%")
                  ->orWhere('nis', 'like', "%$search%")
                  ->orWhere('nama_pengirim_pembayaran', 'like', "%$search%")
                  ->orWhere('nomor_peserta_didik', 'like', "%$search%");
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);
        $schoolSetting = SchoolSetting::get();

        $countMenunggu = Student::byStatusPembayaran('Menunggu Verifikasi')->count();
        $countLunas = Student::whereIn('status_pembayaran', ['Terverifikasi', 'Lunas'])->count();
        $countBelum = Student::byStatusPembayaran('Belum Bayar')->count();
        $countDitolak = Student::byStatusPembayaran('Ditolak')->count();

        return view('admin.students.verifikasi-pembayaran', compact(
            'students',
            'schoolSetting',
            'statusPembayaran',
            'countMenunggu',
            'countLunas',
            'countBelum',
            'countDitolak'
        ));
    }

    /**
     * List all students
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Filter berdasarkan status pendaftaran
        if ($request->filled('status')) {
            $query->where('status_pendaftaran', $request->status);
        }

        // Filter berdasarkan status pembayaran
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
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
                  ->orWhere('nis', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('nama_pengirim_pembayaran', 'like', "%$search%")
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
            'catatan_verifikasi_pendaftaran' => 'nullable|string|max:1000',
            'status_pembayaran' => 'nullable|in:Belum Bayar,Menunggu Verifikasi,Terverifikasi,Ditolak',
            'nis' => 'nullable|string|max:50|unique:students,nis,' . $student->id,
            'jumlah_pembayaran' => 'nullable|numeric|min:0',
            'catatan_verifikasi_pembayaran' => 'nullable|string|max:1000',
            'dokumen_lengkap' => 'boolean',
            'email_verified' => 'boolean',
        ]);

        $validated['dokumen_lengkap'] = $request->has('dokumen_lengkap');
        $validated['email_verified'] = $request->has('email_verified');

        // Tanggal verifikasi pendaftaran
        if (in_array($validated['status_pendaftaran'], ['Diterima', 'Ditolak'])) {
            $validated['tanggal_verifikasi_pendaftaran'] = $student->tanggal_verifikasi_pendaftaran ?? now();
        } elseif ($validated['status_pendaftaran'] === 'Pending') {
            $validated['tanggal_verifikasi_pendaftaran'] = null;
        }

        // Tanggal verifikasi pembayaran
        if (isset($validated['status_pembayaran']) && in_array($validated['status_pembayaran'], ['Terverifikasi', 'Ditolak'])) {
            $validated['tanggal_verifikasi_pembayaran'] = $student->tanggal_verifikasi_pembayaran ?? now();
        } elseif (isset($validated['status_pembayaran']) && $validated['status_pembayaran'] === 'Menunggu Verifikasi') {
            $validated['tanggal_verifikasi_pembayaran'] = null;
        }

        // Otomatis buat NIS jika pembayaran terverifikasi dan belum ada NIS
        if (isset($validated['status_pembayaran']) && $validated['status_pembayaran'] === 'Terverifikasi') {
            if (empty($validated['nis']) && empty($student->nis)) {
                $validated['nis'] = Student::generateNis($student->tahun_ajaran);
            }
        }

        $student->update($validated);

        return redirect()->route('admin.students.show', $student->id)
            ->with('success', 'Data peserta didik berhasil diperbarui');
    }

    /**
     * Verifikasi data & kelengkapan berkas calon peserta didik
     * Terpisah dari verifikasi pembayaran.
     */
    public function verifyData(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'status_pendaftaran' => 'required|in:Pending,Diterima,Ditolak',
            'catatan_verifikasi_pendaftaran' => 'nullable|string|max:1000',
            'dokumen_lengkap' => 'nullable',
        ]);

        $status = $validated['status_pendaftaran'];
        $isVerifiedOrRejected = in_array($status, ['Diterima', 'Ditolak']);

        $updateData = [
            'status_pendaftaran' => $status,
            'catatan_verifikasi_pendaftaran' => $validated['catatan_verifikasi_pendaftaran'] ?? null,
            'tanggal_verifikasi_pendaftaran' => $isVerifiedOrRejected ? now() : null,
            'dokumen_lengkap' => $request->has('dokumen_lengkap') ? true : ($status === 'Diterima' ? true : $student->dokumen_lengkap),
        ];

        // TIDAK mengubah status_pembayaran (proses terpisah)
        $student->update($updateData);

        $msg = $status === 'Diterima'
            ? 'Data calon peserta didik berhasil diverifikasi dan disetujui (Status: Diterima).'
            : ($status === 'Ditolak' ? 'Data calon peserta didik telah ditolak.' : 'Status pendaftaran berhasil direset ke Menunggu Verifikasi.');

        return redirect()->route('admin.students.show', $student->id)->with('success', $msg);
    }

    /**
     * Verifikasi bukti pembayaran calon peserta didik
     * Terpisah dari verifikasi data pendaftaran.
     * Otomatis generate NIS ketika status diubah ke Terverifikasi.
     */
    public function verifyPayment(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'status_pembayaran' => 'required|in:Terverifikasi,Ditolak,Menunggu Verifikasi,Belum Bayar',
            'catatan_verifikasi_pembayaran' => 'nullable|string|max:1000',
        ]);

        $status = $validated['status_pembayaran'];
        $isVerifiedOrRejected = in_array($status, ['Terverifikasi', 'Ditolak']);

        $updateData = [
            'status_pembayaran' => $status,
            'catatan_verifikasi_pembayaran' => $validated['catatan_verifikasi_pembayaran'] ?? null,
            'tanggal_verifikasi_pembayaran' => $isVerifiedOrRejected ? now() : null,
        ];

        // Otomatis generate NIS untuk setiap calon siswa yang bukti pembayarannya sudah diverifikasi/disetujui
        if ($status === 'Terverifikasi') {
            if (empty($student->nis)) {
                $updateData['nis'] = Student::generateNis($student->tahun_ajaran);
            }
        }

        // PISAHKAN: Tidak mengubah status_pendaftaran secara otomatis
        $student->update($updateData);

        $nisInfo = !empty($updateData['nis'])
            ? ' NIS resmi (' . $updateData['nis'] . ') berhasil diterbitkan otomatis.'
            : ($student->nis ? ' (NIS: ' . $student->nis . ')' : '');

        $msg = $status === 'Terverifikasi'
            ? 'Bukti pembayaran berhasil diverifikasi dan disetujui (Lunas)!' . $nisInfo
            : ($status === 'Ditolak' ? 'Bukti pembayaran telah ditolak.' : 'Status pembayaran berhasil diperbarui.');

        return redirect()->route('admin.students.show', $student->id)->with('success', $msg);
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

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        $students = $query->orderBy('created_at', 'desc')->get();

        $filename = 'pendaftar_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'Nomor Peserta', 'NIS', 'Nama', 'L/P', 'Tempat, Tgl Lahir', 'Agama',
            'Alamat', 'Ayah', 'Ibu', 'Asal Sekolah', 'Status Pendaftaran',
            'Status Pembayaran', 'Nominal Pembayaran', 'Nama Pengirim', 'Tanggal Bayar', 'Tanggal Daftar'
        ];

        $callback = function () use ($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->nomor_peserta_didik,
                    $student->nis ?? '-',
                    $student->nama_lengkap,
                    $student->jenis_kelamin,
                    $student->tempat_lahir . ($student->tanggal_lahir ? ', ' . $student->tanggal_lahir->format('d-m-Y') : ''),
                    $student->agama,
                    $student->alamat,
                    $student->nama_ayah,
                    $student->nama_ibu,
                    $student->asal_sekolah,
                    $student->status_pendaftaran,
                    $student->status_pembayaran ?? 'Belum Bayar',
                    $student->jumlah_pembayaran ? 'Rp ' . number_format($student->jumlah_pembayaran, 0, ',', '.') : '-',
                    $student->nama_pengirim_pembayaran ?? '-',
                    $student->tanggal_pembayaran ? $student->tanggal_pembayaran->format('d-m-Y H:i') : '-',
                    $student->tanggal_daftar ? $student->tanggal_daftar->format('d-m-Y') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
