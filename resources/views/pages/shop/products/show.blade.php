@extends('layouts.app')
@section('title', 'Detail Produk')

@push('style')
<style>
  :root{
    --ink:#111827;
    --muted:#6b7280;
    --card:#ffffff;
    --stroke: rgba(17,24,39,.08);
    --shadow: 0 20px 40px rgba(17,24,39,.08);
    --shadow-soft: 0 12px 24px rgba(17,24,39,.08);

    --accent:#ec4899;
    --accent-2:#f472b6;
  }

  .product-card{
    border:1px solid var(--stroke);
    border-radius:20px;
    box-shadow: var(--shadow);
  }

  .product-img{
    width:100%;
    border-radius:18px;
    box-shadow: var(--shadow-soft);
    object-fit: cover;
  }

  .product-title{
    font-weight:900;
    color:var(--ink);
  }

  .product-category{
    font-size:13px;
    color:var(--muted);
  }

  .product-price{
    font-size:22px;
    font-weight:900;
    color:var(--ink);
  }

  .divider{
    height:1px;
    background:rgba(17,24,39,.06);
    margin:18px 0;
  }

  .pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
  }

  .pill-ok{
    background: rgba(16,185,129,.14);
    color:#065f46;
  }

  .pill-bad{
    background: rgba(239,68,68,.14);
    color:#7f1d1d;
  }

  .qty-input{
    width:110px;
    border-radius:12px;
    border:1px solid var(--stroke);
    height:42px;
  }

  .size-select{
    border-radius:12px;
    border:1px solid var(--stroke);
    height:42px;
    min-width: 180px;
  }

  .btn-accent{
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    border:none;
    border-radius:14px;
    height:44px;
    font-weight:800;
    box-shadow:0 12px 24px rgba(236,72,153,.25);
  }

  .btn-accent:hover{
    filter:brightness(.98);
  }

</style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Detail Produk</h1>
      <div class="section-header-breadcrumb">
        <a href="{{ route('shop.products.index') }}" class="btn btn-light">Kembali</a>
      </div>
    </div>

    <div class="section-body">
      @php
        $img = $product->image
          ? asset('storage/products/' . $product->image)
          : asset('assets/img/default-product.png');

        $inStock = (int)($product->stock ?? 0) > 0;

        // ✅ Parse size dari string: "S / M / L / XL" atau "S,M,L" atau "S | M | L"
        $rawSizes = (string) ($product->size ?? '');
        $sizes = array_values(array_filter(array_map('trim', preg_split('/[\/,|]+/', $rawSizes))));
      @endphp

      <div class="card product-card">
        <div class="card-body p-4">
          <div class="row align-items-start">

            {{-- IMAGE --}}
            <div class="col-md-5 mb-4 mb-md-0">
              <img src="{{ $img }}" alt="{{ $product->name }}" class="product-img">
            </div>

            {{-- DETAIL --}}
            <div class="col-md-7">

              <h3 class="product-title mb-2">{{ $product->name }}</h3>

              <div class="product-category mb-3">
                {{ $product->category->name ?? '-' }}
              </div>

              <div class="product-price mb-3">
                {{ $product->formatted_price }}
              </div>

              <div class="row mb-3">
                <div class="col-6">
                  <div style="font-size:13px; color:var(--muted);">Ukuran</div>
                  <div style="font-weight:800; font-size:14px;">
                    {{ $product->size ?? '-' }}
                  </div>
                </div>

                <div class="col-6">
                  <div style="font-size:13px; color:var(--muted);">Stok</div>
                  <div style="font-weight:800; font-size:14px;">
                    {{ $product->stock }}
                  </div>
                </div>
              </div>

              {{-- STATUS --}}
              @if($inStock)
                <span class="pill pill-ok mb-3">
                  <i class="fas fa-check-circle"></i> Tersedia
                </span>
              @else
                <span class="pill pill-bad mb-3">
                  <i class="fas fa-times-circle"></i> Habis
                </span>
              @endif

              <div class="divider"></div>

              {{-- ADD TO CART --}}
              @if($inStock)
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                  @csrf

                  <div class="d-flex align-items-center flex-wrap" style="gap:14px;">

                    {{-- ✅ Pilih ukuran (wajib) --}}
                    <div style="min-width:200px;">
                      <div class="text-muted" style="font-size:12px; font-weight:800;">Pilih Ukuran</div>
                      <select name="size" class="form-control size-select" required>
                        <option value="">-- pilih --</option>
                        @forelse($sizes as $s)
                          <option value="{{ $s }}">{{ $s }}</option>
                        @empty
                          <option value="" disabled>Tidak ada ukuran</option>
                        @endforelse
                      </select>
                    </div>

                    {{-- Qty --}}
                    <div>
                      <div class="text-muted" style="font-size:12px; font-weight:800;">Qty</div>
                      <input type="number"
                             name="qty"
                             value="1"
                             min="1"
                             max="{{ $product->stock }}"
                             class="form-control qty-input">
                    </div>

                    <div style="margin-top:22px;">
                      <button type="submit" class="btn btn-accent">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                      </button>
                    </div>

                  </div>

                  <small class="text-muted d-block mt-2">
                    *Qty maksimal sesuai stok ({{ $product->stock }})
                  </small>
                </form>
              @else
                <div class="alert alert-danger mt-3 mb-0">
                  Stok habis, tidak bisa ditambahkan ke keranjang.
                </div>
              @endif

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
