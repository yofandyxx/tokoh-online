<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Online')</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Navbar */
        .navbar-brand {
            font-weight: bold;
            color: #0d6efd !important;
        }

        /* Card hover */
        .card:hover {
            transform: translateY(-5px);
            transition: 0.3s;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
        footer {
            background: #f8f9fa;
            padding: 2rem 0;
            margin-top: 4rem;
        }

        /* Badge cart */
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            font-size: 0.75rem;
        }
    </style>
    @yield('styles')
</head>

<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">TokoOnline</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                {{-- Kategori Dropdown --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @isset($categories)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle {{ Request::is('category/*')
                        ? 'active' : '' }}" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Kategori
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                            @foreach($categories as $category)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{
                                                route('category.show', $category->slug) }}">
                                                                        {{ $category->name }}
                                                                    </a>
                                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                    @endisset
                </ul>
                {{-- Right side --}}
                <div class="d-flex align-items-center">
                    {{-- Search Form --}}
                    <form class="d-flex me-3" action="{{ route('home') }}" method="GET">
                        <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..."
                            aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                    {{-- Cart --}}
                    <a class="btn btn-outline-primary position-relative me-3" href="{{
    route('cart.index') }}">
                        <i class="bi bi-cart3"></i> Cart
                        <span class="badge bg-danger rounded-pill cart-badge">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                    {{-- Login / User Dropdown --}}
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'admin')
                                                    <li><a class="dropdown-item" href="{{
                                    route('admin.dashboard') }}">Dashboard Admin</a></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    {{-- MAIN CONTENT --}}
    <main class="py-4 container">
        @yield('content')
    </main>
    {{-- FOOTER --}}
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} TokoOnline. All rights reserved.</p>
        </div>
    </footer>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>