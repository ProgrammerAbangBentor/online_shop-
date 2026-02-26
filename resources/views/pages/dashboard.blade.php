@extends('layouts.app')

@section('title', 'OnlineShop')

@push('style')
  <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">

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
      --radius: 18px;
    }

    .dash-wrap{
      position: relative;
      padding: 2px 0 8px;
    }
    .dash-wrap::before{
      content:"";
      position:absolute;
      inset: -24px -24px auto -24px;
      height: 260px;
      background:
        radial-gradient(900px 220px at 10% 0%, rgba(236,72,153,.18), transparent 55%),
        radial-gradient(700px 220px at 90% 10%, rgba(253,164,193,.22), transparent 60%),
        linear-gradient(180deg, rgba(255,241,245,.95), rgba(255,255,255,0));
      pointer-events:none;
      z-index:0;
      border-radius: 24px;
    }

    .dash-wrap > *{ position: relative; z-index: 1; }

    .dash-title{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:12px;
      margin-bottom: 14px;
    }
    .dash-title h1{
      margin:0;
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -.2px;
      color: var(--ink);
    }
    .dash-sub{
      margin: 2px 0 0;
      font-size: 13px;
      color: var(--muted);
    }

    .card-soft{
      border: 1px solid var(--stroke) !important;
      border-radius: var(--radius) !important;
      background: var(--card);
      box-shadow: var(--shadow-soft);
      overflow: hidden;
    }
    .card-soft .card-header{
      background: transparent;
      border-bottom: 1px solid rgba(236,72,153,.10);
      padding: 14px 16px;
    }
    .card-soft .card-header h4{
      margin:0;
      font-size: 14px;
      font-weight: 800;
      color: var(--ink);
    }
    .card-soft .card-body{
      padding: 14px 16px;
    }

    .stat-card{
      padding: 14px 14px;
      border-radius: var(--radius);
      border: 1px solid var(--stroke);
      background:
        linear-gradient(180deg, rgba(255,241,245,.9), rgba(255,255,255,.95));
      box-shadow: var(--shadow-soft);
      display:flex;
      gap: 12px;
      align-items: center;
      min-height: 92px;
      transition: transform .15s ease, box-shadow .15s ease;
    }
    .stat-card:hover{
      transform: translateY(-2px);
      box-shadow: var(--shadow);
    }
    .stat-ico{
      width: 46px;
      height: 46px;
      border-radius: 14px;
      display:flex;
      align-items:center;
      justify-content:center;
      background: linear-gradient(135deg, rgba(236,72,153,.18), rgba(253,164,193,.28));
      border: 1px solid rgba(236,72,153,.18);
      flex: 0 0 auto;
    }
    .stat-ico i{
      font-size: 18px;
      color: #b4236c;
    }
    .stat-meta{
      line-height: 1.1;
      min-width: 0;
    }
    .stat-meta .label{
      font-size: 12px;
      color: var(--muted);
      font-weight: 700;
      margin-bottom: 6px;
      display:block;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .stat-meta .value{
      font-size: 22px;
      font-weight: 900;
      color: var(--ink);
      letter-spacing: -.3px;
    }

    .table-soft{ margin:0; }
    .table-soft thead th{
      border-top: 0 !important;
      border-bottom: 1px solid rgba(236,72,153,.12) !important;
      color: #374151;
      font-size: 12px;
      font-weight: 900;
      letter-spacing: .1px;
      padding: 12px 14px;
      background: rgba(255,241,245,.55);
    }
    .table-soft tbody td{
      padding: 12px 14px;
      border-top: 1px solid rgba(236,72,153,.10);
      vertical-align: middle;
      font-size: 13px;
      color: #111827;
    }
    .name-cell{ display:flex; gap:10px; align-items:center; }
    .avatar-dot{
      width: 36px; height: 36px; border-radius: 14px;
      background: linear-gradient(135deg, rgba(236,72,153,.22), rgba(253,164,193,.35));
      border: 1px solid rgba(236,72,153,.18);
      display:flex; align-items:center; justify-content:center;
      font-weight: 900; color:#9d174d;
      flex:0 0 auto;
      text-transform: uppercase;
    }
    .subtxt{ font-size: 12px; color: var(--muted); margin-top: 2px; }
    .pill{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding: 6px 10px;
      border-radius: 999px;
      border: 1px solid rgba(236,72,153,.18);
      background: rgba(255,241,245,.7);
      color:#9d174d;
      font-size: 12px;
      font-weight: 800;
      white-space: nowrap;
    }

    .stock-item{
      display:flex;
      gap: 12px;
      align-items:center;
      padding: 12px 12px;
      border-radius: 16px;
      border: 1px solid rgba(236,72,153,.12);
      background: rgba(255,241,245,.35);
    }
    .stock-item + .stock-item{ margin-top: 10px; }
    .stock-thumb{
      width: 44px;
      height: 44px;
      border-radius: 14px;
      background: #fff;
      border: 1px solid rgba(236,72,153,.14);
      display:flex;
      align-items:center;
      justify-content:center;
      overflow:hidden;
      flex:0 0 auto;
    }
    .stock-thumb img{ width:100%; height:100%; object-fit: cover; }
    .stock-meta{ min-width:0; }
    .stock-meta .title{
      font-weight: 900;
      font-size: 13px;
      margin:0;
      color:#111827;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 100%;
    }
    .stock-meta .desc{
      margin: 2px 0 0;
      font-size: 12px;
      color: var(--muted);
    }
    .badge-soft{
      margin-left:auto;
      padding: 6px 10px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 900;
      border: 1px solid rgba(236,72,153,.18);
      background: rgba(255,241,245,.85);
      color:#9d174d;
      white-space: nowrap;
    }
    .badge-soft.is-danger{
      border-color: rgba(244,63,94,.22);
      background: rgba(255,228,236,.85);
      color: #be123c;
    }

    @media (max-width: 575.98px){
      .dash-title{ flex-direction: column; align-items:flex-start; }
      .stat-meta .value{ font-size: 20px; }
    }
  </style>
@endpush

@section('main')
  <div class="main-content">
    <section class="section">
      <div class="dash-wrap">
        <div class="dash-title">
          <div>
            <h1>Dashboard - OnlineShop</h1>
            <p class="dash-sub">Ringkasan performa toko dan aktivitas terbaru.</p>
          </div>
        </div>

        {{-- TOP STATS --}}
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
            <div class="stat-card">
              <div class="stat-ico"><i class="fas fa-box-open"></i></div>
              <div class="stat-meta">
                <span class="label">Total Produk</span>
                <div class="value">{{ $totalProduk ?? 0 }}</div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
            <div class="stat-card">
              <div class="stat-ico"><i class="fas fa-receipt"></i></div>
              <div class="stat-meta">
                <span class="label">Total Pesanan</span>
                <div class="value">{{ $totalPesanan ?? 0 }}</div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
            <div class="stat-card">
              <div class="stat-ico"><i class="fas fa-users"></i></div>
              <div class="stat-meta">
                <span class="label">Total Pelanggan</span>
                <div class="value">{{ $totalPelanggan ?? 0 }}</div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
            <div class="stat-card">
              <div class="stat-ico"><i class="fas fa-wallet"></i></div>
              <div class="stat-meta">
                <span class="label">Total Penjualan</span>
                <div class="value">Rp{{ number_format((int)($totalPenjualan ?? 0), 0, ',', '.') }}</div>
              </div>
            </div>
          </div>
        </div>

        {{-- MAIN GRID --}}
        <div class="row">
          {{-- Pesanan Terbaru (DINAMIS) --}}
          <div class="col-lg-8 col-md-12 col-12 mb-3">
            <div class="card card-soft">
              <div class="card-header">
                <h4>Pesanan Terbaru</h4>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-soft">
                    <thead>
                      <tr>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Pesanan</th>
                        <th class="text-right">Total Belanja</th>
                      </tr>
                    </thead>

                    <tbody>
                      @forelse($pesananTerbaru as $t)
                        @php
                          $nama = $t->customer_name ?? optional($t->user)->name ?? 'Pelanggan';
                          $inisial = strtoupper(substr($nama, 0, 1));
                          $kode = $t->order_id ?? ('TRX-' . $t->id);
                          $tgl = $t->paid_at ?? $t->created_at;
                          $total = $t->grand_total ?? (($t->subtotal ?? 0) + ($t->shipping_cost ?? 0));
                        @endphp

                        <tr>
                          <td>
                            <div class="name-cell">
                              <div class="avatar-dot">{{ $inisial }}</div>
                              <div>
                                <div style="font-weight:900;">{{ $nama }}</div>
                                <div class="subtxt">{{ $kode }}</div>
                              </div>
                            </div>
                          </td>

                          <td>
                            <span class="pill">
                              <i class="far fa-clock"></i>
                              {{ optional($tgl)->format('d M Y H:i') }}
                            </span>
                          </td>

                          <td class="text-right" style="font-weight:900;">
                            Rp{{ number_format((int)$total, 0, ',', '.') }}
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="3" class="text-center text-muted" style="padding:18px;">
                            Belum ada pesanan.
                          </td>
                        </tr>
                      @endforelse
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>

          {{-- Informasi Stok (DINAMIS) --}}
          <div class="col-lg-4 col-md-12 col-12 mb-3">
            <div class="card card-soft">
              <div class="card-header">
                <h4>Informasi Stok</h4>
              </div>
              <div class="card-body">

                <div style="font-weight:900; color:#374151; margin-bottom:10px;">Produk Stok Menipis</div>

                @forelse ($stokMenipis as $p)
                  <div class="stock-item">
                    <div class="stock-thumb">
                      <img src="{{ $p->image ? asset('storage/products/'.$p->image) : asset('img/products/product-1-50.png') }}"
                           alt="{{ $p->name }}">
                    </div>
                    <div class="stock-meta">
                      <p class="title">{{ $p->name }}</p>
                      <p class="desc">Sisa stok</p>
                    </div>
                    <div class="badge-soft">{{ (int) $p->stock }} item</div>
                  </div>
                @empty
                  <div class="text-muted">Tidak ada stok menipis 🎉</div>
                @endforelse

                <div style="height:14px;"></div>

                <div style="font-weight:900; color:#374151; margin-bottom:10px;">Produk Habis</div>

                @forelse ($stokHabis as $p)
                  <div class="stock-item">
                    <div class="stock-thumb">
                      <img src="{{ $p->image ? asset('storage/products/'.$p->image) : asset('img/products/product-3-50.png') }}"
                           alt="{{ $p->name }}">
                    </div>
                    <div class="stock-meta">
                      <p class="title">{{ $p->name }}</p>
                      <p class="desc">Stok kosong</p>
                    </div>
                    <div class="badge-soft is-danger">0 item</div>
                  </div>
                @empty
                  <div class="text-muted">Tidak ada produk habis.</div>
                @endforelse

              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
  <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
  <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
@endpush
