@extends('layouts.app')
@section('title', 'Beranda')
@section('styles')
    <style>
        /* Hero Image */
        .hero {
            position: relative;
            background: url('https://images.unsplash.com/photo-1542831371d531d36971e6?w=1600') center/cover no-repeat;
            border-radius: 15px;
            height: 380px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2.5rem;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            /* Overlay gelap */
        }

        .hero-content {
            position: relative;
            color: #fff;
            text-align: center;
            padding: 1rem 2rem;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-content p {
            font-size: 1.25rem;
            opacity: 0.95;
            margin-bottom: 1rem;
        }

        /* Card hover */
        .product-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        /* Stock badge */
        .stock-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 0.75rem;
        }

        /* Category badges */
        .category-badge {
            margin: 0.25rem 0.35rem 0.25rem 0;
            padding: 0.55rem 0.9rem;
            font-size: 0.85rem;
            border-radius: 20px;
        }

        /* Ribbon (Diskon/Baru) */
        .ribbon {
            width: 75px;
            height: 75px;
            overflow: hidden;
            position: absolute;
            top: -5px;
            right: -5px;
        }

        .ribbon span {
            position: absolute;
            display: block;
            width: 100px;
            padding: 5px 0;
            background-color: #dc3545;
            color: #fff;
            text-align: center;
            font-size: 0.75rem;
            font-weight: bold;
            transform: rotate(45deg);
            top: 19px;
            right: -21px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-weight: 600;
            font-size: 1.05rem;
        }

        .card-price {
            font-weight: 700;
            color: #198754;
        }
    </style>
@endsection
@section('content')
    <div class="container py-4">
        {{-- Hero Section --}}
        <div class="hero">
            <div class="hero-content">
                <h1>Selamat Datang di TokoOnline</h1>
                <p>Belanja mudah, cepat, dan harga terbaik setiap hari.</p>
                <a href="#products" class="btn btn-light btn-lg mt-2 shadow-sm">
                    Lihat Produk
                </a>
            </div>
        </div>
        {{-- Kategori Section --}}
        @if($categories ?? false)
            <div class="mb-4">
                <h4 class="mb-2">Kategori Produk</h4>
                @foreach($categories as $category)
                    <a href="{{ route('home', ['category' => $category->id]) }}" class="badge bg-primary category-badge">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif
        {{-- Produk Grid --}}
        <div id="products" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100 product-card position-relative">
                            {{-- Ribbon --}}
                            @if($product->is_new)
                                <div class="ribbon"><span>Baru</span></div>
                            @elseif($product->is_discount)
                                <div class="ribbon"><span>Diskon</span></div>
                            @endif
                            {{-- Product Image --}}
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top">
                            @endif
                            {{-- Stock Badge --}}
                            @if($product->stock <= 5)
                                <span class="badge bg-danger stock-badge">Stok Menipis!</span>
                            @elseif($product->stock <= 20)
                                    <span class="badge bg-warning text-dark stock-badge">Stok: {{
                                $product->stock }}</span>
                            @endif
                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-price">Rp {{ number_format(
                    $product->price,
                    0,
                    ',',
                    '.'
                ) }}</p>
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary mt-auto">
                                    <i class="bi bi-eye"></i> Lihat Produk
                                </a>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
        {{-- Pagination --}}
        <div class="mt-5">
            {{ $products->links() }}
        </div>
    </div>
@endsection