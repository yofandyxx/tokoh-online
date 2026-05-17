@extends('admin.layout.app')
@section('title', 'Tambah Produk')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Tambah Produk</h3>
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
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ?
                        'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" class="form-control" value="{{
        old('name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4">{{
        old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" value="{{
        old('price') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stock" class="form-control" value="{{
        old('stock') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </form>
    </div>
@endsection