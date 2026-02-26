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

            @auth

            {{-- =========================
                MENU ADMIN
            ========================== --}}
            @if(auth()->user()->roles === 'ADMIN')

                <li class="menu-header">Admin Panel</li>

                {{-- Dashboard --}}
                @php $isDashboard = Request::is('dashboard-general-dashboard'); @endphp
                <li class="{{ $isDashboard ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pages.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li class="menu-header">Master</li>

                {{-- Data Pelanggan --}}
                <li class="{{ request()->is('admin/pelanggan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('customers.index') }}">
                        <i class="fas fa-user-friends"></i> <span>Data Pelanggan</span>
                    </a>
                </li>

                {{-- Users --}}
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

                {{-- Category --}}
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

                {{-- Product --}}
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

                <li class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
                    <a href="{{ route('laporan.index') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan</span>
                    </a>
                </li>


            @endif


            {{-- =========================
                MENU USER / PELANGGAN
            ========================== --}}
            @if(auth()->user()->roles === 'USER')

                <li class="menu-header">Menu</li>

                {{-- Dashboard --}}
                <li class="{{ Request::is('user/dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('user/dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Product --}}
                <li class="{{ Request::is('shop/products*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('shop.products.index') }}">
                        <i class="fas fa-store"></i>
                        <span>Product</span>
                    </a>
                </li>

                {{-- Keranjang --}}
                <li class="{{ Request::is('cart*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('shop.cart.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Keranjang</span>
                    </a>
                </li>

                {{-- Transaksi --}}
                <li class="{{ Request::is('transactions*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('transactions') }}">
                        <i class="fas fa-receipt"></i>
                        <span>Transaksi</span>
                    </a>
                </li>

            @endif

            @endauth

        </ul>
    </aside>
</div>
