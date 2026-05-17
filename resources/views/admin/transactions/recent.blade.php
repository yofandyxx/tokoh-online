@extends('admin.layout.app')
@section('title', 'Transaksi Terbaru')
@section('content')
    <div class="container">
        <h3 class="mb-4">Transaksi Terbaru</h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $transaction->invoice }}</td>
                                                <td>{{ $transaction->user->name }}</td>
                                                <td>
                                                    @if($transaction->status == 'pending')
                                                                        <span class="badge bg-warning text-dark">{{
                                                        $transaction->status }}</span>
                                                    @elseif($transaction->status == 'completed')
                                                        <span class="badge bg-success">{{ $transaction->status }}</span>
                                                    @elseif($transaction->status == 'canceled')
                                                        <span class="badge bg-danger">{{ $transaction->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $transaction->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.transactions.index', [
                                'status'
                                => $transaction->status
                            ]) }}" class="btn btn-sm btn-primary">
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada transaksi
                                    terbaru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection