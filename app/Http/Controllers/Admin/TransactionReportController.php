<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
class TransactionReportController extends Controller
{
    // Laporan transaksi lengkap 
    public function index(Request $request)
    {
        // Query dasar dengan relasi user & items + produk 
        $query = Transaction::with(['user', 'items.product'])->latest();

        // Filter berdasarkan status transaksi jika ada 
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal jika kedua tanggal diisi 
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = $request->from_date . ' 00:00:00';
            $to = $request->to_date . ' 23:59:59';
            $query->whereBetween('created_at', [$from, $to]);
        }

        // Pagination 
        $transactions = $query->paginate(10)->withQueryString();

        // Kirim data ke view 
        return view('admin.transactions.index', compact('transactions'));
    }

    // Transaksi terbaru (misal 5 transaksi terakhir) 
    public function recent()
    {
        $recentTransactions = Transaction::with(['user', 'items.product'])
            ->latest()
            ->limit(5)
            ->get();

        // Bisa tambahkan invoice sementara jika mau ditampilkan 
        $recentTransactions->map(function ($t) {
            $t->invoice = 'INV-' . str_pad($t->id, 5, '0', STR_PAD_LEFT);
            return $t;
        });

        return view('admin.transactions.recent', compact('recentTransactions'));
    }
}