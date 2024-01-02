@volt
<aside class="sidenav overflow-hidden bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ url('/dashboard') }}">
            <img src="{{ asset('img/logos/big-warna.png') }}" class="navbar-brand-img h-100" alt="main_logo" />
            <span class="ms-1 font-weight-bold">BIG Net Manajemen</span>
        </a>
    </div>
    <hr class="horizontal dark my-0" />
    <div class="collapse navbar-collapse position-relative w-100" id="sidenav-collapse-main">
        <div class="navbar-nav d-flex py-2 flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*dashboard*') ? 'active' : '' }}" href="{{ url('dashboard') }}" wire:navigate.hover>
                    <i class="fa-solid fa-home"></i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*orders*') ? 'active' : '' }}" href="{{ url('orders') }}" wire:navigate.hover>
                    <i class="fa-solid fa-table"></i>
                    Penjualan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*installations*') ? 'active' : '' }}" href="{{ url('installations') }}" wire:navigate.hover>
                <i class="fa-solid fa-table"></i>
                    Pemasangan Baru
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*users') ? 'active' : '' }}" href="{{ url('users') }}">
                    <i class="fa-solid fa-users"></i>
                    Kelola Pengguna
                </a>
            </li>
        </div>
    </div>
</aside>
@endvolt
