@extends('layouts.app')

@section('title', 'Katalog Produk')

@push('style')
<style>
  :root{
    --ink:#111827;
    --muted:#6b7280;
    --card:#ffffff;
    --stroke: rgba(17,24,39,.08);
    --shadow: 0 18px 40px rgba(17,24,39,.08);
    --shadow-soft: 0 10px 22px rgba(17,24,39,.08);

    /* base accent (ikut style kita) */
    --accent:#ec4899;
    --accent-2:#f472b6;
    --accent-soft: rgba(236,72,153,.14);
  }

  /* header */
  .katalog-hero{
    display:flex; align-items:flex-end; justify-content:space-between; gap:16px;
    margin-bottom: 16px;
  }
  .katalog-title{
    margin:0; font-weight:800; letter-spacing:.2px; color:var(--ink);
  }
  .katalog-sub{
    margin:6px 0 0; color:var(--muted); font-size:13px;
  }

  /* toolbar card */
  .katalog-toolbar{
    border: 1px solid var(--stroke);
    border-radius: 16px;
    box-shadow: var(--shadow-soft);
    overflow:hidden;
  }
  .katalog-toolbar .card-body{
    padding: 16px;
  }

  .katalog-input{
    border-radius: 14px !important;
    border: 1px solid var(--stroke) !important;
    height: 44px;
  }
  .katalog-select{
    border-radius: 14px !important;
    border: 1px solid var(--stroke) !important;
    height: 44px;
  }

  .btn-accent{
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    border: none;
    box-shadow: 0 12px 24px rgba(236,72,153,.22);
  }
  .btn-accent:hover{ filter: brightness(.98); }
  .btn-soft{
    background: rgba(17,24,39,.04);
    border: 1px solid var(--stroke);
    color: var(--ink);
    border-radius: 14px;
    height: 44px;
  }

  /* grid */
  .katalog-grid{ margin-top: 14px; }
  .p-card{
    background: var(--card);
    border: 1px solid var(--stroke);
    border-radius: 18px;
    overflow:hidden;
    box-shadow: var(--shadow-soft);
    transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease;
    height: 100%;
  }
  .p-card:hover{
    transform: translateY(-4px);
    box-shadow: var(--shadow);
    border-color: rgba(236,72,153,.18);
  }

  /* thumbnail */
  .p-thumb{
    position: relative;
    height: 190px;
    overflow:hidden;
    background: rgba(17,24,39,.03);
  }
  .p-thumb img{
    width:100%;
    height:190px;
    object-fit: cover;
    transform: scale(1.01);
  }

  /* ✅ badges pindah ke body (biar ga nutup gambar) */
  .p-pills{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
    margin-bottom:10px;
  }
  .pill{
    padding: 6px 10px;
    border-radius: 999px;
    font-weight: 800;
    font-size: 11px;
    border: 1px solid var(--stroke);
    background: rgba(17,24,39,.03);
    color: var(--ink);
    display:inline-flex;
    align-items:center;
    gap:6px;
    line-height: 1;
  }
  .pill-available{
    background: rgba(16,185,129,.14);
    color: #065f46;
    border-color: rgba(16,185,129,.22);
  }
  .pill-empty{
    background: rgba(239,68,68,.14);
    color: #7f1d1d;
    border-color: rgba(239,68,68,.22);
  }
  .pill-category{
    background: rgba(236,72,153,.12);
    color: #9d174d;
    border-color: rgba(236,72,153,.20);
  }

  .p-body{ padding: 14px 14px 16px; }
  .p-name{
    font-weight: 800;
    color: var(--ink);
    margin: 0;
    font-size: 14px;
    line-height: 1.25;
    min-height: 36px; /* biar rapi kalau nama beda panjang */
  }
  .p-meta{
    display:flex;
    justify-content:space-between;
    gap:10px;
    margin-top: 10px;
    color: var(--muted);
    font-size: 12px;
  }
  .p-price{
    margin-top: 10px;
    font-weight: 900;
    color: var(--ink);
    font-size: 14px;
  }
  .p-divider{
    height:1px;
    background: rgba(17,24,39,.06);
    margin: 12px 0;
  }
  .p-spec{
    display:flex;
    justify-content:space-between;
    gap:10px;
    font-size: 12px;
    color: var(--muted);
  }
  .p-spec b{ color: var(--ink); }

  .p-btn{
    margin-top: 12px;
    border-radius: 14px;
    height: 42px;
    font-weight: 800;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
  }

  /* pagination align */
  .katalog-pagination{
    display:flex;
    justify-content:center;
    margin-top: 18px;
  }

  /* empty state */
  .empty-wrap{
    border: 1px dashed rgba(17,24,39,.18);
    border-radius: 16px;
    padding: 18px;
    background: rgba(17,24,39,.02);
  }
