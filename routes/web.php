<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aplikasi PPDB (Pendaftaran Peserta Didik Baru)
| MI Infarul Ghoyyi Kalijambe
|
*/

Route::match(['get', 'post'], '/debug-db', function(\Illuminate\Http\Request $request) {
    if ($request->isMethod('post')) {
        $action = $request->input('action');
        if ($action === 'seed') {
            \App\Models\User::firstOrCreate(
                ['email' => 'admin@ppdb.com'],
                [
                    'name' => 'Administrator',
                    'password' => \Hash::make('password'),
                ]
            );
            return back()->with('success', 'Admin default (admin@ppdb.com / password) berhasil dibuat!');
        }
        
        if ($action === 'create') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);
            \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
            ]);
            return back()->with('success', 'Admin baru berhasil ditambahkan!');
        }
    }

    try {
        \DB::connection()->getPdo();
        $dbName = \DB::connection()->getDatabaseName();
        $users = \App\Models\User::all();
        if ($users->isEmpty()) {
            \App\Models\User::create([
                'name' => 'Administrator',
                'email' => 'admin@ppdb.com',
                'password' => \Hash::make('password'),
            ]);
            $users = \App\Models\User::all();
            session()->flash('success', 'Database terdeteksi kosong. Admin default (admin@ppdb.com / password) berhasil dibuat secara otomatis!');
        }
        $dbStatus = 'Connected';
        $dbClass = 'text-success';
    } catch (\Exception $e) {
        $dbName = 'Unknown';
        $users = collect();
        $dbStatus = 'Error: ' . $e->getMessage();
        $dbClass = 'text-danger';
    }

    // Return HTML page directly for ease of access
    $successMessage = session('success') ? '<div class="alert alert-success alert-dismissible fade show" role="alert">' . session('success') . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>' : '';
    
    $errorMessage = '';
    if (session('errors')) {
        $errorsList = implode('<br>', session('errors')->all());
        $errorMessage = '<div class="alert alert-danger">' . $errorsList . '</div>';
    }

    $usersRows = '';
    if ($users->isEmpty()) {
        $usersRows = '<tr><td colspan="3" class="text-center text-muted">Belum ada admin terdaftar. Silakan buat atau seed admin default.</td></tr>';
    } else {
        foreach ($users as $u) {
            $usersRows .= "<tr><td>{$u->name}</td><td><code>{$u->email}</code></td><td><span class='badge bg-primary'>Admin</span></td></tr>";
        }
    }

    $csrfToken = csrf_token();

    return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Admin Setup & Diagnostics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 24px; }
        .card-header { border-radius: 12px 12px 0 0 !important; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">🔧 PPDB Admin Setup & Diagnostics</h2>
                    <p class="text-muted">Halaman ini digunakan untuk mengaktifkan akun admin pertama kali dan menambah admin cadangan secara instan.</p>
                </div>

                {$successMessage}
                {$errorMessage}

                <!-- Status Koneksi Database -->
                <div class="card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">⚙️ Status Database & Aplikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <strong>Status Koneksi:</strong> <span class="{$dbClass} fw-bold">{$dbStatus}</span>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <strong>Nama Database:</strong> <code>{$dbName}</code>
                            </div>
                            <div class="col-sm-6">
                                <strong>Jumlah Admin Terdaftar:</strong> <span class="badge bg-secondary">{$users->count()}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Admin Terdaftar -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">👥 Daftar Admin Saat Ini</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {$usersRows}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Aksi Setup / Penambahan Admin -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">⚡ Seed Admin Default</h5>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <p class="text-muted">Gunakan tombol di bawah untuk membuat akun admin default secara otomatis di database.</p>
                                <div class="bg-light p-3 rounded mb-3">
                                    <strong>Email:</strong> <code>admin@ppdb.com</code><br>
                                    <strong>Password:</strong> <code>password</code>
                                </div>
                                <form action="" method="POST">
                                    <input type="hidden" name="_token" value="{$csrfToken}">
                                    <input type="hidden" name="action" value="seed">
                                    <button type="submit" class="btn btn-success w-100 py-2">
                                        🚀 Buat Admin Default
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">➕ Tambah Admin Baru</h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="_token" value="{$csrfToken}">
                                    <input type="hidden" name="action" value="create">
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Admin Baru" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: admin2@ppdb.com" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" minlength="6" placeholder="Minimal 6 karakter" required>
                                    </div>
                                    <button type="submit" class="btn btn-info text-white w-100 py-2">
                                        💾 Simpan Admin Baru
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="/login" class="btn btn-outline-primary">← Kembali ke Halaman Login Admin</a>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
HTML;
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::get('/visi-misi', function () {
    return view('visi-misi');
})->name('visi-misi');

Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran')->middleware('auth:student');

// AUTHENTICATION ROUTES (Admin)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// REGISTRATION ROUTES (Old public routes redirected/adjusted)
Route::prefix('pendaftaran')->name('registration.')->group(function () {
    Route::get('/', function() {
        return redirect()->route('siswa.login');
    })->name('index');
    Route::post('/store', [RegistrationController::class, 'store'])->name('store');
    Route::get('/confirmation/{id}', [RegistrationController::class, 'confirmation'])->name('confirmation');
    Route::get('/letter/{id}', [RegistrationController::class, 'downloadLetter'])->name('letter');
});

// STUDENT AUTH & DASHBOARD ROUTES
Route::prefix('siswa')->name('siswa.')->group(function () {
    // Guest only (unauthenticated student)
    Route::middleware('guest:student')->group(function () {
        Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [StudentAuthController::class, 'login']);
        Route::post('/register', [StudentAuthController::class, 'register'])->name('register');
    });

    // Authenticated only (logged-in student)
    Route::middleware('auth:student')->group(function () {
        Route::get('/dashboard', [StudentAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/formulir', [StudentAuthController::class, 'showFormulir'])->name('formulir');
        Route::post('/formulir', [StudentAuthController::class, 'storeFormulir']);
        Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
    });
});

// ADMIN ROUTES (Protected by 'auth' middleware)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Students Management
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
    });

    // Export
    Route::get('/export/csv', [AdminController::class, 'export'])->name('export');

    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
