<?php

use function Livewire\Volt\state;

$logout = function () {
    dd('ok');
}

?>

<nav class="navbar navbar-main navbar-expand-lg sticky-top shadow-none px-4" style="z-index:999;background-color: #f5365cdd; backdrop-filter: blur(3px)">
    @volt
    <div class="d-flex align-items-center justify-content-between flex-wrap w-100">
        <div class="navbar-collapse flex-shrink-0" id="navbar">
            <x-breadcrumb :paths="$currentPath" />
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center" id="iconNavbarSidenav">
                    <span style="cursor: pointer;" class="nav-link text-white p-0 me-3">
                        <div class="sidenav-toggler-inner nav-toggler">
                            <i class="sidenav-toggler-line bg-white nav-toggler"></i>
                            <i class="sidenav-toggler-line bg-white nav-toggler"></i>
                            <i class="sidenav-toggler-line bg-white nav-toggler"></i>
                        </div>
                    </span>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:;" class="nav-link text-white p-0" data-bs-toggle="dropdown">
                        <img src="{{asset(auth()->user()->picture)}}" class="avatar avatar-sm foto_profil" alt="foto profil">
                    </a>
                    <div class="dropdown-menu d-none dropdown-menu-end">
                        <a class="dropdown-item" href="{{ url('profile') }}" wire:navigate.hover>
                            <div class="d-flex py-1">
                                <div class="my-auto">
                                    <img src="{{asset(auth()->user()->picture)}}" class="avatar avatar-sm  me-3 ">
                                </div>
                                <h6 class="text-sm font-weight-normal align-self-center m-0">
                                    {{auth()->user()->name}}
                                </h6>
                            </div>
                        </a>
                        <hr class="horizontal dark my-2">
                        <a class="dropdown-item" @click="Question.fire({title: 'Keluar?',showLoaderOnConfirm:false,width: '20em'}).then(result => {if (result.isConfirmed) {$wire.logout()}})">
                            <div class="d-flex p-1 align-items-center">
                                <i class="fa-solid fa-right-from-bracket me-3 text-danger"></i>
                                <h6 class="text-sm font-weight-normal mb-1 ">
                                    Keluar
                                </h6>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    @endvolt
</nav>
