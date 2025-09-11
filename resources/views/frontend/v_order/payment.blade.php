@extends('frontend.layouts.index')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="order-summary clearfix">
                        <div class="section-title">
                            <h3 class="title">Keranjang Belanja</h3>
                        </div>
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <strong>{{ session('success') }}</strong>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <strong>{{ session('error') }}</strong>
                            </div>
                        @endif
                        @if ($order && $order->orderItems->count() > 0)
                            <div class="hidden-xs">
                                <table class="shopping-cart-table table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th></th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtotal = 0;
                                            $potonganDiskon = ($order->subtotal * $order->diskon) / 100;
                                        @endphp
                                        @foreach ($order->orderItems as $item)
                                            @php
                                                $subtotal += $item->harga * $item->quantity;
                                            @endphp
                                            <tr>
                                                <td class="thumb"><img src="{{ asset('storage/' . $item->produk->image) }}"
                                                        alt="">
                                                </td>
                                                <td class="details">
                                                    <a>{{ $item->produk->nm_barang }}</a>
                                                </td>
                                                <td class="price text-center"><strong>Rp.
                                                        {{ number_format($item->produk->hrgjual_barang2, 0, ',', '.') }}</strong>
                                                </td>
                                                <td class="qty text-center">
                                                    <a> {{ $item->quantity }} </a>
                                                </td>
                                                <td class="total text-center"><strong class="primary-color">Rp.
                                                        {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="empty" colspan="3"></th>
                                            <th>SUBTOTAL</th>
                                            <th colspan="2" class="sub-total">Rp.
                                                {{ number_format($subtotal, 0, ',', '.') }}</th>
                                        </tr>
                                        <tr>
                                            <th class="empty" colspan="3"></th>
                                            <th>DISKON</th>
                                            <th colspan="2" class="sub-total text-danger">
                                                Rp. {{ number_format($potonganDiskon, 0, ',', '.') }}
                                                ({{ $order->diskon }}%)
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="empty" colspan="3"></th>
                                            <th>TOTAL BAYAR</th>
                                            <th colspan="2" class="total">Rp.
                                                {{ number_format($order->total_harga, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="visible-xs">
                                @php $totalHarga = 0; @endphp
                                @foreach ($order->orderItems as $item)
                                    @php $totalHarga += $item->harga * $item->quantity; @endphp
                                    <div class="panel panel-default" style="margin-bottom: 10px;">
                                        <div class="panel-body" style="display: flex;">
                                            <img src="{{ asset('storage/' . $item->produk->image) }}" alt=""
                                                style="width: 70px; height: 70px; object-fit: cover; margin-right: 10px;">
                                            <div style="flex: 1;">
                                                <strong>{{ $item->produk->nm_barang }}</strong>
                                                <div style="margin-top: 5px; color: #d10024;">Rp.
                                                    {{ number_format($item->produk->hrgjual_barang2, 0, ',', '.') }}</div>
                                                <div style="font-size: 12px;">Qty: {{ $item->quantity }}</div>
                                                <div style="font-weight: bold;">Total: Rp.
                                                    {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                                {{-- Total harga mobile --}}
                                <div style="margin-top: 15px; background: #f9f9f9; padding: 10px 15px; border-radius: 8px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 16px; font-weight: bold;">Subtotal</span>
                                        <span style="font-size: 18px; font-weight: bold; color: #d10024;">
                                            Rp. {{ number_format($totalHarga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 16px; font-weight: bold;">Diskon</span>
                                        <span style="font-size: 18px; font-weight: bold; color: #d10024;">
                                            Rp. {{ number_format($potonganDiskon, 0, ',', '.') }}
                                            ({{ $order->diskon }}%)
                                        </span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 16px; font-weight: bold;">Total Harga</span>
                                        <span style="font-size: 18px; font-weight: bold; color: #d10024;">
                                            Rp. {{ number_format($order->total_harga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="total_price" value="{{ $totalHarga }}">
                            <div class="form-group" style="max-width: 300px; margin-top: 20px;">
                                <label for="payment_method">Metode Pembayaran:</label>
                                <select id="payment_method" name="payment_method" class="form-control" required>
                                    {{-- <option value="midtrans">Bayar Online (Midtrans)</option> --}}
                                    <option value="cod">Bayar di Tempat (COD)</option>
                                </select>
                            </div>
                            <div class="pull-right">
                                <button class="primary-btn" id="pay-button">Bayar Sekarang</button>
                            </div>
                        @else
                            <p>Keranjang belanja kosong.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        var paymentMethod = document.getElementById('payment_method');

        payButton.addEventListener('click', function() {
            if (paymentMethod.value === 'midtrans') {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        alert("Pembayaran berhasil!");
                        console.log(result);
                        window.location.href = "{{ route('order.complete') }}";
                    },
                    onPending: function(result) {
                        alert("Menunggu pembayaran...");
                        console.log(result);
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                        console.log(result);
                    },
                    onClose: function() {
                        alert('Kamu menutup popup tanpa menyelesaikan pembayaran');
                    }
                });
            } else if (paymentMethod.value === 'cod') {
                // Redirect ke route khusus untuk COD
                window.location.href = "{{ route('order.cod') }}";
            }
        });
    </script>

@endsection
