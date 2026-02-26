@extends('layouts.app')

@section('title', 'Data Pelanggan')

@push('style')
  <!-- ✅ Modern Soft Pink UI (Customers Index) - mengikuti base style kamu -->
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

    /* Toolbar (search + info) */
    .customers-toolbar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 12px;
      flex-wrap: wrap;
    }
    .customers-toolbar .left,
    .customers-toolbar .right{
      display:flex;
      align-items:center;
      gap: 10px;
      flex-wrap: wrap;
    }

    /* Search */
    .customers-search .form-control{
      border-radius: 12px;
      border: 1px solid rgba(236,72,153,.20);
      box-shadow: 0 10px 20px rgba(17,24,39,.06);
      height: 42px;
      min-width: 260px;
    }
    .customers-search .btn{
      border-radius: 12px;
      height: 42px;
      padding: 0 14px;
      font-weight: 700;
      border: 1px solid rgba(236,72,153,.25);
      background: linear-gradient(135deg, rgba(236,72,153,.95), rgba(244,114,182,.95));
      box-shadow: 0 12px 24px rgba(236,72,153,.18);
    }
    .customers-search .btn.btn-light{
      background: #fff !important;
      border: 1px solid rgba(236,72,153,.20) !important;
      box-shadow: 0 10px 20px rgba(17,24,39,.06);
      font-weight: 800;
    }

    /* Table */
    .customers-table{
      border-collapse: separate !important;
      border-spacing: 0 10px !important;
    }
    .customers-table thead th{
      border: 0 !important;
      color: var(--muted);
      font-weight: 800;
      letter-spacing: .3px;
      text-transform: uppercase;
      font-size: 12px;
      padding: 10px 12px;
      white-space: nowrap;
    }
    .customers-table tbody tr{
      background: #fff;
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
      border-radius: 14px;
      transition: .18s ease;
    }
    .customers-table tbody tr:hover{
      transform: translateY(-2px);
      box-shadow: 0 16px 26px rgba(17,24,39,.09);
    }
    .customers-table tbody td{
      border-top: 1px solid rgba(236,72,153,.10) !important;
      border-bottom: 1px solid rgba(236,72,153,.10) !important;
      padding: 12px 12px !important;
      vertical-align: middle;
      color: var(--ink);
    }
    .customers-table tbody tr td:first-child{
      border-left: 1px solid rgba(236,72,153,.10) !important;
      border-top-left-radius: 14px;
      border-bottom-left-radius: 14px;
      font-weight: 800;
      width: 70px;
      white-space: nowrap;
    }
    .customers-table tbody tr td:last-child{
      border-right: 1px solid rgba(236,72,153,.10) !important;
      border-top-right-radius: 14px;
      border-bottom-right-radius: 14px;
    }

    /* Mini pill info */
    .mini-pill{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding: 7px 10px;
      border-radius: 999px;
      font-weight: 800;
      font-size: 12px;
      background: rgba(236,72,153,.10);
      border: 1px solid rgba(236,72,153,.18);
      color: rgba(190,24,93,1);
      white-space: nowrap;
    }

    /* Numbers */
    .num-strong{ font-weight: 900; }
    .money{ font-weight: 900; letter-spacing: .1px; }

    /* Pagination spacing */
    .pagination{ margin-top: 14px; }
  </style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Data Pelanggan</h1>

      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Pelanggan</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Daftar Pelanggan</h2>
      <p class="section-lead">Pantau pelanggan berdasarkan total pesanan, total belanja, dan terakhir order.</p>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <h4>Daftar Pelanggan</h4>

              <div class="customers-toolbar">
                <div class="left">
                  <span class="mini-pill">
                    <i class="fas fa-users"></i>
                    Total: {{ $customers->total() ?? count($customers) }}
                  </span>

                  @if(!empty($q))
                    <span class="mini-pill" style="background: rgba(59,130,246,.10); border-color: rgba(59,130,246,.18); color: rgba(29,78,216,1);">
                      <i class="fas fa-search"></i>
                      Pencarian: "{{ $q }}"
                    </span>
                  @endif
                </div>

                <div class="right">
                  <form method="GET" action="{{ route('customers.index') }}" class="customers-search">
                    <div class="input-group">
                      <input type="text"
                             name="q"
                             value="{{ $q ?? '' }}"
                             class="form-control"
                             placeholder="Cari nama / email / hp...">
                      <div class="input-group-append" style="display:flex; gap:8px;">
                        <button class="btn btn-primary" type="submit">
                          <i class="fas fa-search"></i>
                        </button>

                        @if(!empty($q))
                          <a href="{{ route('customers.index') }}" class="btn btn-light">
                            Reset
                          </a>
                        @endif
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="card-body p-0">
              <div class="table-responsive" style="padding: 0 12px 12px;">
                <table class="table customers-table mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th style="min-width:220px;">Nama</th>
                      <th style="min-width:240px;">Kontak</th>
                      <th class="text-center" style="min-width:140px;">Total Pesanan</th>
                      <th class="text-right" style="min-width:170px;">Total Belanja</th>
                      <th style="min-width:210px;">Terakhir Order</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($customers as $i => $c)
                      @php
                        $no    = $customers->firstItem() + $i;
                        $nama  = $c->customer_name ?: '—';
                        $email = $c->customer_email ?: '—';
                        $phone = $c->customer_phone ?: '—';
                        $spent = (int)($c->total_spent ?? 0);

                        $last  = $c->last_order_at ? \Illuminate\Support\Carbon::parse($c->last_order_at) : null;
                      @endphp
                      <tr>
                        <td>{{ $no }}</td>

                        <td style="font-weight:900;">
                          {{ $nama }}
                        </td>

                        <td>
                          <div style="font-weight:800;">{{ $email }}</div>
                          <div style="color:var(--muted); font-size:12px;">
                            {{ $phone }}
                          </div>
                        </td>

                        <td class="text-center">
                          <span class="num-strong">{{ (int)($c->total_orders ?? 0) }}</span>
                        </td>

                        <td class="text-right">
                          <span class="money">Rp{{ number_format($spent, 0, ',', '.') }}</span>
                        </td>

                        <td>
                          @if($last)
                            <div style="font-weight:800;">{{ $last->format('d M Y') }}</div>
                            <div style="color:var(--muted); font-size:12px;">{{ $last->format('H:i') }}</div>
                          @else
                            —
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center" style="color:var(--muted); padding:22px !important;">
                          Belum ada pelanggan.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div class="d-flex justify-content-end" style="padding: 0 18px 18px;">
                {{ $customers->withQueryString()->links() }}
              </div>

            </div>

          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
