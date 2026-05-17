<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // CARD STATISTIK 
        $productCount = Product::count();
        $categoryCount = Category::count();
        $sales = Transaction::count();

        // TRANSAKSI TERBARU DENGAN ITEMS DAN PRODUCT 
        $recentTransactions = Transaction::with('items.product')
            ->latest()
            ->limit(5)
            ->get();

        // GENERATE INVOICE SEMENTARA 
        $recentTransactions->map(function ($t) {
            $t->invoice = 'INV-' . str_pad($t->id, 5, '0', STR_PAD_LEFT);
            return $t;
        });

        // =========================== 
        // DATA GRAFIK 7 HARI TERAKHIR 
        // =========================== 
        $chartData = Transaction::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk Chart.js 
        $chartLabels = $chartData->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });
        $chartValues = $chartData->pluck('total');
        // KIRIM KE VIEW 
        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'sales',
            'recentTransactions',
            'chartLabels',
            'chartValues'
        ));
    }
}