<div class="sidebar d-flex flex-column">
    {{-- Header --}}
    <div class="text-center mb-4 p-3" style="background: linear-gradient(135deg,
#990000, #b22222); border-radius: 12px;">
        <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="Logo Toko" class="img-fluid mb-2" style="width: 70px; height: 70px; border-radius: 50%; border: 2px solid
#fff;">
        <h5 class="fw-bold text-white mt-2">Toko Online</h5>
    </div>
    {{-- Menu --}}
    <a href="{{ route('admin.dashboard') }}" class="{{
    Request::is('admin/dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('admin.products.index') }}" class="{{
    Request::is('admin/products*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Produk
    </a>
    <a href="{{ route('admin.categories.index') }}" class="{{
    Request::is('admin/categories*') ? 'active' : '' }}">
        <i class="bi bi-tags"></i> Kategori
    </a>
    <a href="{{ route('admin.banks.index') }}" class="{{ Request::is('admin/banks*')
    ? 'active' : '' }}">
        <i class="bi bi-bank2"></i> Bank
    </a>
    <a href="{{ route('admin.transactions.index') }}" class="{{
    Request::is('admin/transactions*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i> Laporan Transaksi
    </a>
    {{-- Tambahkan menu Transaksi Terbaru --}}
    <a href="{{ route('admin.transactions.recent') }}" class="{{
    Request::is('admin/transactions/recent') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Transaksi Terbaru
    </a>
    <a href="{{ route('admin.users.index') }}" class="{{ Request::is('admin/users*')
    ? 'active' : '' }}">
        <i class="bi bi-people"></i> Pengguna
    </a>
</div>