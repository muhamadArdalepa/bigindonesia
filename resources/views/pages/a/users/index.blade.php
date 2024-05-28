<?php
use function Livewire\Volt\{state,on};

state([
    'accesses'=>['Karyawan','Supervisor','Super Admin'],
    'access' => fn() => $this->accesses[0],
]);

on(['set-access'=>function ($access) {
    // dd($access);
    $this->access = $access;
}]);

?>

<x-layouts.app>
    @volt
    <div class="card">
        <div class="card-header">
            <div class="">
                <h6 class="m-0">
                    Kelola Pengguna
                </h6>
            </div>
        </div>
        <div class="card-body" x-data="{ active: 'Karyawan' }" x-on:set-access="active = $event.detail">
            <nav class="nav nav-pills bg-light p-2  mb-3">
                @foreach ($accesses as $item)
                <span x-data="{item: '{{$item}}'}" @click="$dispatch('set-access', {access: item});active = item" :class="item == active ? 'active' : ''" class="nav-link cursor-pointer">{{$item}}</span>
                @endforeach
            </nav>
            <livewire:users.table :access="$access" lazy/>
        </div>
    </div>
    @endvolt
</x-layouts.app>
