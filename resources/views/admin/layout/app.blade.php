<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: #800000;
            color: #fff;
            padding: 1rem;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 0.3rem;
            transition: all 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #b22222;
            color: #fff;
        }

        .sidebar a i {
            margin-right: 0.5rem;
        }

        /* Navbar */
        nav.navbar {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            z-index: 1030;
            background-color: #000;
        }

        /* Main content */
        .main-content {
            margin-left: 220px;
            padding: 5.5rem 2rem 2rem 2rem;
        }

        /* Dropdown notifikasi */
        .notif-badge {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 0.7rem;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                width: 100%;
                position: relative;
            }

            nav.navbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding-top: 6rem;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    {{-- Sidebar --}}
    @include('admin.layout.sidebar')
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 text-white">Dashboard Admin</span>
            <ul class="navbar-nav ms-auto align-items-center">
                {{-- Notifikasi --}}
                <li class="nav-item dropdown me-3">
                    <a class="nav-link position-relative text-white" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="badge bg-danger rounded-pill notif-badge">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown">
                        <li><a class="dropdown-item" href="#">Transaksi baru
                                diterima</a></li>
                        <li><a class="dropdown-item" href="#">Produk habis
                                stok</a></li>
                        <li><a class="dropdown-item" href="#">Update sistem
                                tersedia</a></li>
                    </ul>
                </li>
                {{-- User Login & Logout --}}
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://cdn-icons-png.flaticon.com/512/147/147144.png" alt="Profile"
                                class="rounded-circle me-2" style="width: 35px; height: 35px;">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                @endauth
            </ul>
        </div>
    </nav>
    {{-- Main Content --}}
    <div class="main-content">
        @yield('content')
    </div>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>