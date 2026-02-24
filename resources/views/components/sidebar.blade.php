<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        {{-- BRAND (LOGO BESAR) --}}
        <div class="sidebar-brand">
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('assets/img/tri_sidebar_lockup_h44.png') }}"
                     alt="Tri Collection"
                     class="brand-logo">
            </a>
        </div>

        {{-- BRAND (LOGO KECIL - MODE COLLAPSE) --}}
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('assets/img/tri_sidebar_icon_h64.png') }}"
                     alt="Tri Collection"
                     class="brand-logo-sm">
            </a>
        </div>

        <ul class="sidebar-menu">

            {{-- =========================
                DASHBOARD
            ========================== --}}
            <li class="menu-header">Dashboard</li>

            @php
                $isDashboard = Request::is('dashboard-general-dashboard');
            @endphp

            <li class="nav-item dropdown {{ $isDashboard ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-fire"></i>
                    <span>Dashboard</span>
                </a>
                <ul class="dropdown-menu" style="{{ $isDashboard ? 'display:block;' : '' }}">
                    <li class="{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('dashboard-general-dashboard') }}">
                            General Dashboard
                        </a>
                    </li>
                </ul>
            </li>

            {{-- =========================
                MASTER DATA
            ========================== --}}
            <li class="menu-header">Master</li>

            @php $isUser = Request::is('user*'); @endphp
            <li class="nav-item dropdown {{ $isUser ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <ul class="dropdown-menu" style="{{ $isUser ? 'display:block;' : '' }}">
                    <li class="{{ Request::is('user') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.index') }}">All Users</a>
                    </li>
                </ul>
            </li>

            @php $isCategory = Request::is('category*'); @endphp
            <li class="nav-item dropdown {{ $isCategory ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-tags"></i>
                    <span>Category</span>
                </a>
                <ul class="dropdown-menu" style="{{ $isCategory ? 'display:block;' : '' }}">
                    <li class="{{ Request::is('category') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('category.index') }}">All Category</a>
                    </li>
                </ul>
            </li>

            @php $isProduct = Request::is('product*'); @endphp
            <li class="nav-item dropdown {{ $isProduct ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-box-open"></i>
                    <span>Product</span>
                </a>
                <ul class="dropdown-menu" style="{{ $isProduct ? 'display:block;' : '' }}">
                    <li class="{{ Request::is('product') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('product.index') }}">All Product</a>
                    </li>
                </ul>
            </li>

        </ul>
    </aside>
</div>
