<aside class="sidenav overflow-hidden bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true"></i>
        <a class="navbar-brand m-0" href="{{ url('/dashboard') }}" wire:navigate.hover>
            <img src="{{ asset('img/logos/big-warna.png') }}" class="navbar-brand-img h-100" alt="main_logo" />
            <span class="ms-1 font-weight-bold">BIG Net Manajemen</span>
        </a>
    </div>
    <hr class="horizontal dark my-0" />
    <div class="collapse navbar-collapse position-relative w-100">
        <div class="navbar-nav d-flex py-2 flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*dashboard*') ? 'active' : '' }}" href="{{ url('dashboard') }}" wire:navigate.hover>
                    <i class="fa-solid fa-home"></i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*absens*') ? 'active' : '' }}" href="{{ url('absens') }}" wire:navigate.hover>
                    <i class="fa-solid fa-table"></i>
                    Absen
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*admin/absens*') ? 'active' : '' }}" href="{{ url('admin/absens') }}" wire:navigate.hover>
                    <i class="fa-solid fa-table"></i>
                    Absen Karyawan
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
                <a class="nav-link {{ request()->is('*reports*') ? 'active' : '' }}" href="{{ url('reports') }}" wire:navigate.hover>
                <i class="fa-solid fa-table"></i>
                    Laporan Gangguan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*reparations*') ? 'active' : '' }}" href="{{ url('reparations') }}" wire:navigate.hover>
                <i class="fa-solid fa-table"></i>
                    Perbaikan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*assets*') ? 'active' : '' }}" href="{{ url('assets') }}" wire:navigate.hover>
                <i class="fa-solid fa-table"></i>
                    Asset
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*servers*') ? 'active' : '' }}" href="{{ url('servers') }}" wire:navigate.hover>
                <i class="fa-solid fa-table"></i>
                    Server
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*odcs*') ? 'active' : '' }}" href="{{ url('odcs') }}" wire:navigate.hover>
                <i class="fa-solid fa-table"></i>
                    ODC
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*warehouses*') ? 'active' : '' }}" href="{{ url('warehouses') }}" wire:navigate.hover>
                <i class="fa-solid fa-table"></i>
                    Gudang
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*warehouses*') ? 'active' : '' }}" href="{{ url('warehouses') }}" wire:navigate.hover>
                <i class="fa-solid fa-table"></i>
                    Barang
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