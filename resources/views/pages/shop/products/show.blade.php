@extends('layouts.app')
@section('title', 'Detail Produk')

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
      @endphp

      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-5">
              <img src="{{ $img }}" alt="{{ $product->name }}" style="width:100%; border-radius:12px;">
            </div>
            <div class="col-md-7">
              <h4 class="mb-2">{{ $product->name }}</h4>
              <div class="text-muted mb-2">{{ $product->category->name ?? '-' }}</div>

              <h5 class="mb-3">{{ $product->formatted_price }}</h5>

              <div class="mb-2">Ukuran: <b>{{ $product->size ?? '-' }}</b></div>
              <div class="mb-2">Stok: <b>{{ $product->stock }}</b></div>

              @if((int)$product->stock > 0)
                <span class="badge badge-success">Tersedia</span>
              @else
                <span class="badge badge-danger">Habis</span>
              @endif

              {{-- tombol Add to Cart nanti kita pasang di sini --}}
              {{-- tombol Add to Cart --}}
                @if((int)$product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-3">
                    @csrf

                    <div class="d-flex align-items-center" style="gap:10px;">
                    <input type="number"
                            name="qty"
                            class="form-control"
                            value="1"
                            min="1"
                            max="{{ $product->stock }}"
                            style="width:120px;">

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                    </div>

                    <small class="text-muted d-block mt-2">
                    *Qty maksimal sesuai stok ({{ $product->stock }})
                    </small>
                </form>
                @else
                <div class="alert alert-danger mt-3 mb-0">Stok habis, tidak bisa ditambahkan ke keranjang.</div>
                @endif
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
