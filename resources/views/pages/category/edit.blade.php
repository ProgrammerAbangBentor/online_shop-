@extends('layouts.app')

@section('title', 'Edit Category')

@push('style')
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

  <!-- ✅ Modern Soft Pink UI (Category Edit) -->
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
    .card-footer{
      background: #fff;
      border-top: 1px solid rgba(236,72,153,.12) !important;
      padding: 14px 18px;
    }

    /* Form */
    .form-group label{
      font-weight: 900;
      color: var(--muted);
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: .25px;
    }
    .form-control{
      border-radius: 12px;
      border: 1px solid rgba(236,72,153,.20);
      box-shadow: 0 10px 20px rgba(17,24,39,.06);
      height: 44px;
    }
    textarea.form-control{ height: auto; }
    .form-control:focus{
      border-color: rgba(236,72,153,.35);
      box-shadow: 0 0 0 .2rem rgba(236,72,153,.12);
    }

    /* Buttons */
    .btn-soft{
      border-radius: 12px !important;
      padding: .6rem 1rem !important;
      font-weight: 900 !important;
      border: 1px solid rgba(236,72,153,.25) !important;
      background: linear-gradient(135deg, rgba(236,72,153,.95), rgba(244,114,182,.95)) !important;
      box-shadow: 0 12px 24px rgba(236,72,153,.18);
      color: #fff !important;
    }
    .btn-soft:hover{ transform: translateY(-1px); }

    .btn-soft-light{
      border-radius: 12px !important;
      padding: .6rem 1rem !important;
      font-weight: 900 !important;
      border: 1px solid rgba(236,72,153,.20) !important;
      background: rgba(236,72,153,.06) !important;
      color: rgba(190,24,93,1) !important;
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
    }

    /* Image preview */
    .preview-wrap{
      border: 1px dashed rgba(236,72,153,.28);
      background: linear-gradient(135deg, #fff, var(--pink-50));
      border-radius: 16px;
      padding: 12px;
      display:flex;
      align-items:center;
      gap: 12px;
    }
    .thumb{
      width: 86px;
      height: 86px;
      border-radius: 16px;
      object-fit: cover;
      border: 1px solid rgba(236,72,153,.18);
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
      background: #fff;
      flex: 0 0 auto;
    }
    .no-image{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 900;
      font-size: 12px;
      background: rgba(239,68,68,.10);
      border: 1px solid rgba(239,68,68,.18);
      color: rgba(185,28,28,1);
      white-space: nowrap;
    }
    .help{
      color: var(--muted);
      font-weight: 700;
      font-size: 12px;
      margin-top: 6px;
    }
  </style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Edit Category</h1>

      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Category</a></div>
        <div class="breadcrumb-item">Edit</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Category</h2>
      <p class="section-lead">Ubah data kategori (nama, deskripsi, dan foto).</p>

      <div class="card">
        <form action="{{ route('category.update', $categories->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="card-header">
            <h4>Edit Data</h4>

            <a href="{{ route('category.index') }}" class="btn btn-soft-light">
              <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
          </div>

          <div class="card-body">
            <div class="row">

              <div class="col-lg-7">
                <div class="form-group">
                  <label>Name</label>
                  <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ old('name', $categories->name) }}"
                    placeholder="Contoh: Dress, Hijab, Kemeja..."
                  >
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <input
                    type="text"
                    class="form-control @error('description') is-invalid @enderror"
                    name="description"
                    value="{{ old('description', $categories->description) }}"
                    placeholder="Deskripsi singkat kategori..."
                  >
                  @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group">
                  <label>Photo Category</label>
                  <input
                    type="file"
                    class="form-control @error('image') is-invalid @enderror"
                    name="image"
                    accept="image/*"
                  >
                  @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="help">Format disarankan: JPG/PNG. Ukuran ideal: 600x600.</div>
                </div>
              </div>

              <div class="col-lg-5">
                <div class="form-group">
                  <label>Current Photo</label>

                  @php
                    $img = $categories->image ? asset('storage/categories/'.$categories->image) : null;
                  @endphp

                  <div class="preview-wrap">
                    @if($img)
                      <img src="{{ $img }}" class="thumb" alt="{{ $categories->name }}">
                    @else
                      <span class="no-image"><i class="fas fa-image"></i> No Image</span>
                    @endif

                    <div>
                      <div style="font-weight:900; color: var(--ink);">
                        {{ $categories->name }}
                      </div>
                      <div style="color: var(--muted); font-weight:700; font-size:12px;">
                        Foto akan diganti jika kamu upload file baru.
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>

          <div class="card-footer d-flex justify-content-end" style="gap:10px; flex-wrap:wrap;">
            <a href="{{ route('category.index') }}" class="btn btn-soft-light">
              Cancel
            </a>
            <button class="btn btn-soft" type="submit">
              <i class="fas fa-save mr-1"></i> Update
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>
</div>
@endsection

@push('scripts')
  <!-- (optional) taruh script kalau mau preview image live -->
@endpush
