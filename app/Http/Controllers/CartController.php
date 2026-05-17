<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
            $cart[$id]['subtotal'] = $cart[$id]['qty'] * $product->price;
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name,
                "qty" => 1,
                "price" => $product->price,
                "image" => $product->image,
                "subtotal" => $product->price
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke 
keranjang');
    }

    public function update(Request $request, $id)
    {
        $qty = (int) $request->qty;
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            $cart[$id]['subtotal'] = $qty * $cart[$id]['price'];
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Keranjang diperbarui');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Produk dihapus dari keranjang');
    }
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan');
    }
}