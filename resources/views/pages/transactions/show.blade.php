@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Transaksi #{{ $transaction->order_id }}</h1>
    </div>

    <div class="section-body">
      @include('layouts.alert')

      <div class="card">
        <div class="card-body">
          <p><b>Status:</b> {{ $transaction->status }} (midtrans: {{ $transaction->transaction_status }})</p>
          <p><b>Total:</b> Rp {{ number_format($transaction->grand_total,0,',','.') }}</p>

          @if($transaction->status !== 'paid')
            <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
          @else
            <div class="alert alert-success mb-0">Pembayaran sudah lunas.</div>
          @endif
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
    snap.pay("{{ $transaction->snap_token }}", {
      onSuccess: function(result){ window.location.href = "{{ route('transactions.finish') }}?order_id={{ $transaction->order_id }}"; },
      onPending: function(result){ window.location.href = "{{ route('transactions.finish') }}?order_id={{ $transaction->order_id }}"; },
      onError: function(result){ alert('Pembayaran gagal.'); },
      onClose: function(){ /* user menutup popup */ }
    });
  });
</script>
@endsection
