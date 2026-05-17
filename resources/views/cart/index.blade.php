@extends('layouts.app')
@section('title', 'Keranjang')
@section('styles')
    <style>
        .cart-card {
            transition: 0.3s;
        }

        .cart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        .cart-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item-name {
            font-weight: 600;
            font-size: 1rem;
        }

        .cart-price,
        .cart-subtotal {
            font-weight: 700;
            color: #198754;
        }
    </style>
@endsection
@section('content')
    <div class="container py-4">
        <h3 class="mb-4">Keranjang Belanja</h3>
        @if(empty($cart))
            <div class="alert alert-info">Keranjang kosong.</div>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3"><i class="bi bi-arrow-left"></i> Lanjutkan Belanja</a>
        @else
                <div class="row g-3">
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                        <div class="col-12">
                            <div class="card cart-card shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <img src="{{ $item['image'] ?
                            asset('storage/' . $item['image']) : 'https://via.placeholder.com/100' }}" class="cart-img me-3"
                                        alt="{{ $item['name'] }}">
                                    <div class="flex-grow-1">
                                        <div class="cart-item-name">{{ $item['name'] }}</div>
                                        <div class="cart-price">Rp {{
                            number_format($item['price'], 0, ',', '.') }}</div>
                                        <div class="cart-subtotal">Subtotal: Rp {{
                            number_format($item['subtotal'], 0, ',', '.') }}</div>
                                    </div>
                                    <div class="d-flex flex-column align-items-end">
                                        <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex mb-2">
                                            @csrf
                                            <input type="number" name="qty" value="{{
                            $item['qty'] }}" min="1" class="form-control me-2" style="width:70px;">
                                            <button class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $total += $item['subtotal']; @endphp
                    @endforeach
                </div>
                {{-- Total & tombol --}}
                <div class="card mt-4 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center
            flex-wrap gap-2">
                        <h4>Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('home') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Lanjutkan
                                Belanja</a>
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">@csrf
                                <button class="btn btn-warning">Kosongkan</button>
                            </form>
                            <a href="{{ route('checkout.index') }}" class="btn btn-success">Checkout</a>
                        </div>
                    </div>
                </div>
        @endif
    </div>
@endsection