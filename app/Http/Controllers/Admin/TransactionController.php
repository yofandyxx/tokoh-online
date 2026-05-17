<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
class TransactionController extends Controller
{
    // List semua transaksi 
    public function index()
    {
        $transactions = Transaction::latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }
    // Detail transaksi 
    public function show(Transaction $transaction)
    {
        $transaction->load('items.product', 'user');
        return view('admin.transactions.show', compact('transaction'));
    }
}