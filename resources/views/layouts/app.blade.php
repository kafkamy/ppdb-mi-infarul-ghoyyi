<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPDB') - MI Infarul Ghoyyi Kalijambe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #15803d;
            --primary-hover: #166534;
            --secondary: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            background-image: url('{{ asset('images/bg-sekolah.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(241, 245, 249, 0.75);
            z-index: -1;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Glassmorphism Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.4);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            background: linear-gradient(135deg, var(--primary), #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: #475569 !important;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            margin: 0 0.25rem;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background: rgba(21, 128, 61, 0.1);
        }

        /* Glass Cards */
        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .card-header {
            background: rgba(255, 255, 255, 0.5);
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            padding: 1.25rem 1.5rem;
        }

        /* Buttons */
        .btn {
            font-weight: 600;
            border-radius: 0.5rem;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.3px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #22c55e);
            border: none;
            box-shadow: 0 4px 6px -1px rgba(21, 128, 61, 0.3);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), #15803d);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(21, 128, 61, 0.4);
            color: white;
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            border-width: 2px;
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(21, 128, 61, 0.2);
        }

        /* Forms */
        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #cbd5e1;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.9);
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(21, 128, 61, 0.15);
            background: #fff;
        }
        
        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Footer */
        .footer {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255,255,255,0.5);
            padding: 2rem 0;
            margin-top: auto;
        }
        
        /* Badges & Alerts */
        .badge {
            border-radius: 9999px;
            padding: 0.4em 0.8em;
            font-weight: 600;
        }
        
        .alert {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-left: 4px solid var(--primary);
        }
        .alert-success { border-left-color: var(--secondary); }
        .alert-danger { border-left-color: #ef4444; }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-mortarboard-fill text-primary"></i>
                MI Infarul Ghoyyi
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Link Umum (Selalu Tampil) -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">
                            <i class="bi bi-building me-1"></i> Profil Sekolah
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('visi-misi') ? 'active' : '' }}" href="{{ route('visi-misi') }}">
                            <i class="bi bi-book me-1"></i> Visi & Misi
                        </a>
                    </li>

                    @if(Auth::guard('student')->check())
                        <!-- Siswa Terautentikasi -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pembayaran') ? 'active' : '' }}" href="{{ route('pembayaran') }}">
                                <i class="bi bi-credit-card me-1"></i> Pembayaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('siswa.formulir') ? 'active' : '' }}" href="{{ route('siswa.formulir') }}">
                                <i class="bi bi-pencil-square me-1"></i> Pendaftaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <form action="{{ route('siswa.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill px-3 py-2">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </button>
                            </form>
                        </li>
                    @elseif(Auth::guard('web')->check())
                        <!-- Admin Terautentikasi -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-shield-lock me-1"></i> Admin Dashboard
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill px-3 py-2">
                                    <i class="bi bi-box-arrow-right"></i> Logout Admin
                                </button>
                            </form>
                        </li>
                    @else
                        <!-- Guest (Belum Login) -->
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a href="{{ route('siswa.login') }}" class="btn btn-sm btn-primary w-100 rounded-pill px-3 py-2 text-white fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk / Daftar
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary w-100 rounded-pill px-3 py-2">
                                <i class="bi bi-shield-lock"></i> Admin
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="container my-4 animate-fade-in">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                        <strong class="text-danger">Terjadi Kesalahan!</strong>
                    </div>
                    <ul class="mb-0 text-secondary">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                        <strong>{{ session('success') }}</strong>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-x-circle-fill fs-5 me-2 text-danger"></i>
                        <strong>{{ session('error') }}</strong>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center text-muted">
            <p class="mb-1 fw-medium">&copy; {{ date('Y') }} MI Infarul Ghoyyi Kalijambe. Hak Cipta Dilindungi.</p>
            <p class="mb-0 small">Sistem Pendaftaran Peserta Didik Baru (PPDB)</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
