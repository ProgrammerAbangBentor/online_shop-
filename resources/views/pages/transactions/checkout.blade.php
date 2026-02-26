@extends('layouts.app')
@section('title', 'Checkout')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Checkout</h1>
    </div>

    <div class="section-body">
      @include('layouts.alert')

      <div class="row">

        {{-- FORM --}}
        <div class="col-lg-7">
          <div class="card">
            <div class="card-header"><h4>Data Pengiriman</h4></div>
            <div class="card-body">

              <form method="POST" action="{{ route('transactions.store') }}">
                @csrf

                <div class="form-group">
                  <label>Nama Penerima</label>
                  <input type="text" name="customer_name"
                         class="form-control @error('customer_name') is-invalid @enderror"
                         value="{{ old('customer_name', auth()->user()->name) }}" required>
                  @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                  <label>No. HP</label>
                  <input type="text" name="customer_phone"
                         class="form-control @error('customer_phone') is-invalid @enderror"
                         value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required>
                  @error('customer_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                  <label>Alamat Lengkap</label>
                  <textarea name="shipping_address" rows="4"
                            class="form-control @error('shipping_address') is-invalid @enderror"
                            placeholder="Contoh: Jl. xxx, Kecamatan, Kota, Provinsi, Kode Pos" required>{{ old('shipping_address') }}</textarea>
                  @error('shipping_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                  <label>Catatan (Opsional)</label>
                  <textarea name="notes" rows="3" class="form-control"
                            placeholder="Contoh: titip ke satpam">{{ old('notes') }}</textarea>
                </div>

                <button class="btn btn-success">
                  Buat Transaksi & Lanjut Bayar
                </button>

                <a href="{{ route('shop.cart.index') }}" class="btn btn-light ml-2">
                  Kembali ke Keranjang
                </a>
              </form>

            </div>
          </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header"><h4>Ringkasan</h4></div>
            <div class="card-body">

              @foreach($cart->items as $item)
                @php $p = $item->product; @endphp
                <div class="d-flex justify-content-between mb-2">
                  <div>
                    <div style="font-weight:700;">{{ $p->name }}</div>
                    <div class="text-muted small">
                      Qty: {{ $item->qty }} | Size: {{ $item->size ?? '-' }}
                    </div>
                  </div>
                  <div>
                    Rp {{ number_format($item->price * $item->qty,0,',','.') }}
                  </div>
                </div>
                <hr class="my-2">
              @endforeach

              <div class="d-flex justify-content-between mt-3">
                <div class="text-muted">Subtotal</div>
                <div><b>Rp {{ number_format($subtotal,0,',','.') }}</b></div>
              </div>

              {{-- <div class="d-flex justify-content-between">
                <div class="text-muted">Ongkir</div>
                <div><b>Rp 0</b></div>
              </div> --}}

              <div class="d-flex justify-content-between mt-2">
                <div style="font-weight:800;">Total</div>
                <div style="font-weight:800;">Rp {{ number_format($subtotal,0,',','.') }}</div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
@endsection
