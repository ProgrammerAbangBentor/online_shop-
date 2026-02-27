@extends('layouts.auth')

@section('title', 'Register Onlineshop')

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
      --shadow: 0 18px 40px rgba(17,24,39,.10);
      --shadow-soft: 0 10px 24px rgba(17,24,39,.08);
      --radius: 20px;
    }

    /* background auth (polos) */
    .auth-wrap{
      min-height: 100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding: 24px 12px;
      background: #ffffff; /* ganti #f4f6f9 kalau mau abu soft */
    }

    .auth-card{
      width: 100%;
      max-width: 460px;
      border-radius: var(--radius);
      background: var(--card);
      border: 1px solid var(--stroke);
      box-shadow: var(--shadow);
      overflow:hidden;
    }

    .auth-head{
      padding: 18px 18px 14px;
      border-bottom: 1px solid rgba(236,72,153,.10);
      background: #ffffff;
    }

    .brand-row{
      display:flex;
      align-items:center;
      gap:12px;
      margin-bottom: 6px;
    }

    .brand-logo{
      width: 44px; height: 44px;
      border-radius: 14px;
      background: linear-gradient(135deg, rgba(236,72,153,.18), rgba(253,164,193,.28));
      border: 1px solid rgba(236,72,153,.18);
      display:flex; align-items:center; justify-content:center;
      flex: 0 0 auto;
      overflow:hidden;
    }
    .brand-logo img{ width: 28px; height: 28px; object-fit: contain; }

    .auth-title{
      margin:0;
      font-weight: 900;
      color: var(--ink);
      letter-spacing: -.2px;
      font-size: 18px;
    }

    .auth-sub{
      margin: 0;
      color: var(--muted);
      font-size: 13px;
      line-height: 1.45;
    }

    .auth-body{ padding: 16px 18px 18px; }

    .form-label-soft{
      font-size: 12px;
      font-weight: 900;
      color: #374151;
      margin-bottom: 6px;
    }

    .input-soft{
      height: 44px;
      border-radius: 14px;
      border: 1px solid rgba(236,72,153,.18);
      background: rgba(255,241,245,.35);
      box-shadow: none !important;
      padding: 10px 12px;
      font-weight: 700;
      color: #111827;
      transition: border-color .15s ease, background .15s ease, box-shadow .15s ease;
    }
    .input-soft:focus{
      border-color: rgba(236,72,153,.42);
      background: rgba(255,241,245,.55);
      box-shadow: 0 0 0 .2rem rgba(236,72,153,.12) !important;
    }

    .btn-soft-pink{
      height: 44px;
      border-radius: 999px;
      border: 0;
      font-weight: 900;
      letter-spacing: .2px;
      background: linear-gradient(135deg, var(--pink-300), var(--pink-500));
      color: #fff;
      box-shadow: 0 10px 22px rgba(236,72,153,.22);
    }
    .btn-soft-pink:hover{ opacity: .92; color:#fff; }

    .help-link{
      font-weight: 800;
      color: #9d174d;
      text-decoration: none;
    }
    .help-link:hover{ text-decoration: underline; }

    .auth-foot{
      margin-top: 14px;
      text-align:center;
      color: var(--muted);
      font-size: 13px;
    }

    .invalid-feedback{ font-weight:700; display:block; }
    .pwindicator{ margin-top: 10px; }
  </style>
@endpush

@section('main')
  <div class="auth-wrap">
    <div class="auth-card">

      <div class="auth-head">
        <div class="brand-row">
          <div class="brand-logo">
            <img src="{{ asset('assets/img/tri_sidebar_icon_h64.png') }}" alt="Tri Collection">
          </div>
          <div>
            <h4 class="auth-title">Register</h4>
            <p class="auth-sub">Buat akun baru untuk mulai belanja di Tri Collection.</p>
          </div>
        </div>
      </div>

      <div class="auth-body">
        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="form-group">
            <label for="name" class="form-label-soft">Name</label>
            <input
              id="name"
              type="text"
              name="name"
              value="{{ old('name') }}"
              autofocus
              required
              class="form-control input-soft @error('name') is-invalid @enderror"
              placeholder="Nama lengkap"
            >
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="email" class="form-label-soft">Email</label>
            <input
              id="email"
              type="email"
              name="email"
              value="{{ old('email') }}"
              required
              class="form-control input-soft @error('email') is-invalid @enderror"
              placeholder="contoh: nama@gmail.com"
            >
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="password" class="form-label-soft">Password</label>
            <input
              id="password"
              type="password"
              name="password"
              required
              class="form-control input-soft pwstrength @error('password') is-invalid @enderror"
              data-indicator="pwindicator"
              placeholder="Buat password"
            >
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- indikator bawaan stisla --}}
            <div id="pwindicator" class="pwindicator">
              <div class="bar"></div>
              <div class="label"></div>
            </div>
          </div>

          <div class="form-group">
            <label for="password_confirmation" class="form-label-soft">Password Confirmation</label>
            <input
              id="password_confirmation"
              type="password"
              name="password_confirmation"
              required
              class="form-control input-soft @error('password_confirmation') is-invalid @enderror"
              placeholder="Ulangi password"
            >
            @error('password_confirmation')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group mb-0">
            <button type="submit" class="btn btn-soft-pink btn-lg btn-block">
              Register
            </button>
          </div>

          <div class="auth-foot">
            Sudah punya akun?
            <a class="help-link" href="{{ route('login') }}">Login</a>
          </div>

        </form>
      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
  <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>
  <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
