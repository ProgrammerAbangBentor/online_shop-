@extends('layouts.app')
@section('title', 'Keranjang')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Keranjang</h1>
            </div>

            <div class="section-body">

                @include('layouts.alert')

                <div class="card">
                    <div class="card-body">

                        @if ($cart->items->count() === 0)
                            <div class="alert alert-warning mb-0">Keranjang masih kosong.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Ukuran</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart->items as $item)
                                            @php
                                                $p = $item->product;
                                                $img = $p->image
                                                    ? asset('storage/products/' . $p->image)
                                                    : asset('assets/img/default-product.png');
                                                $sub = $item->price * $item->qty;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap:10px;">
                                                        <img src="{{ $img }}"
                                                            style="width:55px;height:55px;object-fit:cover;border-radius:10px;">
                                                        <div>
                                                            <div class="font-weight-bold">{{ $p->name }}</div>
                                                            <div class="text-muted small">Stok: {{ $p->stock }}</div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td>{{ $item->size ?? '-' }}</td>

                                                <td style="width:200px;">
                                                    <form method="POST" action="{{ route('cart.item.qty', $item->id) }}"
                                                        class="d-flex" style="gap:8px;">
                                                        @csrf
                                                        <input type="number" name="qty" class="form-control"
                                                            value="{{ $item->qty }}" min="1"
                                                            max="{{ $p->stock }}">
                                                        <button class="btn btn-primary btn-sm">Update</button>
                                                    </form>
                                                </td>

                                                <td>Rp {{ number_format($sub, 0, ',', '.') }}</td>

                                                <td style="width:110px;">
                                                    <form method="POST"
                                                        action="{{ route('cart.item.remove', $item->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <div class="text-right">
                                    <div class="text-muted">Subtotal</div>
                                    <h4 class="mb-0">Rp {{ number_format($subtotal, 0, ',', '.') }}</h4>
                                </div>
                            </div>

                            {{-- tombol checkout nanti kita sambung ke menu Transaksi --}}
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('transactions.checkout') }}" class="btn btn-success">
                                    Lanjut Checkout
                                </a>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
