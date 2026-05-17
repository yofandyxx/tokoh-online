<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    // Tampilkan daftar bank dengan search & pagination 
    public function index(Request $request)
    {
        $query = Bank::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('account_number', 'like', "%$search%")
                ->orWhere('account_name', 'like', "%$search%");
        }

        $banks = $query->latest()->paginate(10);
        $banks->appends($request->only('search'));

        return view('admin.banks.index', compact('banks'));
    }

    // Form tambah bank 
    public function create()
    {
        return view('admin.banks.create');
    }

    // Simpan bank baru 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
        ]);
        Bank::create($request->all());

        return redirect()->route('admin.banks.index')->with('success', 'Bank 
berhasil ditambahkan.');
    }

    // Form edit bank 
    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    // Update bank 
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
        ]);

        $bank->update($request->all());

        return redirect()->route('admin.banks.index')->with('success', 'Bank 
berhasil diupdate.');
    }

    // Hapus bank 
    public function destroy(Bank $bank)
    {
        $bank->delete();

        return redirect()->route('admin.banks.index')->with('success', 'Bank 
berhasil dihapus.');
    }
}