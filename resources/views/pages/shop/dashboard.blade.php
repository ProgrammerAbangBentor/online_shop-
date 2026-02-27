@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
<style>
  :root{
    --pink-50:#fff1f5;
    --pink-100:#ffe4ec;
    --pink-200:#fecddc;
    --pink-300:#fda4c1;
    --pink-500:#ec4899;

    --ink:#1f2937;
    --muted:#6b7280;

    --card:#ffffff;
    --stroke: rgba(236,72,153,.14);
    --shadow: 0 18px 40px rgba(17,24,39,.08);
    --shadow-soft: 0 10px 24px rgba(17,24,39,.08);
    --radius: 18px;
  }

  .shop-hero{
    border-radius: var(--radius);
    border:1px solid var(--stroke);
    background: linear-gradient(135deg, rgba(255,241,245,.9), rgba(255,255,255,.95));
    box-shadow: var(--shadow-soft);
    padding: 28px;
  }

  .shop-hero h3{
    font-weight: 900;
    color: var(--ink);
  }

  .shop-hero p{
    color: var(--muted);
    font-size: 14px;
  }

  .btn-soft-pink{
    background: linear-gradient(135deg, var(--pink-300), var(--pink-500));
    border:none;
    font-weight:700;
    border-radius: 999px;
    padding:8px 18px;
    color:#fff;
  }

  .btn-soft-pink:hover{
    opacity:.9;
  }

  .product-card{
    border-radius: var(--radius);
    border:1px solid var(--stroke);
    box-shadow: var(--shadow-soft);
    transition: all .2s ease;
    overflow:hidden;
  }

  .product-card:hover{
    transform: translateY(-4px);
    box-shadow: var(--shadow);
  }

  .product-card img{
    height:220px;
    object-fit:cover;
  }

  .product-card .card-body{
    padding:16px;
  }

  .product-card h6{
    font-weight:800;
    color: var(--ink);
    margin-bottom:6px;
  }

  .product-price{
    font-weight:900;
    color: var(--pink-500);
    font-size:14px;
  }

  .section-title{
    font-weight:900;
    color: var(--ink);
    margin-bottom:16px;
  }
</style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-body">

      {{-- HERO --}}
      <div class="shop-hero mb-4 d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h3>Selamat Datang di Tri Collection</h3>
          <p>Temukan koleksi pakaian terbaru kami yang trendy dan berkualitas.</p>
          <a href="{{ route('shop.products.index') }}" class="btn btn-soft-pink mt-2">
            Belanja Sekarang
          </a>
        </div>
        <div>
          <img src="{{ asset('assets/img/hero.png') }}" width="240">
        </div>
      </div>

      {{-- PRODUK UNGGULAN --}}
      <div class="section-title">Produk Unggulan</div>

      <div class="row">
        @foreach($produkUnggulan as $p)
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card product-card">
              <img src="{{ $p->image ? asset('storage/products/'.$p->image) : asset('assets/img/default-product.png') }}"
                   class="card-img-top">

              <div class="card-body">
                <h6>{{ $p->name }}</h6>

                <div class="product-price mb-3">
                  Rp{{ number_format($p->price,0,',','.') }}
                </div>

                <a href="{{ route('shop.products.show',$p->id) }}"
                   class="btn btn-soft-pink btn-sm w-100">
                   Beli Sekarang
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

    </div>
  </section>
</div>
@endsection
