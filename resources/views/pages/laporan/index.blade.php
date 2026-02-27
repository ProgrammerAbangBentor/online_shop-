@extends('layouts.app')

@section('title', 'Laporan')

@push('style')
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

  <!-- ✅ Modern Soft Pink UI (Laporan) - ngikut base Users -->
  <style>
    :root{
      --pink-50:#fff1f5;
      --pink-100:#ffe4ec;
      --pink-200:#fecddc;
      --pink-300:#fda4c1;
      --pink-500:#ec4899;

      --ink:#1f2937;
      --muted:#6b7280;

      --card:#ffffff;
      --stroke: rgba(236,72,153,.14);
      --shadow: 0 18px 40px rgba(17,24,39,.08);
      --shadow-soft: 0 10px 24px rgba(17,24,39,.08);
      --radius:18px;
    }

    /* Header */
    .section-header{
      background: linear-gradient(135deg, var(--pink-50), #fff);
      border: 1px solid var(--stroke);
      border-radius: var(--radius);
      box-shadow: var(--shadow-soft);
      padding: 18px 18px;
      margin-bottom: 18px;
    }
    .section-header h1{
      color: var(--ink);
      font-weight: 800;
      letter-spacing: .2px;
      margin-bottom: 0;
    }
    .section-header-breadcrumb .breadcrumb-item a{
      color: var(--muted);
      text-decoration: none;
    }

    /* Lead */
    .section-title{
      font-weight: 800;
      color: var(--ink);
      margin-top: 8px;
    }
    .section-lead{
      color: var(--muted);
      margin-bottom: 14px;
    }

    /* Card */
    .card{
      border: 1px solid var(--stroke) !important;
      border-radius: var(--radius) !important;
      box-shadow: var(--shadow);
      overflow: hidden;
      background: var(--card);
    }
    .card-header{
      background: linear-gradient(135deg, var(--pink-50), #fff);
      border-bottom: 1px solid var(--stroke) !important;
      padding: 16px 18px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 12px;
      flex-wrap: wrap;
    }
    .card-header h4{
      margin: 0;
      font-weight: 800;
      color: var(--ink);
      letter-spacing: .2px;
    }
    .card-body{ padding: 18px; }

    /* Toolbar */
    .report-toolbar{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap: 12px;
      flex-wrap: wrap;
      margin-bottom: 14px;
    }
    .report-toolbar .left,
    .report-toolbar .right{
      display:flex;
      align-items:flex-end;
      gap: 10px;
      flex-wrap: wrap;
    }

    /* Input */
    .report-toolbar label{
      font-size: 12px;
      font-weight: 800;
      color: var(--muted);
      margin-bottom: 6px;
    }
    .report-toolbar .form-control{
      border-radius: 12px;
      border: 1px solid rgba(236,72,153,.20);
      box-shadow: 0 10px 20px rgba(17,24,39,.06);
      height: 42px;
      min-width: 200px;
    }

    /* Buttons */
    .btn-soft{
      border-radius: 12px !important;
      height: 42px;
      padding: 0 14px !important;
      font-weight: 800 !important;
      border: 1px solid rgba(236,72,153,.25) !important;
      box-shadow: 0 12px 24px rgba(236,72,153,.18);
      background: linear-gradient(135deg, rgba(236,72,153,.95), rgba(244,114,182,.95)) !important;
      color: #fff !important;
    }
    .btn-soft:hover{ transform: translateY(-1px); }
    .btn-soft-light{
      border-radius: 12px !important;
      height: 42px;
      padding: 0 14px !important;
      font-weight: 800 !important;
      border: 1px solid rgba(236,72,153,.20) !important;
      background: rgba(236,72,153,.06) !important;
      color: rgba(190,24,93,1) !important;
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
    }

    /* Summary cards */
    .sum-grid{
      display:grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 12px;
      margin-bottom: 14px;
    }
    @media(max-width: 992px){
      .sum-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media(max-width: 520px){
      .sum-grid{ grid-template-columns: 1fr; }
    }
    .sum-card{
      border: 1px solid rgba(236,72,153,.14);
      border-radius: 16px;
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
      background: linear-gradient(135deg, #fff, var(--pink-50));
      padding: 14px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 10px;
    }
    .sum-card .label{
      color: var(--muted);
      font-weight: 800;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: .25px;
    }
    .sum-card .value{
      color: var(--ink);
      font-weight: 900;
      font-size: 18px;
      margin-top: 2px;
    }
    .sum-badge{
      width: 42px;
      height: 42px;
      border-radius: 14px;
      display:flex;
      align-items:center;
      justify-content:center;
      background: rgba(236,72,153,.10);
      border: 1px solid rgba(236,72,153,.18);
      color: rgba(190,24,93,1);
      flex: 0 0 auto;
    }

    /* Table */
    .report-table{
      border-collapse: separate !important;
      border-spacing: 0 10px !important;
    }
    .report-table thead th{
      border: 0 !important;
      color: var(--muted);
      font-weight: 800;
      letter-spacing: .3px;
      text-transform: uppercase;
      font-size: 12px;
      padding: 10px 12px;
      white-space: nowrap;
    }
    .report-table tbody tr{
      background: #fff;
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
      border-radius: 14px;
      transition: .18s ease;
    }
    .report-table tbody tr:hover{
      transform: translateY(-2px);
      box-shadow: 0 16px 26px rgba(17,24,39,.09);
    }
    .report-table tbody td{
      border-top: 1px solid rgba(236,72,153,.10) !important;
      border-bottom: 1px solid rgba(236,72,153,.10) !important;
      padding: 12px 12px !important;
      vertical-align: middle;
      color: var(--ink);
      white-space: nowrap;
    }
    .report-table tbody tr td:first-child{
      border-left: 1px solid rgba(236,72,153,.10) !important;
      border-top-left-radius: 14px;
      border-bottom-left-radius: 14px;
      font-weight: 900;
    }
    .report-table tbody tr td:last-child{
      border-right: 1px solid rgba(236,72,153,.10) !important;
      border-top-right-radius: 14px;
      border-bottom-right-radius: 14px;
    }

    /* Status pill */
    .status-pill{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 900;
      font-size: 12px;
      border: 1px solid rgba(236,72,153,.18);
      background: rgba(236,72,153,.08);
      color: rgba(190,24,93,1);
      text-transform: lowercase;
    }
    .status-pill.is-success{
      background: rgba(16,185,129,.10);
      border-color: rgba(16,185,129,.18);
      color: rgba(4,120,87,1);
    }
    .status-pill.is-warning{
      background: rgba(245,158,11,.10);
      border-color: rgba(245,158,11,.18);
      color: rgba(180,83,9,1);
    }
    .status-pill.is-danger{
      background: rgba(239,68,68,.10);
      border-color: rgba(239,68,68,.18);
      color: rgba(185,28,28,1);
    }

    /* Pagination spacing */
    .pagination{ margin-top: 14px; }
  </style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Laporan</h1>

      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Laporan</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Laporan</h2>
      <p class="section-lead">Ringkasan dan rekap data penjualan berdasarkan periode.</p>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <h4>Laporan Penjualan</h4>

              {{-- mini info --}}
              <div style="color: var(--muted); font-weight:800;">
                Menampilkan: {{ $transactions->count() }} / {{ $transactions->total() }}
              </div>
            </div>

            <div class="card-body">

              {{-- TOOLBAR FILTER --}}
              <form method="GET" action="{{ route('laporan.index') }}" class="report-toolbar">
                <div class="left">
                  <div>
                    <label>Periode Awal</label>
                    <input type="date" name="start_date" value="{{ $start }}" class="form-control">
                  </div>

                  <div>
                    <label>Periode Akhir</label>
                    <input type="date" name="end_date" value="{{ $end }}" class="form-control">
                  </div>

                  <div>
                    <button class="btn btn-soft" type="submit">
                      <i class="fas fa-search mr-1"></i> Tampilkan
                    </button>
                  </div>

                  <div>
                    <a class="btn btn-soft-light" href="{{ route('laporan.index') }}">
                      Reset
                    </a>
                  </div>
                </div>

                <div class="right">
                    <a class="btn btn-soft-light"
                        href="{{ route('laporan.export.excel', request()->only(['start_date','end_date'])) }}">
                        <i class="fas fa-file-excel mr-1"></i> Export Excel
                    </a>

                    <a class="btn btn-soft-light" target="_blank"
                        href="{{ route('laporan.export.pdf', request()->only(['start_date','end_date'])) }}">
                        <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
                    </a>
                </div>
              </form>

              {{-- RINGKASAN --}}
              <div class="sum-grid">
                <div class="sum-card">
                  <div>
                    <div class="label">Total Pesanan</div>
                    <div class="value">{{ $totalPesanan }}</div>
                  </div>
                  <div class="sum-badge"><i class="fas fa-receipt"></i></div>
                </div>

                <div class="sum-card">
                  <div>
                    <div class="label">Total Pendapatan</div>
                    <div class="value">Rp {{ number_format($totalPendapatan,0,',','.') }}</div>
                  </div>
                  <div class="sum-badge"><i class="fas fa-coins"></i></div>
                </div>

                <div class="sum-card">
                  <div>
                    <div class="label">Produk Terjual</div>
                    <div class="value">{{ $produkTerjual }}</div>
                  </div>
                  <div class="sum-badge"><i class="fas fa-box"></i></div>
                </div>

                <div class="sum-card">
                  <div>
                    <div class="label">Jumlah Pelanggan</div>
                    <div class="value">{{ $jumlahPelanggan }}</div>
                  </div>
                  <div class="sum-badge"><i class="fas fa-user-friends"></i></div>
                </div>
              </div>

              {{-- TABLE --}}
              <div class="table-responsive">
                <table class="table report-table">
                  <thead>
                    <tr>
                      <th style="min-width:70px;">No</th>
                      <th style="min-width:150px;">Tanggal</th>
                      <th style="min-width:160px;">Order ID</th>
                      <th style="min-width:200px;">Nama Pelanggan</th>
                      <th style="min-width:120px;">Total</th>
                      <th style="min-width:150px;">Metode</th>
                      <th style="min-width:150px;">Status</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($transactions as $trx)
                      @php
                        $created = $trx->created_at ? \Illuminate\Support\Carbon::parse($trx->created_at) : null;

                        $st = strtolower($trx->transaction_status ?? '');
                        $pill = 'status-pill';
                        if(in_array($st, ['settlement','capture'])) $pill .= ' is-success';
                        elseif($st === 'pending') $pill .= ' is-warning';
                        elseif(in_array($st, ['deny','cancel','expire','expired','failure','failed'])) $pill .= ' is-danger';
                      @endphp

                      <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                          <div style="font-weight:800;">
                            {{ $created ? $created->format('d M Y') : '-' }}
                          </div>
                          <div style="color:var(--muted); font-size:12px;">
                            {{ $created ? $created->format('H:i') : '' }}
                          </div>
                        </td>

                        <td style="font-weight:900;">
                          {{ $trx->order_id ?? '-' }}
                        </td>

                        <td>
                          <div style="font-weight:800;">{{ $trx->customer_name ?? '-' }}</div>
                          <div style="color:var(--muted); font-size:12px;">
                            {{ $trx->customer_email ?? '-' }}
                          </div>
                        </td>

                        <td style="font-weight:900;">
                          Rp {{ number_format($trx->grand_total ?? 0,0,',','.') }}
                        </td>

                        <td>
                          {{ $trx->payment_type ?? '-' }}
                        </td>

                        <td>
                          <span class="{{ $pill }}">
                            <i class="fas fa-circle" style="font-size:8px;"></i>
                            {{ $trx->transaction_status ?? '-' }}
                          </span>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center" style="color:var(--muted); padding:22px !important;">
                          Tidak ada data laporan pada periode ini.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div class="d-flex justify-content-end">
                {{ $transactions->withQueryString()->links() }}
              </div>

            </div>{{-- card-body --}}
          </div>{{-- card --}}
        </div>
      </div>

    </div>
  </section>
</div>
@endsection

@push('scripts')
  <!-- JS Libraries -->
  <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
