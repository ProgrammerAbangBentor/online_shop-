<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Penjualan</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#111827; }
    .title { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
    .sub { color:#6b7280; margin-bottom: 12px; }
    .grid { width:100%; margin-bottom: 12px; }
    .card { border:1px solid #e5e7eb; padding:10px; border-radius:8px; }
    table { width:100%; border-collapse: collapse; }
    th, td { border:1px solid #e5e7eb; padding:8px; }
    th { background:#f9fafb; text-align:left; }
    .right { text-align:right; }
  </style>
</head>
<body>
  <div class="title">Laporan Penjualan</div>
  <div class="sub">Periode: {{ $start }} s/d {{ $end }}</div>

  <table class="grid">
    <tr>
      <td class="card">
        <b>Total Pesanan</b><br>{{ $totalPesanan }}
      </td>
      <td class="card">
        <b>Total Pendapatan</b><br>Rp {{ number_format($totalPendapatan,0,',','.') }}
      </td>
      <td class="card">
        <b>Produk Terjual</b><br>{{ $produkTerjual }}
      </td>
      <td class="card">
        <b>Jumlah Pelanggan</b><br>{{ $jumlahPelanggan }}
      </td>
    </tr>
  </table>

  <table>
    <thead>
      <tr>
        <th style="width:40px;">No</th>
        <th>Tanggal</th>
        <th>Order ID</th>
        <th>Pelanggan</th>
        <th>Metode</th>
        <th>Status</th>
        <th class="right">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($transactions as $i => $trx)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ optional($trx->created_at)->format('d M Y H:i') }}</td>
          <td>{{ $trx->order_id ?? '-' }}</td>
          <td>
            <b>{{ $trx->customer_name ?? '-' }}</b><br>
            <span style="color:#6b7280">{{ $trx->customer_email ?? '-' }}</span>
          </td>
          <td>{{ $trx->payment_type ?? '-' }}</td>
          <td>{{ $trx->transaction_status ?? '-' }}</td>
          <td class="right">Rp {{ number_format($trx->grand_total ?? 0,0,',','.') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div style="margin-top:10px; color:#6b7280;">
    Dicetak: {{ now()->format('d M Y H:i') }}
  </div>
</body>
</html>
