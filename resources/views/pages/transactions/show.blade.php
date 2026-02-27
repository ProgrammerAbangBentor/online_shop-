@extends('layouts.app')
@section('title', 'Detail Transaksi')

@push('style')
<style>
  :root{
    --ink:#111827;
    --muted:#6b7280;
    --stroke: rgba(17,24,39,.08);
    --shadow-soft: 0 10px 22px rgba(17,24,39,.08);

    --accent:#ec4899;
    --accent-2:#f472b6;
  }

  .t-card{
    border: 1px solid var(--stroke);
    border-radius: 18px;
    box-shadow: var(--shadow-soft);
    overflow:hidden;
  }

  .t-head{
    padding: 16px 16px;
    background: rgba(17,24,39,.02);
    border-bottom: 1px solid rgba(17,24,39,.06);
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
  }

  .t-title{
    margin:0;
    font-weight: 900;
    color: var(--ink);
    font-size: 16px;
    letter-spacing: .2px;
  }
  .t-sub{
    margin-top:6px;
    font-size: 12px;
    color: var(--muted);
  }

  .pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 900;
    border: 1px solid rgba(17,24,39,.08);
    background: rgba(17,24,39,.03);
    color: var(--ink);
    white-space: nowrap;
  }
  .pill-ok{
    background: rgba(16,185,129,.14);
    border-color: rgba(16,185,129,.22);
    color:#065f46;
  }
  .pill-warn{
    background: rgba(245,158,11,.14);
    border-color: rgba(245,158,11,.22);
    color:#7c2d12;
  }
  .pill-bad{
    background: rgba(239,68,68,.14);
    border-color: rgba(239,68,68,.22);
    color:#7f1d1d;
  }

  .t-body{ padding: 16px; }

  .info-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  @media (max-width: 767px){
    .info-grid{ grid-template-columns: 1fr; }
  }

  .info-box{
    border: 1px solid rgba(17,24,39,.06);
    border-radius: 16px;
    padding: 12px;
    background: rgba(17,24,39,.015);
  }
  .info-label{
    font-size: 12px;
    color: var(--muted);
    font-weight: 800;
    letter-spacing: .3px;
    margin-bottom: 6px;
  }
  .info-value{
    font-weight: 900;
    color: var(--ink);
  }

  .total-box{
    margin-top: 12px;
    border-radius: 16px;
    padding: 14px 14px;
    background: rgba(236,72,153,.08);
    border: 1px solid rgba(236,72,153,.16);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
  }
  .total-box .l{
    color: var(--muted);
    font-weight: 800;
    font-size: 12px;
    letter-spacing: .3px;
  }
  .total-box .r{
    font-weight: 900;
    color: var(--ink);
    font-size: 18px;
    white-space: nowrap;
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
    padding: 0 16px;
  }
  .btn-accent:hover{ filter: brightness(.98); }

  .btn-ghost{
    background: rgba(17,24,39,.04);
    border: 1px solid rgba(17,24,39,.08);
    border-radius: 14px;
    height: 44px;
    font-weight: 900;
    color: var(--ink);
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding: 0 14px;
  }

  .action-row{
    margin-top: 14px;
    display:flex;
    gap:10px;
    flex-wrap: wrap;
  }
</style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Transaksi #{{ $transaction->order_id }}</h1>
    </div>

    <div class="section-body">
      @include('layouts.alert')

      @php
        $isPaid = ($transaction->status ?? '') === 'paid';

        $mid = strtolower((string) ($transaction->transaction_status ?? ''));

        // pill midtrans status (simple mapping)
        $midPillClass = 'pill-warn';
        if (in_array($mid, ['settlement','capture','paid','success'])) $midPillClass = 'pill-ok';
        if (in_array($mid, ['deny','cancel','expired','failure','failed'])) $midPillClass = 'pill-bad';

        $appPillClass = $isPaid ? 'pill-ok' : 'pill-warn';
      @endphp

      <div class="card t-card">

        <div class="t-head">
          <div>
            <div class="t-title">Detail Pembayaran</div>
            <div class="t-sub">
              Simpan nomor transaksi ini untuk pengecekan: <b>#{{ $transaction->order_id }}</b>
            </div>
          </div>

          <div style="display:flex; gap:8px; flex-wrap:wrap; justify-content:flex-end;">
            <span class="pill {{ $appPillClass }}">
              <i class="fas {{ $isPaid ? 'fa-check-circle' : 'fa-clock' }}"></i>
              {{ $transaction->status }}
            </span>
            <span class="pill {{ $midPillClass }}">
              <i class="fas fa-credit-card"></i>
              midtrans: {{ $transaction->transaction_status ?? '-' }}
            </span>
          </div>
        </div>

        <div class="t-body">

          <div class="info-grid">
            <div class="info-box">
              <div class="info-label">Order ID</div>
              <div class="info-value">{{ $transaction->order_id }}</div>
            </div>

            <div class="info-box">
              <div class="info-label">Status Aplikasi</div>
              <div class="info-value">{{ $transaction->status }}</div>
            </div>

            <div class="info-box">
              <div class="info-label">Status Midtrans</div>
              <div class="info-value">{{ $transaction->transaction_status ?? '-' }}</div>
            </div>

            <div class="info-box">
              <div class="info-label">Catatan</div>
              <div class="info-value">{{ $transaction->notes ?? '-' }}</div>
            </div>
          </div>

          <div class="total-box">
            <div class="l">Total Pembayaran</div>
            <div class="r">Rp {{ number_format($transaction->grand_total,0,',','.') }}</div>
          </div>

          <div class="action-row">
            @if(!$isPaid)
              <button id="pay-button" class="btn btn-accent" type="button">
                <i class="fas fa-wallet"></i> Bayar Sekarang
              </button>
            @else
              <div class="alert alert-success mb-0" style="border-radius:14px; width:100%;">
                <b>Pembayaran sudah lunas.</b> Terima kasih 🙌
              </div>
            @endif

            <a href="{{ route('shop.products.index') }}" class="btn btn-ghost">
              <i class="fas fa-store"></i> Kembali Belanja
            </a>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

{{-- Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
  document.getElementById('pay-button')?.addEventListener('click', function () {
    snap.pay(@json($transaction->snap_token), {
      onSuccess: function(result){
        window.location.href = @json(route('transactions.finish')) + "?order_id=" + encodeURIComponent(@json($transaction->order_id));
      },
      onPending: function(result){
        window.location.href = @json(route('transactions.finish')) + "?order_id=" + encodeURIComponent(@json($transaction->order_id));
      },
      onError: function(result){
        alert('Pembayaran gagal. Silakan coba lagi.');
      },
      onClose: function(){
        // user menutup popup
      }
    });
  });
</script>
@endsection
