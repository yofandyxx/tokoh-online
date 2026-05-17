@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
    <div class="row justify-content-center" style="min-height: 80vh;">
        <div class="col-md-10">
            <h3 class="mb-4 text-center">Checkout</h3>
            @if(empty($cart) || count($cart) === 0)
                <div class="alert alert-info">Keranjang Anda kosong.</div>
            @else
                {{-- Ringkasan Keranjang --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <i class="bi bi-cart-check"></i> Ringkasan Belanja
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cart as $item)
                                                @php
                                                    $subtotal = $item['subtotal'] ?? ($item['price'] *
                                                        $item['qty']);
                                                    $total += $subtotal;
                                                @endphp
                                                <tr>
                                                    <td class="d-flex align-items-center">
                                                        @if(!empty($item['image']))
                                                                            <img src="{{
                                                            asset('storage/' . $item['image']) }}" width="50" class="me-2 rounded">
                                                        @endif
                                                        <span>{{ $item['name'] }}</span>
                                                    </td>
                                                    <td>Rp <span class="price">{{
                                    number_format($item['price'], 0, ',', '.') }}</span></td>
                                                    <td>{{ $item['qty'] }}</td>
                                                    <td>Rp <span class="subtotal">{{
                                    number_format($subtotal, 0, ',', '.') }}</span></td>
                                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th>Rp <span id="total">{{
                number_format($total, 0, ',', '.') }}</span></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Form Checkout --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-credit-card"></i> Form Checkout
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nama
                                        Penerima</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nama lengkap"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">No.
                                        Telepon</label>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="0812xxxxxx"
                                        required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat
                                    Pengiriman</label>
                                <textarea class="form-control" name="address" id="address" rows="3" placeholder="Alamat lengkap"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <div class="d-flex gap-3 flex-wrap mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input payment-radio" type="radio" name="payment" id="cod"
                                            value="cod" required>
                                        <label class="form-check-label" for="cod">
                                            <i class="bi bi-cash-stack"></i> COD
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input payment-radio" type="radio" name="payment" id="bank"
                                            value="bank" required>
                                        <label class="form-check-label" for="bank">
                                            <i class="bi bi-bank"></i> Transfer Bank
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input payment-radio" type="radio" name="payment" id="ewallet"
                                            value="ewallet" required>
                                        <label class="form-check-label" for="ewallet">
                                            <i class="bi bi-phone"></i> E-Wallet
                                        </label>
                                    </div>
                                </div>
                                {{-- Pilihan Bank --}}
                                <div id="bank-selection" class="mb-2" style="display:none;">
                                    <label for="bank_name" class="form-label">Pilih
                                        Bank</label>
                                    <select id="bank_name" class="form-select">
                                        <option value="" selected disabled>-- Pilih Bank --</option>
                                        @foreach(\App\Models\Bank::all() as $bank)
                                            <option value="{{ $bank->id }}"
                                                data-rekening="{{ $bank->account_number }} a/n {{ $bank->account_name }}">
                                                {{ $bank->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Nomor Rekening --}}
                                <div id="bank-details" class="p-3 border rounded bg-light" style="display:none;">
                                    <strong>Nomor Rekening:</strong>
                                    <div id="rekening-text" class="fw-bold text-primary"></div>
                                    <small class="text-muted">Harap transfer sesuai nomor
                                        rekening dan konfirmasi setelah pembayaran.</small>
                                </div>
                            </div>
                            <input type="hidden" name="cart_data" value="{{
                json_encode($cart) }}">
                            <button type="submit" class="btn btn-primary w-100 mt-3">
                                <i class="bi bi-check2-circle"></i> Proses Checkout
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // Tooltip Bootstrap
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
        // Payment radio change
        const bankSelection = document.getElementById('bank-selection');
        const bankDetails = document.getElementById('bank-details');
        const rekeningText = document.getElementById('rekening-text');
        document.querySelectorAll('.payment-radio').forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'bank') {
                    bankSelection.style.display = 'block';
                } else {
                    bankSelection.style.display = 'none';
                    bankDetails.style.display = 'none';
                    rekeningText.innerHTML = '';
                }
            });
        });
        // Pilihan bank menampilkan nomor rekening
        const bankNameSelect = document.getElementById('bank_name');
        bankNameSelect.addEventListener('change', function () {
            const selectedOption = this.selectedOptions[0];
            const rekening = selectedOption.dataset.rekening;
            if (rekening) {
                rekeningText.innerHTML = rekening;
                bankDetails.style.display = 'block';
            } else {
                rekeningText.innerHTML = '';
                bankDetails.style.display = 'none';
            }
        });
    </script>
@endsection