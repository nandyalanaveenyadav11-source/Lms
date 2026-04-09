<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kadellabs LMS') }}</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            :root {
                --brand-blue: #0f3a69;
                --brand-green: #8bc53f;
                --sidebar-bg: #ffffff;
                --body-bg: #f4f6f9;
                --text-main: #334155;
            }
            body { 
                font-family: 'Outfit', sans-serif; 
                background-color: var(--body-bg);
                color: var(--text-main);
            }
            /* Sidebar Styling */
            .sidebar {
                min-height: 100vh;
                background: var(--sidebar-bg);
                box-shadow: 4px 0 24px rgba(0, 0, 0, 0.04);
                z-index: 100;
                display: flex;
                flex-direction: column;
            }
            .brand-logo-container {
                padding: 2rem 1.5rem 1rem;
                text-align: center;
            }
            .logo-img {
                max-width: 100%;
                height: auto;
                max-height: 65px;
                object-fit: contain;
                transition: transform 0.3s ease;
            }
            .logo-img:hover {
                transform: scale(1.02);
            }
            
            /* Navigation Links */
            .sidebar .nav-link {
                color: #64748b;
                padding: 0.85rem 1.5rem;
                display: flex;
                align-items: center;
                gap: 12px;
                font-weight: 500;
                border-radius: 0 24px 24px 0;
                margin-right: 1.5rem;
                margin-bottom: 0.25rem;
                transition: all 0.2s ease-in-out;
            }
            .sidebar .nav-link i {
                font-size: 1.1rem;
                width: 24px;
                text-align: center;
                transition: color 0.2s;
            }
            .sidebar .nav-link:hover {
                color: var(--brand-blue);
                background: rgba(15, 58, 105, 0.04);
            }
            .sidebar .nav-link.active {
                color: var(--brand-blue);
                background: linear-gradient(90deg, rgba(139,197,63,0.1) 0%, rgba(15,58,105,0.05) 100%);
                font-weight: 600;
                border-left: 4px solid var(--brand-green);
            }
            .sidebar .nav-link.active i {
                color: var(--brand-green);
            }

            /* Main Content Top Bar */
            .top-bar {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(0,0,0,0.05);
                padding: 1rem 2rem;
                position: sticky;
                top: 0;
                z-index: 90;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            /* Main Content container */
            .main-content {
                padding: 2rem;
                max-width: 1400px;
                margin: 0 auto;
            }

            /* Cards */
            .card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
                transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                background: #ffffff;
                overflow: hidden;
            }
            .card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 20px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
            }
            
            /* Buttons */
            .btn-primary {
                background: var(--brand-blue);
                border-color: var(--brand-blue);
                border-radius: 8px;
                padding: 0.5rem 1.25rem;
                font-weight: 500;
                transition: all 0.2s;
            }
            .btn-primary:hover {
                background: #0d3159;
                border-color: #0d3159;
                box-shadow: 0 4px 12px rgba(15, 58, 105, 0.2);
                transform: translateY(-1px);
            }
            .btn-success {
                background: var(--brand-green);
                border-color: var(--brand-green);
                color: white;
            }
            .btn-success:hover {
                background: #7db536;
                border-color: #7db536;
            }

            /* Utilities */
            .badge {
                padding: 0.5em 0.8em;
                border-radius: 6px;
                font-weight: 500;
            }
            .progress {
                border-radius: 10px;
                background-color: #e2e8f0;
            }
            .progress-bar {
                background: linear-gradient(90deg, var(--brand-blue) 0%, var(--brand-green) 100%);
            }
            
            /* Logout Button */
            .logout-btn-container {
                margin-top: auto;
                padding: 1.5rem;
                border-top: 1px solid #f1f5f9;
            }
            .btn-logout {
                background: transparent;
                color: #ef4444;
                border: 1px solid #fee2e2;
                border-radius: 12px;
                font-weight: 500;
            }
            .btn-logout:hover {
                background: #fef2f2;
                color: #dc2626;
                border-color: #fecaca;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid p-0">
            <div class="row g-0">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse fixed-bottom fixed-top">
                    <div class="brand-logo-container mb-2">
                        <!-- User must place the downloaded logo at public/images/logo.png -->
                        <img src="{{ asset('images/logo.png') }}" alt="KadelLabs Logo" class="logo-img" onerror="this.outerHTML='<h3 class=\'fw-bold text-primary mb-0\'>Kadel<span class=\'text-success\'>Labs</span></h3><p class=\'small text-muted\'>serving through technology</p>'">
                        <div class="badge bg-light text-dark mt-3 border w-100 shadow-sm rounded-pill font-monospace small">
                            <i class="fas fa-user-circle text-primary me-1"></i> {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Trainee Panel' }}
                        </div>
                    </div>

                    <div class="pt-3 flex-grow-1 overflow-auto">
                        <ul class="nav flex-column ps-0">
                            @include('layouts.sidebar')
                        </ul>
                    </div>

                    <div class="logout-btn-container">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-logout w-100 py-2 d-flex justify-content-center align-items-center gap-2">
                                <i class="fas fa-sign-out-alt"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </nav>

                <!-- main content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 bg-light min-vh-100">
                    <div class="top-bar shadow-sm">
                        <h4 class="mb-0 fw-bold" style="color: var(--brand-blue);">{{ $header ?? 'Dashboard' }}</h4>
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-muted fw-medium"><i class="far fa-clock me-1"></i> {{ date('M d, Y') }}</span>
                            <div class="bg-white rounded-circle shadow-sm d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; border: 2px solid var(--brand-green);">
                                <span class="fw-bold text-primary">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="main-content">
                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4"><i class="fas fa-check-circle me-2"></i> {{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4"><i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}</div>
                        @endif

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
