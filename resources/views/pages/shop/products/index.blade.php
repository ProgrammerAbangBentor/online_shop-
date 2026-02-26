@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Katalog Produk</h1>
    </div>

    <div class="section-body">

      {{-- Search + Filter --}}
      <div class="card mb-4">
        <div class="card-body">
          <form method="GET" action="{{ route('shop.products.index') }}">
            <div class="row">
              <div class="col-md-6">
                <div class="input-group">
                  <input type="text" class="form-control" name="q" placeholder="Cari produk..." value="{{ $q }}">
                  <div class="input-group-append">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div>

              <div class="col-md-4 mt-3 mt-md-0">
                <select name="category_id" class="form-control">
                  <option value="">Semua Kategori</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string)$categoryId === (string)$cat->id ? 'selected' : '' }}>
                      {{ $cat->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-2 mt-3 mt-md-0">
                <button class="btn btn-secondary btn-block" type="submit">Filter</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      {{-- Grid Product --}}
      <div class="row">
        @forelse($products as $product)
          @php
            $img = $product->image
              ? asset('storage/products/' . $product->image)
              : asset('assets/img/default-product.png');
          @endphp

          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card" style="border-radius:14px; overflow:hidden;">
              <div style="height:180px; overflow:hidden;">
                <img src="{{ $img }}" alt="{{ $product->name }}"
                     style="width:100%; height:180px; object-fit:cover;">
              </div>

              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                  <h6 class="mb-1">{{ $product->name }}</h6>
                  @if((int)$product->stock > 0)
                    <span class="badge badge-success">Tersedia</span>
                  @else
                    <span class="badge badge-danger">Habis</span>
                  @endif
                </div>

                <div class="text-muted small mb-2">
                  {{ $product->category->name ?? '-' }}
                </div>

                <div class="font-weight-bold mb-2">
                  {{ $product->formatted_price }}
                </div>

                <div class="small">
                  <div>Ukuran: <b>{{ $product->size ?? '-' }}</b></div>
                  <div>Stok: <b>{{ $product->stock }}</b></div>
                </div>

                <div class="mt-3">
                  <a href="{{ route('shop.products.show', $product->id) }}"
                     class="btn btn-primary btn-sm btn-block">
                    Lihat Detail
                  </a>
                </div>

              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-warning">Produk tidak ditemukan.</div>
          </div>
        @endforelse
      </div>

      <div class="mt-3">
        {{ $products->links() }}
      </div>

    </div>
  </section>
</div>
@endsection
