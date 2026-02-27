@extends('layouts.app')
@section('title', 'Keranjang')

@push('style')
<style>
  :root{
    --ink:#111827;
    --muted:#6b7280;
    --card:#ffffff;
    --stroke: rgba(17,24,39,.08);
    --shadow: 0 18px 40px rgba(17,24,39,.08);
    --shadow-soft: 0 10px 22px rgba(17,24,39,.08);

    --accent:#ec4899;
    --accent-2:#f472b6;
  }

  .cart-card{
    border: 1px solid var(--stroke);
    border-radius: 18px;
    box-shadow: var(--shadow-soft);
    overflow:hidden;
  }

  .cart-table{
    margin:0;
  }

  .cart-table thead th{
    border-top: 0 !important;
    border-bottom: 1px solid rgba(17,24,39,.06) !important;
    font-size: 12px;
    color: var(--muted);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .6px;
    background: rgba(17,24,39,.02);
    padding: 14px 14px;
    white-space: nowrap;
  }

  .cart-table tbody td{
    border-top: 0 !important;
    border-bottom: 1px solid rgba(17,24,39,.06);
    padding: 14px 14px;
    vertical-align: middle;
  }

  .p-row{
    display:flex;
    align-items:center;
    gap:12px;
    min-width: 240px;
  }

  .p-thumb{
    width:58px; height:58px;
    border-radius: 14px;
    overflow:hidden;
    border: 1px solid rgba(17,24,39,.08);
    background: rgba(17,24,39,.02);
    flex: 0 0 auto;
  }
  .p-thumb img{
    width:100%; height:100%;
    object-fit: cover;
  }

  .p-name{
    font-weight: 900;
    color: var(--ink);
    line-height: 1.2;
  }
  .p-sub{
    font-size: 12px;
    color: var(--muted);
    margin-top: 4px;
  }

  .money{
    font-weight: 900;
    color: var(--ink);
    white-space: nowrap;
  }

  .qty-wrap{
    display:flex;
    align-items:center;
    gap:8px;
  }
  .qty-input{
    width: 92px;
    height: 42px;
    border-radius: 14px;
    border: 1px solid rgba(17,24,39,.10);
  }

  .btn-accent{
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    border: none;
    border-radius: 14px;
    height: 42px;
    font-weight: 900;
    box-shadow: 0 10px 20px rgba(236,72,153,.22);
    padding: 0 14px;
    white-space: nowrap;
  }

  .btn-soft-danger{
    background: rgba(239,68,68,.10);
    border: 1px solid rgba(239,68,68,.22);
    color: #991b1b;
    border-radius: 14px;
    height: 42px;
    width: 46px;
    display:flex;
    align-items:center;
    justify-content:center;
  }
  .btn-soft-danger:hover{
    background: rgba(239,68,68,.14);
    color:#7f1d1d;
  }

  .summary-box{
    border: 1px solid rgba(17,24,39,.08);
    border-radius: 18px;
    padding: 16px;
    background: rgba(17,24,39,.02);
  }
  .summary-label{
    font-size: 12px;
    color: var(--muted);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .6px;
  }
  .summary-total{
    font-size: 20px;
    font-weight: 900;
    color: var(--ink);
    margin-top: 6px;
    white-space: nowrap;
  }

  .btn-checkout{
    background: #16a34a;
    border: none;
    border-radius: 14px;
    height: 44px;
    font-weight: 900;
    padding: 0 16px;
    box-shadow: 0 10px 18px rgba(22,163,74,.18);
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
  }

  .empty-wrap{
    border: 1px dashed rgba(17,24,39,.18);
    border-radius: 18px;
    padding: 18px;
    background: rgba(17,24,39,.02);
  }
</style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Keranjang</h1>
    </div>

    <div class="section-body">
      @include('layouts.alert')

      <div class="card cart-card">
        <div class="card-body p-0">

          @if ($cart->items->count() === 0)
            <div class="p-4">
              <div class="empty-wrap">
                <div style="font-weight:900; color:var(--ink); font-size:16px;">Keranjang masih kosong</div>
                <div style="color:var(--muted); font-size:13px; margin-top:6px;">
                  Yuk, pilih produk dulu di katalog.
                </div>
                <div class="mt-3">
                  <a href="{{ route('shop.products.index') }}" class="btn btn-accent">
                    <i class="fas fa-store"></i> Ke Katalog
                  </a>
                </div>
              </div>
            </div>
          @else

            <div class="table-responsive">
              <table class="table cart-table">
                <thead>
                  <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Ukuran</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th class="text-center">Aksi</th>
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
                        <div class="p-row">
                          <div class="p-thumb">
                            <img src="{{ $img }}" alt="{{ $p->name }}">
                          </div>
                          <div>
                            <div class="p-name">{{ $p->name }}</div>
                            <div class="p-sub">Stok: {{ $p->stock }}</div>
                          </div>
                        </div>
                      </td>

                      <td class="money">Rp {{ number_format($item->price, 0, ',', '.') }}</td>

                      <td>
                        <span style="font-weight:800; color:var(--ink);">
                          {{ $item->size ?? '-' }}
                        </span>
                      </td>

                      <td style="min-width:240px;">
                        <form method="POST" action="{{ route('cart.item.qty', $item->id) }}">
                          @csrf
                          <div class="qty-wrap">
                            <input type="number"
                                   name="qty"
                                   class="form-control qty-input"
                                   value="{{ $item->qty }}"
                                   min="1"
                                   max="{{ $p->stock }}">

                            <button class="btn btn-accent" type="submit">
                              Update
                            </button>
                          </div>
                          <small class="text-muted d-block mt-2">
                            *Maks. qty sesuai stok ({{ $p->stock }})
                          </small>
                        </form>
                      </td>

                      <td class="money">Rp {{ number_format($sub, 0, ',', '.') }}</td>

                      <td class="text-center" style="width:110px;">
                        <form method="POST" action="{{ route('cart.item.remove', $item->id) }}">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-soft-danger" type="submit" title="Hapus">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="p-4">
              <div class="d-flex justify-content-end">
                <div style="width: 360px; max-width: 100%;">
                  <div class="summary-box">
                    <div class="summary-label">Subtotal</div>
                    <div class="summary-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>

                    <div class="mt-3">
                      <a href="{{ route('transactions.checkout') }}" class="btn btn-checkout btn-block">
                        <i class="fas fa-credit-card"></i>Checkout
                      </a>
                    </div>

                    <div class="text-muted mt-2" style="font-size:12px;">
                      Pastikan qty sudah sesuai sebelum checkout.
                    </div>
                  </div>
                </div>
              </div>
            </div>

          @endif

        </div>
      </div>

    </div>
  </section>
</div>
@endsection
