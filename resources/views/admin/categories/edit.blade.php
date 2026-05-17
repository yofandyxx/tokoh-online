@extends('admin.layout.app')
@section('title', 'Edit Kategori')
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

        .form-control {
            border-radius: 4px;
        }

        .btn-orange {
            background-color: #ff6f00;
            color: #fff;
            border: none;
        }

        .btn-orange:hover {
            background-color: #e65c00;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Edit Kategori</h3>
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
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route(
        'admin.categories.update',
        $category->id
    ) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $category->name) }}" required>
                    </div>
                    <button class="btn btn-orange">
                        <i class="bi bi-save"></i> Update
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection