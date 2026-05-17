@extends('admin.layout.app')
@section('title', 'Daftar Bank')
@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
            /* Latar terang */
            color: #212529;
        }

        .card {
            background-color: #ffffff;
            /* Card putih */
            color: #212529;
            border: 1px solid #ddd;
        }

        .table-container {
            background-color: #ffffff;
            /* Tabel putih */
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

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .form-control-light {
            background-color: #ffffff;
            border: 1px solid #ccc;
            color: #212529;
        }

        .pagination .page-link {
            background-color: #ffffff;
            color: #212529;
            border: 1px solid #ddd;
        }

        .pagination .page-link:hover {
            background-color: #ff6f00;
            color: #fff;
        }

        .pagination .active .page-link {
            background-color: #ff6f00;
            color: #fff;
            border-color: #ff6f00;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h3>Daftar Bank</h3>
        <div class="d-flex gap-2 flex-wrap">
            <input type="text" id="searchInput" class="form-control form-control-light" placeholder="Cari bank...">
            <a href="{{ route('admin.banks.create') }}" class="btn btn-orange">Tambah
                Bank</a>
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
            <table class="table table-hover mb-0" id="bankTable">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Bank</th>
                        <th>No. Rekening</th>
                        <th>Atas Nama</th>
                        <th style="width:150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banks as $bank)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bank->name }}</td>
                            <td>{{ $bank->account_number }}</td>
                            <td>{{ $bank->account_name }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('admin.banks.edit', $bank->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus bank ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada bank
                                tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end">
                {{ $banks->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // Search filter
        const searchInput = document.getElementById('searchInput');
        const bankTable =
            document.getElementById('bankTable').getElementsByTagName('tbody')[0];
        searchInput.addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            Array.from(bankTable.rows).forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const number = row.cells[2].textContent.toLowerCase();
                const account = row.cells[3].textContent.toLowerCase();
                row.style.display = (name.includes(filter) || number.includes(filter) ||
                    account.includes(filter)) ? '' : 'none';
            });
        });
    </script>
@endsection