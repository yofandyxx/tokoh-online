@extends('layouts.app')
@section('title', $product->name)
@section('content')
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="">
            @else
                <img src="https://via.placeholder.com/600x400?text=No+Image" class="img-fluid">
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->category->name }}</p>
            <h4>Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
            <p>{{ $product->description }}</p>
            <p>Stok: {{ $product->stock }}</p>
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button class="btn btn-success mb-3">
                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                </button>
            </form>
            <!-- Tombol Aksi -->
            <div class="d-flex gap-2">
                <!-- Tombol Lanjutkan Belanja -->
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Lanjutkan Belanja
                </a>
                <!-- Tombol Checkout / Keranjang -->
                <a href="{{ route('cart.index') }}" class="btn btn-primary">
                    <i class="bi bi-bag-check"></i> Checkout
                </a>
            </div>
        </div>
    </div>
@endsection