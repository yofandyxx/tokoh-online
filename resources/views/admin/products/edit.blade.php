@extends('admin.layout.app')
@section('title', 'Edit Produk')
@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
            /* Warna dashboard terang */
            color: #212529;
        }

        .card {
            background-color: #ffffff;
            border: none;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-orange {
            background-color: #ff6f00;
            color: #fff;
            border: none;
        }

        .btn-orange:hover {
            background-color: #e65c00;
        }

        .form-control-search {
            width: 250px;
        }

        img.preview-image {
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h3>Edit Produk</h3>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card shadow-sm p-3">
            <form method="POST" action="{{ route('admin.products.update', $product->id)
    }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ $product->category_id == $c->id
                            ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" value="{{
        old('name', $product->name) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4">{{
        old('description', $product->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control" value="{{
        old('price', $product->price) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control" value="{{
        old('stock', $product->stock) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Produk</label><br>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" width="80" class="preview-image mb-2">
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>
                <button class="btn btn-orange">
                    <i class="bi bi-pencil-square"></i> Update
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary
    ms-2">Batal</a>
            </form>
        </div>
    </div>
@endsection