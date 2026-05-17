@extends('admin.layout.app')
@section('title', 'Laporan Transaksi')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h3>Laporan Transaksi</h3>
        </div>
        {{-- FILTER --}}
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ?
        'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' :
        '' }}>Paid</option>
                    <option value="cancel" {{ request('status') == 'cancel' ? 'selected'
        : '' }}>Cancel</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Dari Tanggal</label>
                <input type="date" name="from_date" class="form-control" value="{{
        request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label>Sampai Tanggal</label>
                <input type="date" name="to_date" class="form-control" value="{{
        request('to_date') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        {{-- TABEL TRANSAKSI --}}
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>User</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $transaction)
                                                <tr>
                                                    <td>{{ $transactions->firstItem() + $index }}</td>
                                                    <td>#INV{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT)
                            }}</td>
                                                    <td>{{ $transaction->user->name ?? 'Guest' }}</td>
                                                    <td>
                                                        @foreach($transaction->items as $item)
                                                                                        {{ $item->product->name ?? '-' }} (x{{ $item->qty
                                                            }})<br>
                                                        @endforeach
                                                    </td>
                                                    <td>Rp {{ number_format($transaction->total, 0, ',', '.')
                            }}</td>
                                                    <td>
                                                        @if($transaction->status == 'pending')
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        @elseif($transaction->status == 'paid')
                                                            <span class="badge bg-success">Paid</span>
                                                        @elseif($transaction->status == 'cancel')
                                                            <span class="badge bg-danger">Cancel</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                                </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-end">
                    {{ $transactions->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection