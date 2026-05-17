@extends('admin.layout.app')
@section('title', 'Edit Bank')
@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
            /* Latar terang */
            color: #212529;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }

        .form-control-light {
            background-color: #ffffff;
            border: 1px solid #ccc;
            color: #212529;
        }

        .btn-orange {
            background-color: #ff6f00;
            color: #fff;
            border: none;
        }

        .btn-orange:hover {
            background-color: #e65c00;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Edit Bank</h3>
        <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">Kembali</a>
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
    <div class="card shadow-sm">
        <form action="{{ route('admin.banks.update', $bank->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Bank</label>
                <input type="text" name="name" class="form-control form-control-light" value="{{ $bank->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">No. Rekening</label>
                <input type="text" name="account_number" class="form-control form-control-light"
                    value="{{ $bank->account_number }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Atas Nama</label>
                <input type="text" name="account_name" class="form-control form-control-light"
                    value="{{ $bank->account_name }}" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-orange">Update</button>
                <a href="{{ route('admin.banks.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection