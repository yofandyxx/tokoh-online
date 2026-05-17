@extends('admin.layout.app')
@section('title', 'Detail Transaksi')
@section('content')
    <div class="container-fluid">
        <h3 class="mb-4">Detail Transaksi - Invoice: {{ $transaction->invoice }}</h3>
        <div class="mb-3">
            <strong>User:</strong> {{ $transaction->user->name ?? '-' }} <br>
            <strong>Status:</strong> {{ ucfirst($transaction->status) }} <br>
            <strong>Total:</strong> Rp {{ number_format(
        $transaction->total,
        0,
        ',',
        '.'
    ) }} <br>
            <strong>Tanggal:</strong> {{ $transaction->created_at->format('d M Y H:i')
    }}
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
    </div>
@endsection