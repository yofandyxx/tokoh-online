@extends('admin.layout.app')
@section('title', 'Daftar Produk')
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
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h3>Daftar Produk</h3>
        <div class="d-flex gap-2 flex-wrap">
            <!-- Form pencarian -->
            <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-search"
                    placeholder="Cari produk...">
                <button type="submit" class="btn btn-orange ms-2">Cari</button>
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-orange">Tambah
                Produk</a>
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
            <table class="table table-hover mb-0" id="productTable">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th style="width:150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $p)
                                        <tr>
                                            <td>{{ $products->firstItem() + $index }}</td>
                                            <td>{{ $p->name }}</td>
                                            <td>{{ $p->category->name ?? '-' }}</td>
                                            <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                            <td>{{ $p->stock }}</td>
                                            <td>
                                                @if($p->image)
                                                    <img src="{{ asset('storage/' . $p->image) }}" width="60">
                                                @else
                                                @endif
                                            </td>
                                            <td class="d-flex gap-1">
                                                <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus
                        produk ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection