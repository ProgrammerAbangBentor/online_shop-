@extends('layouts.app')
@section('title', 'Checkout')

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

  .c-card{
    border: 1px solid var(--stroke);
    border-radius: 18px;
    box-shadow: var(--shadow-soft);
    overflow: hidden;
  }

  .c-head{
    background: rgba(17,24,39,.02);
    border-bottom: 1px solid rgba(17,24,39,.06);
    padding: 14px 16px;
  }
  .c-head h4{
    margin:0;
    font-weight: 900;
    color: var(--ink);
    font-size: 14px;
    letter-spacing: .2px;
  }

  .c-body{ padding: 16px; }

  .label-soft{
    font-size: 12px;
    color: var(--muted);
    font-weight: 800;
    letter-spacing: .3px;
    margin-bottom: 6px;
  }

  .input-soft{
    height: 44px;
    border-radius: 14px !important;
    border: 1px solid rgba(17,24,39,.10) !important;
  }
  .textarea-soft{
    border-radius: 14px !important;
    border: 1px solid rgba(17,24,39,.10) !important;
  }
  .input-soft:focus,
  .textarea-soft:focus{
    border-color: rgba(236,72,153,.35) !important;
    box-shadow: 0 0 0 .2rem rgba(236,72,153,.12) !important;
  }

  .btn-accent{
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    border:none;
    border-radius: 14px;
    height: 44px;
    font-weight: 900;
    box-shadow: 0 12px 24px rgba(236,72,153,.22);
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
  }
  .btn-accent:hover{ filter: brightness(.98); }

  .btn-ghost{
    background: rgba(17,24,39,.04);
    border: 1px solid rgba(17,24,39,.08);
    border-radius: 14px;
    height: 44px;
    font-weight: 800;
    color: var(--ink);
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
  }

  /* summary items */
  .sum-item{
    border: 1px solid rgba(17,24,39,.06);
    border-radius: 14px;
    padding: 12px 12px;
    background: rgba(17,24,39,.015);
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    margin-bottom: 10px;
  }
  .sum-name{
    font-weight: 900;
    color: var(--ink);
    font-size: 13px;
    line-height: 1.2;
  }
  .sum-meta{
    margin-top: 6px;
    font-size: 12px;
    color: var(--muted);
  }
  .sum-price{
    font-weight: 900;
    color: var(--ink);
    white-space: nowrap;
    font-size: 13px;
  }

  .totals{
    margin-top: 14px;
    border-top: 1px solid rgba(17,24,39,.06);
    padding-top: 12px;
  }

  .total-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top: 8px;
    color: var(--muted);
    font-size: 13px;
  }
  .total-row b{ color: var(--ink); }

  .grand{
    margin-top: 10px;
    padding: 12px 12px;
    border-radius: 14px;
    background: rgba(236,72,153,.08);
    border: 1px solid rgba(236,72,153,.16);
    display:flex;
    justify-content:space-between;
    align-items:center;
  }
  .grand .l{
    font-weight: 900;
    color: var(--ink);
  }
  .grand .r{
    font-weight: 900;
    color: var(--ink);
    white-space: nowrap;
  }
</style>
@endpush

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
          <div class="card c-card">
            <div class="c-head"><h4>Data Pengiriman</h4></div>
            <div class="c-body">

              <form method="POST" action="{{ route('transactions.store') }}">
                @csrf

                <div class="form-group">
                  <div class="label-soft">Nama Penerima</div>
                  <input type="text" name="customer_name"
                         class="form-control input-soft @error('customer_name') is-invalid @enderror"
                         value="{{ old('customer_name', auth()->user()->name) }}" required>
                  @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                  <div class="label-soft">No. HP</div>
                  <input type="text" name="customer_phone"
                         class="form-control input-soft @error('customer_phone') is-invalid @enderror"
                         value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" required
                         placeholder="Contoh: 62812xxxxxxx">
                  @error('customer_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                  <div class="label-soft">Alamat Lengkap</div>
                  <textarea name="shipping_address" rows="4"
                            class="form-control textarea-soft @error('shipping_address') is-invalid @enderror"
                            placeholder="Contoh: Jl. xxx, Kecamatan, Kota, Provinsi, Kode Pos" required>{{ old('shipping_address') }}</textarea>
                  @error('shipping_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                  <div class="label-soft">Catatan (Opsional)</div>
                  <textarea name="notes" rows="3" class="form-control textarea-soft"
                            placeholder="Contoh: titip ke satpam">{{ old('notes') }}</textarea>
                </div>

                <div class="d-flex flex-wrap" style="gap:10px;">
                  <button class="btn btn-accent" type="submit">
                    <i class="fas fa-receipt"></i> Buat Transaksi & Lanjut Bayar
                  </button>

                  <a href="{{ route('shop.cart.index') }}" class="btn btn-ghost">
                    <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
                  </a>
                </div>

              </form>

            </div>
          </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="col-lg-5">
          <div class="card c-card">
            <div class="c-head"><h4>Ringkasan</h4></div>
            <div class="c-body">

              @foreach($cart->items as $item)
                @php $p = $item->product; @endphp
                <div class="sum-item">
                  <div>
                    <div class="sum-name">{{ $p->name }}</div>
                    <div class="sum-meta">
                      Qty: <b>{{ $item->qty }}</b>
                      <span class="mx-1">•</span>
                      Size: <b>{{ $item->size ?? '-' }}</b>
                    </div>
                  </div>
                  <div class="sum-price">
                    Rp {{ number_format($item->price * $item->qty,0,',','.') }}
                  </div>
                </div>
              @endforeach

              <div class="totals">
                <div class="total-row">
                  <div>Subtotal</div>
                  <div><b>Rp {{ number_format($subtotal,0,',','.') }}</b></div>
                </div>

                {{-- kalau nanti ada ongkir, tinggal hidupkan --}}
                {{-- <div class="total-row">
                  <div>Ongkir</div>
                  <div><b>Rp 0</b></div>
                </div> --}}

                <div class="grand">
                  <div class="l">Total</div>
                  <div class="r">Rp {{ number_format($subtotal,0,',','.') }}</div>
                </div>

                <div class="text-muted mt-2" style="font-size:12px;">
                  Pastikan data pengiriman sudah benar sebelum lanjut pembayaran.
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
@endsection
