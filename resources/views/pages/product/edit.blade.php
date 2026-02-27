@extends('layouts.app')

@section('title', 'Edit Product')

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

.section-header{
  background: linear-gradient(135deg, var(--pink-50), #fff);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  box-shadow: var(--shadow-soft);
  padding: 18px;
  margin-bottom: 18px;
}
.section-header h1{ font-weight:800; color:var(--ink); }

.card{
  border:1px solid var(--stroke) !important;
  border-radius:var(--radius) !important;
  box-shadow:var(--shadow);
  overflow:hidden;
  background:#fff;
}
.card-header{
  background:linear-gradient(135deg,var(--pink-50),#fff);
  border-bottom:1px solid var(--stroke) !important;
  padding:16px 18px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:12px;
  flex-wrap:wrap;
}
.card-header h4{ margin:0; font-weight:800; }
.card-body{ padding:18px; }
.card-footer{
  border-top:1px solid rgba(236,72,153,.15);
  background:#fff;
  padding:14px 18px;
}

.form-group label, .form-label{
  font-size:12px;
  font-weight:900;
  text-transform:uppercase;
  color:var(--muted);
  letter-spacing:.25px;
}
.form-control{
  border-radius:12px;
  border:1px solid rgba(236,72,153,.20);
  box-shadow:0 10px 20px rgba(17,24,39,.06);
  height:44px;
}
.form-control:focus{
  border-color:rgba(236,72,153,.35);
  box-shadow:0 0 0 .2rem rgba(236,72,153,.12);
}

.btn-soft{
  border-radius:12px !important;
  padding:.6rem 1rem !important;
  font-weight:900 !important;
  border:1px solid rgba(236,72,153,.25) !important;
  background:linear-gradient(135deg,rgba(236,72,153,.95),rgba(244,114,182,.95)) !important;
  box-shadow:0 12px 24px rgba(236,72,153,.18);
  color:#fff !important;
}
.btn-soft-light{
  border-radius:12px !important;
  padding:.6rem 1rem !important;
  font-weight:900 !important;
  border:1px solid rgba(236,72,153,.20) !important;
  background:rgba(236,72,153,.06) !important;
  color:rgba(190,24,93,1) !important;
  box-shadow:0 10px 18px rgba(17,24,39,.06);
}

.preview-box{
  border:1px dashed rgba(236,72,153,.28);
  background:linear-gradient(135deg,#fff,var(--pink-50));
  border-radius:16px;
  padding:12px;
  display:flex;
  align-items:center;
  gap:12px;
}
.preview-img{
  width:90px; height:90px;
  border-radius:16px;
  object-fit:cover;
  border:1px solid rgba(236,72,153,.18);
  box-shadow:0 10px 18px rgba(17,24,39,.06);
}
.preview-new{
  display:none;
  width:90px; height:90px;
  border-radius:16px;
  object-fit:cover;
  border:1px solid rgba(236,72,153,.18);
  box-shadow:0 10px 18px rgba(17,24,39,.06);
}
.help{ font-size:12px; font-weight:700; color:var(--muted); margin-top:6px; }
</style>
@endpush

@section('main')
<div class="main-content">
<section class="section">

  <div class="section-header">
    <h1>Edit Product</h1>
  </div>

  <div class="section-body">
    <h2 class="section-title">Products</h2>
    <p class="section-lead" style="color:var(--muted);">Ubah data produk (nama, harga, stok, ukuran, kategori, foto).</p>

    <div class="card">
      <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-header">
          <h4>Edit Data</h4>
          <a href="{{ route('product.index') }}" class="btn btn-soft-light">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>

        <div class="card-body">
          <div class="row">

            <div class="col-lg-7">
              <div class="form-group">
                <label>Name</label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="name"
                       value="{{ old('name', $product->name) }}"
                       placeholder="Nama produk...">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="form-group">
                <label>Price</label>
                <input type="number"
                       class="form-control @error('price') is-invalid @enderror"
                       name="price"
                       value="{{ old('price', $product->price) }}"
                       placeholder="Harga...">
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="form-group">
                <label>Stock</label>
                <input type="number"
                       class="form-control @error('stock') is-invalid @enderror"
                       name="stock"
                       value="{{ old('stock', $product->stock) }}"
                       placeholder="Stok...">
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="form-group">
                <label class="form-label">Ukuran</label>
                <input type="text"
                       name="size"
                       class="form-control"
                       placeholder="Contoh: S / M / L / XL atau 40"
                       value="{{ old('size', $product->size ?? '') }}">
              </div>

              <div class="form-group">
                <label class="form-label">Category</label>
                <select class="form-control selectric @error('category_id') is-invalid @enderror" name="category_id">
                  <option value="">-- Select Category --</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (int)$product->category_id === (int)$category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="form-group">
                <label>Photo Product</label>
                <input type="file"
                       class="form-control @error('image') is-invalid @enderror"
                       name="image"
                       id="imageInput"
                       accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="help">Upload foto baru jika ingin mengganti.</div>
              </div>
            </div>

            <div class="col-lg-5">
              <div class="form-group">
                <label>Current / Preview</label>

                @php
                  $img = $product->image ? asset('storage/products/'.$product->image) : null;
                @endphp

                <div class="preview-box">
                  @if($img)
                    <img src="{{ $img }}" class="preview-img" alt="{{ $product->name }}">
                  @else
                    <img src="{{ asset('assets/img/default-product.png') }}" class="preview-img" alt="No Image">
                  @endif

                  <img id="previewNew" class="preview-new" alt="Preview New">

                  <div>
                    <div style="font-weight:900; color:var(--ink);">{{ $product->name }}</div>
                    <div style="font-weight:700; color:var(--muted); font-size:12px;">
                      Preview akan muncul saat pilih file.
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>

        <div class="card-footer d-flex justify-content-end" style="gap:10px;">
          <a href="{{ route('product.index') }}" class="btn btn-soft-light">Cancel</a>
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
<script>
document.getElementById('imageInput')?.addEventListener('change', function(e){
  const file = e.target.files && e.target.files[0];
  if(!file) return;

  const reader = new FileReader();
  reader.onload = function(){
    const prevNew = document.getElementById('previewNew');
    prevNew.src = reader.result;
    prevNew.style.display = 'block';
  };
  reader.readAsDataURL(file);
});
</script>
@endpush
