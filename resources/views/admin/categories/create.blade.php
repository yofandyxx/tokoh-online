@extends('admin.layout.app')
@section('title', 'Tambah Kategori')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Tambah Kategori</h3>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" name="name" id="name" class="form-control" value="{{
        old('name') }}" required>
            </div>
            <button class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </form>
    </div>
@endsection