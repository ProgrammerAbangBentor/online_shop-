@extends('layouts.app')

@section('title', 'Add Category')

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

/* HEADER */
.section-header{
  background: linear-gradient(135deg, var(--pink-50), #fff);
  border: 1px solid var(--stroke);
  border-radius: var(--radius);
  box-shadow: var(--shadow-soft);
  padding: 18px;
  margin-bottom: 18px;
}
.section-header h1{
  font-weight:800;
  color:var(--ink);
}

/* CARD */
.card{
  border:1px solid var(--stroke) !important;
  border-radius:var(--radius) !important;
  box-shadow:var(--shadow);
  overflow:hidden;
}
.card-header{
  background:linear-gradient(135deg,var(--pink-50),#fff);
  border-bottom:1px solid var(--stroke) !important;
  padding:16px 18px;
}
.card-header h4{
  font-weight:800;
  margin:0;
}
.card-body{ padding:18px; }
.card-footer{
  border-top:1px solid rgba(236,72,153,.15);
  background:#fff;
  padding:14px 18px;
}

/* FORM */
.form-group label{
  font-size:12px;
  font-weight:900;
  text-transform:uppercase;
  color:var(--muted);
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

/* BUTTON */
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

/* IMAGE PREVIEW */
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
  width:90px;
  height:90px;
  border-radius:16px;
  object-fit:cover;
  border:1px solid rgba(236,72,153,.18);
  box-shadow:0 10px 18px rgba(17,24,39,.06);
  display:none;
}
.no-image{
  font-weight:900;
  font-size:12px;
  color:rgba(185,28,28,1);
}
.help{
  font-size:12px;
  font-weight:700;
  color:var(--muted);
  margin-top:6px;
}
</style>
@endpush

@section('main')
<div class="main-content">
<section class="section">

<div class="section-header">
  <h1>Add Category</h1>
</div>

<div class="section-body">
<h2 class="section-title">Category</h2>

<div class="card">
<form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="card-header">
  <h4>Input Data</h4>
</div>

<div class="card-body">
<div class="row">

<div class="col-lg-7">

  <div class="form-group">
    <label>Name</label>
    <input type="text"
           class="form-control @error('name') is-invalid @enderror"
           name="name"
           value="{{ old('name') }}"
           placeholder="Contoh: Dress, Hijab, Kemeja...">
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label>Description</label>
    <input type="text"
           class="form-control @error('description') is-invalid @enderror"
           name="description"
           value="{{ old('description') }}"
           placeholder="Deskripsi singkat kategori...">
    @error('description')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label>Photo Category</label>
    <input type="file"
           class="form-control @error('image') is-invalid @enderror"
           name="image"
           id="imageInput"
           accept="image/*">
    @error('image')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="help">Format: JPG/PNG. Ukuran ideal 600x600.</div>
  </div>

</div>

<div class="col-lg-5">
  <div class="form-group">
    <label>Preview</label>
    <div class="preview-box">
      <img id="previewImage" class="preview-img">
      <span id="noImageText" class="no-image">
        <i class="fas fa-image"></i> No Image Selected
      </span>
    </div>
  </div>
</div>

</div>
</div>

<div class="card-footer d-flex justify-content-end" style="gap:10px;">
  <a href="{{ route('category.index') }}" class="btn btn-soft-light">Cancel</a>
  <button class="btn btn-soft" type="submit">
    <i class="fas fa-save mr-1"></i> Save Category
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
document.getElementById('imageInput').addEventListener('change', function(e){
    const reader = new FileReader();
    reader.onload = function(){
        const preview = document.getElementById('previewImage');
        const noText = document.getElementById('noImageText');
        preview.src = reader.result;
        preview.style.display = "block";
        noText.style.display = "none";
    }
    reader.readAsDataURL(e.target.files[0]);
});
</script>
@endpush
