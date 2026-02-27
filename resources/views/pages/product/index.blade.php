@extends('layouts.app')

@section('title', 'Products')

@push('style')
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

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
.section-header-button .btn{
  border-radius: 12px;
  padding: .55rem .9rem;
  font-weight: 800;
  border: 1px solid rgba(236,72,153,.25);
  background: linear-gradient(135deg, rgba(236,72,153,.95), rgba(244,114,182,.95));
  box-shadow: 0 12px 24px rgba(236,72,153,.18);
}
.section-header-button .btn:hover{ transform: translateY(-1px); }
.section-header-breadcrumb .breadcrumb-item a{
  color: var(--muted);
  text-decoration: none;
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
.prod-toolbar{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 12px;
}
.prod-toolbar .right{
  display:flex; align-items:center; gap:10px; flex-wrap:wrap;
}

/* Search */
.prod-search .form-control{
  border-radius: 12px;
  border: 1px solid rgba(236,72,153,.20);
  box-shadow: 0 10px 20px rgba(17,24,39,.06);
  height: 42px;
  min-width: 260px;
}
.prod-search .btn{
  border-radius: 12px;
  height: 42px;
  padding: 0 14px;
  font-weight: 800;
  border: 1px solid rgba(236,72,153,.25);
  background: linear-gradient(135deg, rgba(236,72,153,.95), rgba(244,114,182,.95));
  box-shadow: 0 12px 24px rgba(236,72,153,.18);
}

/* Table */
.prod-table{
  border-collapse: separate !important;
  border-spacing: 0 10px !important;
}
.prod-table thead th{
  border: 0 !important;
  color: var(--muted);
  font-weight: 900;
  letter-spacing: .3px;
  text-transform: uppercase;
  font-size: 12px;
  padding: 10px 12px;
  white-space: nowrap;
}
.prod-table tbody tr{
  background: #fff;
  box-shadow: 0 10px 18px rgba(17,24,39,.06);
  border-radius: 14px;
  transition: .18s ease;
}
.prod-table tbody tr:hover{
  transform: translateY(-2px);
  box-shadow: 0 16px 26px rgba(17,24,39,.09);
}
.prod-table tbody td{
  border-top: 1px solid rgba(236,72,153,.10) !important;
  border-bottom: 1px solid rgba(236,72,153,.10) !important;
  padding: 12px 12px !important;
  vertical-align: middle;
  color: var(--ink);
  white-space: nowrap;
}
.prod-table tbody tr td:first-child{
  border-left: 1px solid rgba(236,72,153,.10) !important;
  border-top-left-radius: 14px;
  border-bottom-left-radius: 14px;
  font-weight: 900;
}
.prod-table tbody tr td:last-child{
  border-right: 1px solid rgba(236,72,153,.10) !important;
  border-top-right-radius: 14px;
  border-bottom-right-radius: 14px;
}

/* Image */
.thumb{
  width: 62px;
  height: 62px;
  border-radius: 14px;
  object-fit: cover;
  border: 1px solid rgba(236,72,153,.18);
  box-shadow: 0 10px 18px rgba(17,24,39,.06);
  background:#fff;
}
.no-image{
  display:inline-flex; align-items:center; gap:6px;
  padding: 6px 10px;
  border-radius: 999px;
  font-weight: 900;
  font-size: 12px;
  background: rgba(239,68,68,.10);
  border: 1px solid rgba(239,68,68,.18);
  color: rgba(185,28,28,1);
}

/* Stock pill */
.stock-pill{
  display:inline-flex; align-items:center; gap:6px;
  padding: 6px 10px;
  border-radius: 999px;
  font-weight: 900;
  font-size: 12px;
  border: 1px solid rgba(236,72,153,.18);
  background: rgba(236,72,153,.08);
  color: rgba(190,24,93,1);
}
.stock-pill.is-low{
  background: rgba(245,158,11,.10);
  border-color: rgba(245,158,11,.18);
  color: rgba(180,83,9,1);
}
.stock-pill.is-out{
  background: rgba(239,68,68,.10);
  border-color: rgba(239,68,68,.18);
  color: rgba(185,28,28,1);
}

/* Actions */
.btn-action{
  border-radius: 12px !important;
  padding: .45rem .75rem !important;
  font-weight: 900 !important;
  border: 1px solid rgba(236,72,153,.15) !important;
  box-shadow: 0 10px 18px rgba(17,24,39,.06);
}
.btn-action.btn-info{
  background: rgba(59,130,246,.10) !important;
  color: rgba(29,78,216,1) !important;
  border-color: rgba(59,130,246,.18) !important;
}
.btn-action.btn-danger{
  background: rgba(239,68,68,.10) !important;
  color: rgba(185,28,28,1) !important;
  border-color: rgba(239,68,68,.18) !important;
}
.btn-action:hover{ transform: translateY(-1px); }

.pagination{ margin-top: 14px; }
</style>
@endpush

@section('main')
<div class="main-content">
<section class="section">

  <div class="section-header">
    <h1>Products</h1>

    <div class="section-header-button">
      <a href="{{ route('product.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Add New
      </a>
    </div>

    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Product</a></div>
      <div class="breadcrumb-item">All Product</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        @include('layouts.alert')
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card">

          <div class="card-header">
            <h4>All Products</h4>
            <div style="color: var(--muted); font-weight:800;">
              Total: {{ $products->total() ?? count($products) }}
            </div>
          </div>

          <div class="card-body">

            <div class="prod-toolbar">
              <div></div>

              <div class="right">
                <form method="GET" action="{{ route('product.index') }}" class="prod-search">
                  <div class="input-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Search product..."
                           name="name"
                           value="{{ request('name') }}">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table prod-table">
                <thead>
                  <tr>
                    <th style="min-width:220px;">Name</th>
                    <th style="min-width:200px;">Category</th>
                    <th style="min-width:140px;">Price</th>
                    <th style="min-width:120px;">Size</th>
                    <th style="min-width:120px;">Stock</th>
                    <th style="min-width:120px;">Photo</th>
                    <th style="min-width:220px;" class="text-center">Action</th>
                  </tr>
                </thead>

                <tbody>
                  @forelse ($products as $product)
                    @php
                      $img = $product->image ? asset('storage/products/'.$product->image) : null;
                      $stock = (int) ($product->stock ?? 0);
                      $stockClass = $stock <= 0 ? 'is-out' : ($stock <= 5 ? 'is-low' : '');
                    @endphp

                    <tr>
                      <td style="font-weight:900;">
                        {{ $product->name }}
                      </td>

                      <td>
                        <div style="font-weight:800;">{{ $product->category_name ?? '-' }}</div>
                      </td>

                      <td style="font-weight:900;">
                        Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                      </td>

                      <td>{{ $product->size ?? '-' }}</td>

                      <td>
                        <span class="stock-pill {{ $stockClass }}">
                          <i class="fas fa-cube" style="font-size:12px;"></i>
                          {{ $stock }}
                        </span>
                      </td>

                      <td>
                        @if($img)
                          <img src="{{ $img }}" alt="{{ $product->name }}" class="thumb">
                        @else
                          <span class="no-image"><i class="fas fa-image"></i> No Image</span>
                        @endif
                      </td>

                      <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap:8px; flex-wrap:wrap;">
                          <a href="{{ route('product.edit', $product->id) }}"
                             class="btn btn-sm btn-info btn-icon btn-action">
                            <i class="fas fa-edit mr-1"></i> Edit
                          </a>

                          <form action="{{ route('product.destroy', $product->id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger btn-icon btn-action">
                              <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="text-center" style="color:var(--muted); padding:22px !important;">
                        No products found.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-end">
              {{ $products->withQueryString()->links() }}
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
