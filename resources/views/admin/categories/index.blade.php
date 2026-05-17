@extends('admin.layout.app')
@section('title', 'Kategori')
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

        .table-container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 10px;
            overflow-x: auto;
        }

        .table thead {
            background-color: #ff6f00;
            /* Header oranye */
            color: #fff;
        }

        .table tbody tr td {
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

        .form-control-search {
            width: 250px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <h3>Daftar Kategori</h3>
            <div class="d-flex gap-2 flex-wrap">
                <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control form-control-search" placeholder="Cari kategori...">
                    <button type="submit" class="btn btn-orange ms-2">Cari</button>
                </form>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-orange">Tambah Kategori</a>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card shadow-sm">
            <div class="card-body table-container">
                <table class="table table-hover mb-0" id="categoryTable">
                    <thead>
                        <tr>
                            <th style="width:50px;">No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th style="width:180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $c)
                                                <tr>
                                                    <td>{{ $categories->firstItem() + $index }}</td>
                                                    <td>{{ $c->name }}</td>
                                                    <td>{{ $c->slug }}</td>
                                                    <td class="d-flex gap-1">
                                                        <a href="{{ route('admin.categories.edit', $c->id) }}" class="btn btn-warning btn-sm">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>
                                                        <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST"
                                                            class="d-inline" onsubmit="return confirm('Yakin ingin
                            menghapus kategori ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-end">
                    {{ $categories->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection