@extends('admin.layout.app')
@section('title', 'Daftar Transaksi')
@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Daftar Transaksi</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $transactions->firstItem() + $index }}</td>
                                    <td>{{ $transaction->invoice }}</td>
                                    <td>{{ $transaction->user->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($transaction->total, 0, ',', '.')
                    }}</td>
                                    <td>{{ ucfirst($transaction->status) }}</td>
                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection