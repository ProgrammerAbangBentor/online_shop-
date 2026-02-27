@extends('layouts.app')
@section('title', 'Status Pembayaran')

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

  .f-card{
    border: 1px solid var(--stroke);
    border-radius: 18px;
    box-shadow: var(--shadow-soft);
    overflow:hidden;
  }

  .f-head{
    padding: 16px;
    background: rgba(17,24,39,.02);
    border-bottom: 1px solid rgba(17,24,39,.06);
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
  }

  .f-title{
    margin:0;
    font-weight: 900;
    color: var(--ink);
    font-size: 16px;
    letter-spacing: .2px;
  }

  .f-sub{
    margin-top:6px;
    color: var(--muted);
    font-size: 12px;
  }

  .pill{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding: 8px 12px;
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

  .f-body{ padding: 16px; }

  .hero{
    border-radius: 18px;
    padding: 14px 14px;
    border: 1px solid rgba(17,24,39,.06);
    background: rgba(17,24,39,.015);
  }

  .hero h5{
    margin:0;
    font-weight: 900;
    color: var(--ink);
  }
  .hero p{
    margin:6px 0 0;
    color: var(--muted);
    font-size: 13px;
  }

  .info-grid{
    margin-top: 14px;
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
    word-break: break-word;
  }

  .total-box{
    margin-top: 14px;
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

  .section-card{
    margin-top: 14px;
    border: 1px solid rgba(17,24,39,.06);
    border-radius: 18px;
    overflow:hidden;
    background: #fff;
  }
  .section-card .sec-head{
    padding: 12px 14px;
    background: rgba(17,24,39,.02);
    border-bottom: 1px solid rgba(17,24,39,.06);
    font-weight: 900;
    color: var(--ink);
  }
  .section-card .sec-body{
    padding: 14px;
  }

  .item-row{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(17,24,39,.06);
  }
  .item-row:last-child{ border-bottom: none; }

  .item-name{
    font-weight: 900;
    color: var(--ink);
    font-size: 13px;
    line-height: 1.2;
  }
  .item-meta{
    margin-top: 6px;
    font-size: 12px;
    color: var(--muted);
  }
  .item-price{
    font-weight: 900;
    color: var(--ink);
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

  .btn-wa{
    background: #16a34a;
    border: none;
    border-radius: 14px;
    height: 44px;
    font-weight: 900;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding: 0 16px;
    box-shadow: 0 10px 18px rgba(22,163,74,.18);
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
      <h1>Status Pembayaran</h1>
    </div>

    <div class="section-body">
      <div class="card f-card">
        <div class="f-body">

          @php
            $isPaid    = ($status ?? 'pending') === 'paid';
            $isPending = ($status ?? 'pending') === 'pending';
            $isFailed  = in_array(($status ?? 'pending'), ['failed','expired','cancelled']);

            // Data transaksi dari controller
            $t = $trx ?? null;

            $customerName  = $t->customer_name ?? '-';
            $customerPhone = $t->customer_phone ?? '-';
            $customerEmail = $t->customer_email ?? '-';
            $address       = $t->shipping_address ?? '-';
            $notes         = $t->notes ?? '-';

            // list item untuk pesan WA
            $itemsText = '';
            if ($t && $t->items && $t->items->count()) {
              foreach ($t->items as $i) {
                $itemsText .= "- {$i->product_name}";
                if (!empty($i->size)) $itemsText .= " (Size: {$i->size})";
                $itemsText .= " | Qty: {$i->qty}";
                $itemsText .= " | Harga: Rp " . number_format($i->price,0,',','.');
                $itemsText .= " | Subtotal: Rp " . number_format($i->subtotal,0,',','.') . "\n";
              }
            } else {
              $itemsText = "- (Item tidak ditemukan)\n";
            }

            $orderIdText = $order_id ?? '-';
            $statusMidtransText = $transaction_status ?? '-';
            $paymentTypeText = $payment_type ?? '-';
            $grandTotalText = isset($grand_total) ? number_format($grand_total,0,',','.') : '0';

            $waMessage =
              "📦 *ORDER BARU (TRI COLLECTION)*\n\n".
              "*Order ID:* {$orderIdText}\n".
              "*Status Sistem:* ".strtoupper($status ?? 'pending')."\n".
              "*Status Midtrans:* {$statusMidtransText}\n".
              "*Metode:* {$paymentTypeText}\n".
              "*Total:* Rp {$grandTotalText}\n\n".
              "👤 *Data Customer*\n".
              "*Nama:* {$customerName}\n".
              "*HP:* {$customerPhone}\n".
              "*Email:* {$customerEmail}\n\n".
              "🏠 *Alamat Pengiriman*\n{$address}\n\n".
              "📝 *Catatan*\n{$notes}\n\n".
              "🛒 *Item*\n{$itemsText}\n".
              "—\nMohon diproses ya 🙏";

            $waUrl = !empty($adminPhone)
              ? "https://wa.me/{$adminPhone}?text=" . urlencode($waMessage)
              : '#';

            $pillClass = $isPaid ? 'pill-ok' : ($isFailed ? 'pill-bad' : 'pill-warn');
            $titleText = $isPaid ? 'Pembayaran Berhasil 🎉' : ($isFailed ? 'Pembayaran Gagal ❌' : 'Menunggu Pembayaran ⏳');
            $descText  = $isPaid
              ? 'Pesanan kamu sudah kami terima. Kamu bisa kirim detail order ke admin untuk diproses.'
              : ($isFailed
                ? 'Pembayaran tidak berhasil. Silakan coba ulang atau pilih metode pembayaran lain.'
                : 'Jika kamu baru saja membayar, tunggu sebentar. Status akan diperbarui otomatis setelah notifikasi Midtrans diterima.');
          @endphp

          {{-- HERO STATUS --}}
          <div class="hero">
            <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
              <h5>{{ $titleText }}</h5>
              <span class="pill {{ $pillClass }}">
                <i class="fas {{ $isPaid ? 'fa-check-circle' : ($isFailed ? 'fa-times-circle' : 'fa-clock') }}"></i>
                {{ strtoupper($status ?? 'pending') }}
              </span>
            </div>
            <p>{{ $descText }}</p>
          </div>

          {{-- INFO --}}
          <div class="info-grid">
            <div class="info-box">
              <div class="info-label">Order ID</div>
              <div class="info-value">{{ $order_id ?? '-' }}</div>
            </div>

            <div class="info-box">
              <div class="info-label">Status Midtrans</div>
              <div class="info-value">{{ $transaction_status ?? '-' }}</div>
            </div>

            <div class="info-box">
              <div class="info-label">Metode Pembayaran</div>
              <div class="info-value">{{ $payment_type ?? '-' }}</div>
            </div>

            <div class="info-box">
              <div class="info-label">Status Sistem</div>
              <div class="info-value">{{ strtoupper($status ?? 'pending') }}</div>
            </div>
          </div>

          <div class="total-box">
            <div class="l">Total Pembayaran</div>
            <div class="r">Rp {{ number_format($grand_total ?? 0,0,',','.') }}</div>
          </div>

          <div class="text-muted mt-2" style="font-size:12px;">
            Status final akan diperbarui otomatis setelah notifikasi dari Midtrans diterima sistem.
          </div>

          {{-- DATA PENGIRIMAN --}}
          @if($trx)
            <div class="section-card">
              <div class="sec-head">
                <i class="fas fa-truck"></i> Data Pengiriman
              </div>
              <div class="sec-body">
                <div class="info-grid" style="margin-top:0;">
                  <div class="info-box">
                    <div class="info-label">Nama</div>
                    <div class="info-value">{{ $trx->customer_name }}</div>
                  </div>
                  <div class="info-box">
                    <div class="info-label">No. HP</div>
                    <div class="info-value">{{ $trx->customer_phone }}</div>
                  </div>
                  <div class="info-box">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $trx->customer_email }}</div>
                  </div>
                  <div class="info-box">
                    <div class="info-label">Catatan</div>
                    <div class="info-value">{{ $trx->notes ?? '-' }}</div>
                  </div>
                </div>

                <div class="info-box" style="margin-top:12px;">
                  <div class="info-label">Alamat</div>
                  <div class="info-value">{!! nl2br(e($trx->shipping_address)) !!}</div>
                </div>
              </div>
            </div>

            {{-- ITEM PESANAN --}}
            <div class="section-card">
              <div class="sec-head">
                <i class="fas fa-shopping-bag"></i> Item Pesanan
              </div>
              <div class="sec-body">
                @foreach($trx->items as $it)
                  <div class="item-row">
                    <div>
                      <div class="item-name">{{ $it->product_name }}</div>
                      <div class="item-meta">
                        Size: <b>{{ $it->size ?? '-' }}</b>
                        <span class="mx-1">•</span>
                        Qty: <b>{{ $it->qty }}</b>
                      </div>
                    </div>
                    <div class="item-price">
                      Rp {{ number_format($it->subtotal,0,',','.') }}
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- ACTIONS --}}
          <div class="action-row">
            <a href="{{ route('transactions.index') }}" class="btn btn-accent">
              <i class="fas fa-history"></i> Riwayat Transaksi
            </a>

            {{-- ✅ Tombol WhatsApp Admin: hanya tampil kalau PAID --}}
            @if($isPaid)
              @if(!empty($adminPhone))
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-wa">
                  <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp Admin
                </a>
              @else
                <button class="btn btn-ghost" disabled>
                  Admin belum ada nomor
                </button>
              @endif
            @endif

            @if(!$isPaid)
              <a href="{{ route('transactions.index') }}" class="btn btn-ghost">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            @endif
          </div>

        </div>
      </div>
    </div>
  </section>
</div>
@endsection
