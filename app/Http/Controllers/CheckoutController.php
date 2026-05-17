<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $total = array_sum(array_column($cart, 'subtotal'));

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'subtotal' => $item['subtotal']
            ]);
            // reduce stock 
            $product = Product::find($item['id']);
            if ($product) {
                $product->decrement('stock', $item['qty']);
            }
        }
        // clear cart 
        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Checkout berhasil.vTransaksi ID: ' . $transaction->id);
    }
}
