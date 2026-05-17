<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // =========================== 
    // PUBLIC HOME (LIST PRODUK) 
    // =========================== 
    public function home()
    {
        $products = Product::with('category')->latest()->paginate(12);
        return view('home', compact('products'));
    }

    // =========================== 
    // ADMIN - LIST PRODUK 
    // =========================== 
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        // Tambahkan search/filter 
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        // Pagination dengan query string tetap terjaga 
        $products = $query->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    // =========================== 
    // ADMIN - FORM CREATE 
    // =========================== 
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    // =========================== 
    // ADMIN - STORE PRODUK 
    // =========================== 
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // =========================== 
    // ADMIN - FORM EDIT 
    // =========================== 
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // =========================== 
    // ADMIN - UPDATE 
    // =========================== 
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // =========================== 
    // ADMIN - DELETE 
    // =========================== 
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    // =========================== 
    // PUBLIC - DETAIL PRODUK 
    // =========================== 
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('product.show', compact('product'));
    }
}