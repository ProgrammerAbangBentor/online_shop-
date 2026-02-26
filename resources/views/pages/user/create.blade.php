@extends('layouts.app')

@section('title', 'Create User')

@push('style')
  <!-- CSS Libraries (biarin kalau memang dipakai di layout kamu) -->
  <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
  <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

  <!-- ✅ Modern Soft Pink Form UI -->
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
      padding: 18px;
      margin-bottom: 18px;
    }
    .section-header h1{
      color: var(--ink);
      font-weight: 800;
      margin-bottom: 0;
      letter-spacing: .2px;
    }
    .section-header-breadcrumb .breadcrumb-item a{ color: var(--muted); text-decoration:none; }

    .section-title{ font-weight: 800; color: var(--ink); margin-top: 6px; }
    .section-lead{ color: var(--muted); margin-bottom: 14px; }

    /* Card */
    .card{
      border: 1px solid var(--stroke) !important;
      border-radius: var(--radius) !important;
      box-shadow: var(--shadow);
      overflow: hidden;
    }
    .card-header{
      background: linear-gradient(135deg, var(--pink-50), #fff);
      border-bottom: 1px solid var(--stroke) !important;
      padding: 16px 18px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 10px;
      flex-wrap: wrap;
    }
    .card-header h4{
      margin: 0;
      font-weight: 800;
      color: var(--ink);
    }
    .card-body{ padding: 18px; }
    .card-footer{
      background: #fff;
      border-top: 1px solid rgba(236,72,153,.10) !important;
      padding: 14px 18px;
    }

    /* Form */
    .form-group label{ font-weight: 800; color: var(--ink); }
    .form-control{
      border-radius: 14px;
      border: 1px solid rgba(236,72,153,.18);
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
      height: 44px;
    }
    .form-control:focus{
      border-color: rgba(236,72,153,.55) !important;
      box-shadow: 0 0 0 .2rem rgba(236,72,153,.12) !important;
    }
    .input-group .input-group-text{
      border-radius: 14px 0 0 14px;
      border: 1px solid rgba(236,72,153,.18);
      background: linear-gradient(135deg, var(--pink-50), #fff);
      color: rgba(190,24,93,1);
      font-weight: 800;
    }
    .input-group .form-control{
      border-left: 0;
      border-radius: 0 14px 14px 0;
    }
    .invalid-feedback{ font-weight: 700; }

    /* Role pills */
    .selectgroup{ display:flex; gap:10px; flex-wrap:wrap; }
    .selectgroup-item{ margin: 0; }
    .selectgroup-input{ display:none; }
    .selectgroup-button{
      border-radius: 999px !important;
      padding: 10px 14px;
      border: 1px solid rgba(236,72,153,.18) !important;
      background: #fff !important;
      color: var(--ink) !important;
      font-weight: 900 !important;
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
      transition: .16s ease;
      user-select:none;
    }
    .selectgroup-input:checked + .selectgroup-button{
      background: rgba(236,72,153,.12) !important;
      border-color: rgba(236,72,153,.40) !important;
      color: rgba(190,24,93,1) !important;
      transform: translateY(-1px);
      box-shadow: 0 16px 26px rgba(236,72,153,.12);
    }

    /* Buttons */
    .btn-primary{
      border-radius: 14px;
      font-weight: 900;
      padding: .65rem 1rem;
      border: 1px solid rgba(236,72,153,.25) !important;
      background: linear-gradient(135deg, rgba(236,72,153,.95), rgba(244,114,182,.95)) !important;
      box-shadow: 0 14px 28px rgba(236,72,153,.18);
    }
    .btn-primary:hover{ transform: translateY(-1px); }

    .btn-light{
      border-radius: 14px;
      font-weight: 800;
      border: 1px solid rgba(236,72,153,.18);
      background: #fff;
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
    }

    /* Layout helper */
    .form-grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }
    @media (max-width: 991px){
      .form-grid{ grid-template-columns: 1fr; }
    }
  </style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Create User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></div>
        <div class="breadcrumb-item">Create</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Users</h2>
      <p class="section-lead">Add a new user account.</p>

      <div class="card">
        <form action="{{ route('user.store') }}" method="POST" autocomplete="off">
          @csrf

          <div class="card-header">
            <h4>User Information</h4>
            <a href="{{ route('user.index') }}" class="btn btn-light">
              <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
          </div>

          <div class="card-body">
            <div class="form-grid">
              <div class="form-group">
                <label>Name</label>
                <input
                  type="text"
                  name="name"
                  value="{{ old('name') }}"
                  class="form-control @error('name') is-invalid @enderror"
                  placeholder="Full name">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="form-group">
                <label>Email</label>
                <input
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  class="form-control @error('email') is-invalid @enderror"
                  placeholder="name@email.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                  </div>
                  <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••">
                </div>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="form-group">
                <label>Phone</label>
                <input
                  type="number"
                  name="phone"
                  value="{{ old('phone') }}"
                  class="form-control"
                  placeholder="08xxxxxxxxxx">
              </div>
            </div>

            <div class="form-group mt-2">
              <label class="form-label">Roles</label>
              <div class="selectgroup w-100">
                <label class="selectgroup-item">
                  <input type="radio" name="roles" value="ADMIN" class="selectgroup-input"
                    {{ old('roles','ADMIN') == 'ADMIN' ? 'checked' : '' }}>
                  <span class="selectgroup-button"><i class="fas fa-shield-alt mr-1"></i> Admin</span>
                </label>

                <label class="selectgroup-item">
                  <input type="radio" name="roles" value="USER" class="selectgroup-input"
                    {{ old('roles') == 'USER' ? 'checked' : '' }}>
                  <span class="selectgroup-button"><i class="fas fa-user mr-1"></i> User</span>
                </label>
              </div>
            </div>

          </div>

          <div class="card-footer text-right">
            <button class="btn btn-primary">
              <i class="fas fa-save mr-1"></i> Submit
            </button>
          </div>

        </form>
      </div>

    </div>
  </section>
</div>
@endsection

@push('scripts')
@endpush
