@extends('layouts.app')
@section('title', 'Transaksi Saya')

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
    padding: 14px 16px;
    background: rgba(17,24,39,.02);
    border-bottom: 1px solid rgba(17,24,39,.06);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    flex-wrap: wrap;
  }

  .t-title{
    margin:0;
    font-weight: 900;
    color: var(--ink);
    font-size: 14px;
    letter-spacing: .2px;
  }

  .t-sub{
    color: var(--muted);
    font-size: 12px;
    margin-top: 4px;
  }

  .t-body{ padding: 0; }

  .table-clean{ margin:0; }
  .table-clean thead th{
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
  .table-clean tbody td{
    border-top: 0 !important;
    border-bottom: 1px solid rgba(17,24,39,.06);
    padding: 14px 14px;
    vertical-align: middle;
  }

  .oid{
    font-weight: 900;
    color: var(--ink);
    letter-spacing: .2px;
    white-space: nowrap;
  }

  .money{
    font-weight: 900;
    color: var(--ink);
    white-space: nowrap;
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

  .mid{
    margin-top: 6px;
    font-size: 12px;
    color: var(--muted);
  }

  .btn-accent{
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    border:none;
    border-radius: 12px;
    height: 38px;
    font-weight: 900;
    box-shadow: 0 10px 18px rgba(236,72,153,.20);
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding: 0 12px;
  }
  .btn-ghost{
    background: rgba(17,24,39,.04);
    border: 1px solid rgba(17,24,39,.08);
    border-radius: 12px;
    height: 38px;
    font-weight: 900;
    color: var(--ink);
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding: 0 12px;
  }
  .btn-pay{
    background: #16a34a;
    border:none;
    border-radius: 12px;
    height: 38px;
    font-weight: 900;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding: 0 12px;
    box-shadow: 0 10px 16px rgba(22,163,74,.16);
  }

  .empty-wrap{
    border: 1px dashed rgba(17,24,39,.18);
    border-radius: 18px;
    padding: 18px;
    background: rgba(17,24,39,.02);
    margin: 16px;
  }
</style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Transaksi Saya</h1>
    </div>

    <div class="section-body">
      @include('layouts.alert')

      <div class="card t-card">

        <div class="t-head">
          <div>
            <div class="t-title">Riwayat Transaksi</div>
            <div class="t-sub">Lihat detail transaksi dan lanjut pembayaran jika masih pending.</div>
          </div>
          <a href="{{ route('shop.products.index') }}" class="btn btn-ghost">
            <i class="fas fa-store"></i> Belanja Lagi
          </a>
        </div>

        <div class="t-body">

          @if($items->count() === 0)
            <div class="empty-wrap">
              <div style="font-weight:900; color:var(--ink); font-size:16px;">Belum ada transaksi</div>
              <div style="color:var(--muted); font-size:13px; margin-top:6px;">
                Setelah checkout, transaksi kamu akan muncul di sini.
              </div>
              <div class="mt-3">
                <a href="{{ route('shop.products.index') }}" class="btn btn-accent">
                  <i class="fas fa-bag-shopping"></i> Mulai Belanja
                </a>
              </div>
            </div>
          @else
            <div class="table-responsive">
              <table class="table table-clean">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $t)
                    @php
                      $st = strtolower((string) ($t->status ?? 'pending'));
                      $pill = 'pill-warn';
                      $icon = 'fa-clock';

                      if ($st === 'paid') { $pill = 'pill-ok'; $icon = 'fa-check-circle'; }
                      if (in_array($st, ['failed','expired','cancelled'])) { $pill = 'pill-bad'; $icon = 'fa-times-circle'; }
                    @endphp

                    <tr>
                      <td class="oid">{{ $t->order_id }}</td>
                      <td style="white-space:nowrap;">
                        {{ optional($t->created_at)->format('d M Y') }}
                        <div class="mid">{{ optional($t->created_at)->format('H:i') }}</div>
                      </td>
                      <td class="money">Rp {{ number_format($t->grand_total,0,',','.') }}</td>
                      <td>
                        <span class="pill {{ $pill }}">
                          <i class="fas {{ $icon }}"></i> {{ strtoupper($t->status) }}
                        </span>
                        <div class="mid">midtrans: {{ $t->transaction_status ?? '-' }}</div>
                      </td>
                      <td class="text-right" style="white-space:nowrap;">
                        <a href="{{ route('transactions.show', $t->id) }}" class="btn btn-accent">
                          <i class="fas fa-eye"></i> Detail
                        </a>

                        @if($t->status === 'pending' && $t->snap_token)
                          <a href="{{ route('transactions.show', $t->id) }}" class="btn btn-pay ml-1">
                            <i class="fas fa-wallet"></i> Bayar
                          </a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="p-3">
              {{ $items->links() }}
            </div>
          @endif

        </div>
      </div>

    </div>
  </section>
</div>
@endsection
