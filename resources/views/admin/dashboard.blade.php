@extends('admin.layout.app')
@section('title', 'Dashboard Admin')
@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">Dashboard Admin</h1>
        {{-- CARD STATISTIK UTAMA --}}
        <div class="row mb-4">
            {{-- Total Produk --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-left-primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-box-seam fs-1 text-primary me-3"></i>
                        <div>
                            <h6 class="text-uppercase fw-bold">Total Produk</h6>
                            <h3>{{ $productCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Total Kategori --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-left-success h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-tags fs-1 text-success me-3"></i>
                        <div>
                            <h6 class="text-uppercase fw-bold">Total Kategori</h6>
                            <h3>{{ $categoryCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Total Transaksi --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-left-warning h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-receipt fs-1 text-warning me-3"></i>
                        <div>
                            <h6 class="text-uppercase fw-bold">Total Transaksi</h6>
                            <h3>{{ $sales }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Total Pelanggan --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-left-info h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-people fs-1 text-info me-3"></i>
                        <div>
                            <h6 class="text-uppercase fw-bold">Total Pelanggan</h6>
                            <h3>{{ \App\Models\User::where('role', 'customer')->count()
    }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- CHART TRANSAKSI 7 HARI TERAKHIR --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light d-flex align-items-center">
                <i class="bi bi-bar-chart me-2"></i>
                Transaksi 7 Hari Terakhir
            </div>
            <div class="card-body">
                <canvas id="transactionChart" height="100"></canvas>
            </div>
        </div>
        {{-- TABEL TRANSAKSI TERBARU --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light d-flex align-items-center">
                <i class="bi bi-clock-history me-2"></i>
                Transaksi Terbaru
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $index => $transaction)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>#INV-{{ str_pad(
                                    $transaction->id,
                                    6,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}</td>
                                                    <td>
                                                        @foreach($transaction->items as $item)
                                                            <i class="bi bi-box-seam me-1"></i>{{ $item->product->name ?? '-' }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach($transaction->items as $item)
                                                            {{ $item->qty }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>Rp {{ number_format(
                                    $transaction->total,
                                    0,
                                    ',',
                                    '.'
                                ) }}</td>
                                                    <td>
                                                        @if($transaction->status === 'pending')
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        @elseif($transaction->status === 'success')
                                                            <span class="badge bg-success">Success</span>
                                                        @elseif($transaction->status === 'failed')
                                                            <span class="badge bg-danger">Failed</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('d M Y H:i')
                            }}</td>
                                                </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada
                                    transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('transactionChart').getContext('2d');
        const transactionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: {!! json_encode($chartValues) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
@endsection