</style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">

    {{-- HEADER --}}
    <div class="section-header">
      <div class="katalog-hero w-100">
        <div>
          <h1 class="katalog-title">Katalog Produk</h1>
          <p class="katalog-sub">Cari produk dan filter berdasarkan kategori. Klik untuk melihat detail.</p>
        </div>
      </div>
    </div>

    <div class="section-body">

      {{-- SEARCH + FILTER --}}
      <div class="card katalog-toolbar mb-4">
        <div class="card-body">
          <form method="GET" action="{{ route('shop.products.index') }}">
            <div class="row align-items-center">

              <div class="col-lg-6">
                <div class="input-group">
                  <input type="text"
                         class="form-control katalog-input"
                         name="q"
                         placeholder="Cari nama produk..."
                         value="{{ $q ?? '' }}">
                  <div class="input-group-append">
                    <button class="btn btn-accent" style="border-radius:14px; height:44px;">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 mt-3 mt-lg-0">
                <select name="category_id" class="form-control katalog-select">
                  <option value="">Semua Kategori</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string)($categoryId ?? '') === (string)$cat->id ? 'selected' : '' }}>
                      {{ $cat->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-lg-2 mt-3 mt-lg-0 d-flex" style="gap:10px;">
                <button class="btn btn-soft w-100" type="submit">
                  <i class="fas fa-filter"></i>&nbsp;Filter
                </button>

                @if(!empty($q) || !empty($categoryId))
                  <a class="btn btn-light w-100" style="border-radius:14px; height:44px; display:flex; align-items:center; justify-content:center;"
                     href="{{ route('shop.products.index') }}">
                    Reset
                  </a>
                @endif
              </div>

            </div>
          </form>
        </div>
      </div>

      {{-- GRID --}}
      <div class="row katalog-grid">
        @forelse($products as $product)
          @php
            $img = $product->image
              ? asset('storage/products/' . $product->image)
              : asset('assets/img/default-product.png');

            $catName = $product->category->name ?? '-';
            $inStock = (int)($product->stock ?? 0) > 0;
          @endphp

          <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4 d-flex">
            <div class="p-card w-100">

              <div class="p-thumb">
                <img src="{{ $img }}" alt="{{ $product->name }}">
              </div>

              <div class="p-body">

                {{-- ✅ BADGE PINDAH KE SINI --}}
                <div class="p-pills">
                  <span class="pill {{ $inStock ? 'pill-available' : 'pill-empty' }}">
                    <i class="fas {{ $inStock ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                    {{ $inStock ? 'Tersedia' : 'Habis' }}
                  </span>
                  <span class="pill pill-category">
                    <i class="fas fa-tag"></i>
                    {{ $catName }}
                  </span>
                </div>

                <h6 class="p-name">{{ $product->name }}</h6>

                <div class="p-price">
                  {{ $product->formatted_price }}
                </div>

                <div class="p-divider"></div>

                <div class="p-spec">
                  <div>Ukuran</div>
                  <div><b>{{ $product->size ?? '-' }}</b></div>
                </div>
                <div class="p-spec mt-1">
                  <div>Stok</div>
                  <div><b>{{ $product->stock }}</b></div>
                </div>

                <div class="mt-3">
                  <a href="{{ route('shop.products.show', $product->id) }}"
                     class="btn btn-accent p-btn btn-block">
                    <i class="fas fa-eye"></i> Lihat Detail
                  </a>
                </div>

              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="empty-wrap">
              <div style="font-weight:900; color:var(--ink);">Produk tidak ditemukan</div>
              <div style="color:var(--muted); font-size:13px; margin-top:6px;">
                Coba ubah kata kunci pencarian atau reset filter kategori.
              </div>
            </div>
          </div>
        @endforelse
      </div>

      {{-- PAGINATION --}}
      <div class="katalog-pagination">
        {{ $products->links() }}
      </div>

    </div>
  </section>
</div>
@endsection
