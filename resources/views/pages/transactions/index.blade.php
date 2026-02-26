@extends('layouts.app')
@section('title', 'Transaksi Saya')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Transaksi Saya</h1>
    </div>

    <div class="section-body">
      @include('layouts.alert')

      <div class="card">
        <div class="card-body">

          @if($items->count() === 0)
            <div class="alert alert-warning mb-0">Belum ada transaksi.</div>
          @else
            <div class="table-responsive">
              <table class="table table-striped">
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
                    <tr>
                      <td><b>{{ $t->order_id }}</b></td>
                      <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                      <td>Rp {{ number_format($t->grand_total,0,',','.') }}</td>
                      <td>
                        <span class="badge
                          {{ $t->status === 'paid' ? 'badge-success' : '' }}
                          {{ $t->status === 'pending' ? 'badge-warning' : '' }}
                          {{ in_array($t->status, ['failed','expired','cancelled']) ? 'badge-danger' : '' }}">
                          {{ strtoupper($t->status) }}
                        </span>
                        <div class="text-muted small">
                          midtrans: {{ $t->transaction_status }}
                        </div>
                      </td>
                      <td class="text-right">

                        {{-- Detail --}}
                        <a href="{{ route('transactions.show', $t->id) }}"
                           class="btn btn-sm btn-primary">
                          Detail
                        </a>

                        {{-- Tombol Bayar jika pending --}}
                        @if($t->status === 'pending' && $t->snap_token)
                          <a href="{{ route('transactions.show', $t->id) }}"
                             class="btn btn-sm btn-success ml-1">
                             Bayar
                          </a>
                        @endif

                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="mt-3">
              {{ $items->links() }}
            </div>
          @endif

        </div>
      </div>

    </div>
  </section>
</div>
@endsection
