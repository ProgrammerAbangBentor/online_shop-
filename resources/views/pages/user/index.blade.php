@extends('layouts.app')

@section('title', 'Users')

@push('style')
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

  <!-- ✅ Modern Soft Pink UI (Users Index) -->
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
      font-weight: 700;
      border: 1px solid rgba(236,72,153,.25);
      background: linear-gradient(135deg, rgba(236,72,153,.95), rgba(244,114,182,.95));
      box-shadow: 0 12px 24px rgba(236,72,153,.18);
    }
    .section-header-button .btn:hover{ transform: translateY(-1px); }

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

    /* Toolbar (filter + search) */
    .users-toolbar{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 12px;
      flex-wrap: wrap;
      margin-bottom: 12px;
    }
    .users-toolbar .left,
    .users-toolbar .right{
      display:flex;
      align-items:center;
      gap: 10px;
      flex-wrap: wrap;
    }

    /* Selectric + input */
    .selectric{
      border-radius: 12px !important;
      border: 1px solid rgba(236,72,153,.20) !important;
      box-shadow: 0 10px 20px rgba(17,24,39,.06);
      overflow: hidden;
    }
    .selectric .label{ color: var(--ink); font-weight: 600; }

    .users-search .form-control{
      border-radius: 12px;
      border: 1px solid rgba(236,72,153,.20);
      box-shadow: 0 10px 20px rgba(17,24,39,.06);
      height: 42px;
    }
    .users-search .btn{
      border-radius: 12px;
      height: 42px;
      padding: 0 14px;
      font-weight: 700;
      border: 1px solid rgba(236,72,153,.25);
      background: linear-gradient(135deg, rgba(236,72,153,.95), rgba(244,114,182,.95));
      box-shadow: 0 12px 24px rgba(236,72,153,.18);
    }

    /* Table */
    .users-table{
      border-collapse: separate !important;
      border-spacing: 0 10px !important;
    }
    .users-table thead th{
      border: 0 !important;
      color: var(--muted);
      font-weight: 800;
      letter-spacing: .3px;
      text-transform: uppercase;
      font-size: 12px;
      padding: 10px 12px;
      white-space: nowrap;
    }
    .users-table tbody tr{
      background: #fff;
      box-shadow: 0 10px 18px rgba(17,24,39,.06);
      border-radius: 14px;
      transition: .18s ease;
    }
    .users-table tbody tr:hover{
      transform: translateY(-2px);
      box-shadow: 0 16px 26px rgba(17,24,39,.09);
    }
    .users-table tbody td{
      border-top: 1px solid rgba(236,72,153,.10) !important;
      border-bottom: 1px solid rgba(236,72,153,.10) !important;
      padding: 12px 12px !important;
      vertical-align: middle;
      color: var(--ink);
    }
    .users-table tbody tr td:first-child{
      border-left: 1px solid rgba(236,72,153,.10) !important;
      border-top-left-radius: 14px;
      border-bottom-left-radius: 14px;
      font-weight: 800;
    }
    .users-table tbody tr td:last-child{
      border-right: 1px solid rgba(236,72,153,.10) !important;
      border-top-right-radius: 14px;
      border-bottom-right-radius: 14px;
    }

    /* Badges roles */
    .role-pill{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 800;
      font-size: 12px;
      background: rgba(236,72,153,.10);
      border: 1px solid rgba(236,72,153,.18);
      color: rgba(190,24,93,1);
      white-space: nowrap;
    }

    /* Actions */
    .btn-action{
      border-radius: 12px !important;
      padding: .45rem .75rem !important;
      font-weight: 800 !important;
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

    /* Pagination spacing */
    .pagination{ margin-top: 14px; }
  </style>
@endpush

@section('main')
<div class="main-content">
  <section class="section">

    <div class="section-header">
      <h1>Users</h1>

      <div class="section-header-button">
        <a href="{{ route('user.create') }}" class="btn btn-primary">
          <i class="fas fa-plus mr-1"></i> Add New
        </a>
      </div>

      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Users</a></div>
        <div class="breadcrumb-item">All Users</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Users</h2>
      <p class="section-lead">You can manage all users: edit, delete, and more.</p>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card">

            <div class="card-header">
              <h4>All Users</h4>

              {{-- mini info --}}
              <div style="color: var(--muted); font-weight:700;">
                Total: {{ $users->total() ?? count($users) }}
              </div>
            </div>

            <div class="card-body">

              <div class="users-toolbar">
                <div class="left">
                  <select class="form-control selectric" style="min-width:220px;">
                    <option>Action For Selected</option>
                    <option>Move to Draft</option>
                    <option>Move to Pending</option>
                    <option>Delete Permanently</option>
                  </select>
                </div>

                <div class="right">
                  <form method="GET" action="{{ route('user.index') }}" class="users-search">
                    <div class="input-group">
                      <input type="text"
                             class="form-control"
                             placeholder="Search name..."
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
                <table class="table users-table">
                  <thead>
                    <tr>
                      <th style="min-width:160px;">Name</th>
                      <th style="min-width:220px;">Email</th>
                      <th style="min-width:120px;">Phone</th>
                      <th style="min-width:110px;">Roles</th>
                      <th style="min-width:170px;">Created</th>
                      <th style="min-width:180px;" class="text-center">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse ($users as $user)
                      <tr>
                        <td>{{ $user->name }}</td>

                        <td>
                          <div style="font-weight:700;">{{ $user->email }}</div>
                        </td>

                        <td>{{ $user->phone ?? '-' }}</td>

                        <td>
                          <span class="role-pill">
                            <i class="fas fa-user-tag"></i>
                            {{ $user->roles ?? 'user' }}
                          </span>
                        </td>

                        <td>
                            @php
                                $created = $user->created_at ? \Illuminate\Support\Carbon::parse($user->created_at) : null;
                            @endphp

                            <div style="font-weight:700;">
                                {{ $created ? $created->format('d M Y') : '-' }}
                            </div>
                            <div style="color:var(--muted); font-size:12px;">
                                {{ $created ? $created->format('H:i') : '' }}
                            </div>
                        </td>

                        <td class="text-center">
                          <div class="d-flex justify-content-center" style="gap:8px; flex-wrap:wrap;">
                            <a href="{{ route('user.edit', $user->id) }}"
                               class="btn btn-sm btn-info btn-icon btn-action">
                              <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <form action="{{ route('user.destroy', $user->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this user?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger btn-icon btn-action">
                                <i class="fas fa-trash mr-1"></i> Delete
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center" style="color:var(--muted); padding:22px !important;">
                          No users found.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div class="d-flex justify-content-end">
                {{ $users->withQueryString()->links() }}
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
  <!-- JS Libraries -->
  <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
