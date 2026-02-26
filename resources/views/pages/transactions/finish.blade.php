@extends('layouts.app')
@section('title', 'Status Pembayaran')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Status Pembayaran</h1>
    </div>

    <div class="section-body">
      <div class="card">
        <div class="card-body">

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

            // pesan whatsapp
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

            // url whatsapp (nomor admin dari controller)
            $waUrl = !empty($adminPhone)
              ? "https://wa.me/{$adminPhone}?text=" . urlencode($waMessage)
              : '#';
          @endphp

          <div class="alert
            {{ $isPaid ? 'alert-success' : '' }}
            {{ $isPending ? 'alert-warning' : '' }}
            {{ $isFailed ? 'alert-danger' : '' }}">

            <h5 class="mb-3">
              {{ $isPaid ? 'Pembayaran Berhasil 🎉' : '' }}
              {{ $isPending ? 'Menunggu Pembayaran ⏳' : '' }}
              {{ $isFailed ? 'Pembayaran Gagal ❌' : '' }}
            </h5>

            <div><b>Order ID:</b> {{ $order_id ?? '-' }}</div>
            <div><b>Status Sistem:</b> {{ strtoupper($status ?? 'pending') }}</div>
            <div><b>Status Midtrans:</b> {{ $transaction_status ?? '-' }}</div>
            <div><b>Metode Pembayaran:</b> {{ $payment_type ?? '-' }}</div>
            <div><b>Total Pembayaran:</b> Rp {{ number_format($grand_total ?? 0,0,',','.') }}</div>

            <div class="text-muted small mt-3">
              Status final akan diperbarui otomatis setelah notifikasi dari Midtrans diterima sistem.
            </div>
          </div>

          {{-- Ringkasan customer & alamat --}}
          @if($trx)
            <div class="card mt-3">
              <div class="card-body">
                <h6 class="mb-3"><b>Data Pengiriman</b></h6>
                <div><b>Nama:</b> {{ $trx->customer_name }}</div>
                <div><b>HP:</b> {{ $trx->customer_phone }}</div>
                <div><b>Email:</b> {{ $trx->customer_email }}</div>
                <div class="mt-2"><b>Alamat:</b><br>{{ $trx->shipping_address }}</div>
                @if($trx->notes)
                  <div class="mt-2"><b>Catatan:</b><br>{{ $trx->notes }}</div>
                @endif
              </div>
            </div>

            <div class="card mt-3">
              <div class="card-body">
                <h6 class="mb-3"><b>Item Pesanan</b></h6>
                @foreach($trx->items as $it)
                  <div class="d-flex justify-content-between">
                    <div>
                      <b>{{ $it->product_name }}</b>
                      <div class="text-muted small">
                        Size: {{ $it->size ?? '-' }} | Qty: {{ $it->qty }}
                      </div>
                    </div>
                    <div>
                      Rp {{ number_format($it->subtotal,0,',','.') }}
                    </div>
                  </div>
                  <hr class="my-2">
                @endforeach
              </div>
            </div>
          @endif

          <div class="mt-3">
            <a href="{{ route('transactions.index') }}" class="btn btn-primary">
              Lihat Riwayat Transaksi
            </a>

            {{-- ✅ Tombol WhatsApp Admin: hanya tampil kalau PAID --}}
            @if($isPaid)
              @if(!empty($adminPhone))
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-success ml-2">
                  <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp Admin
                </a>
              @else
                <button class="btn btn-secondary ml-2" disabled>
                  Admin belum ada nomor
                </button>
              @endif
            @endif

            @if(!$isPaid)
              <a href="{{ route('transactions.index') }}" class="btn btn-light ml-2">
                Kembali
              </a>
            @endif
          </div>

        </div>
      </div>
    </div>
  </section>
</div>
@endsection
