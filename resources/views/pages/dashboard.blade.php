<?php
use function Livewire\Volt\{state};
state([
    'isActive' => function () {
        return App\Models\Absen::whereDate('created_at',now())->first() ? true : false;
    }
])->locked();

$activate = function () {
    App\Models\User::role('Karyawan')->pluck('id')->each(function ($id) {
        App\Models\Absen::create(['user_id'=>$id]); 
    });
}

?>

<x-layouts.app>
    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    @if (!$isActive)
                    <div class="d-flex gap-3 align-items-center">
                        <h6>Absen Hari Ini Tidak Aktif</h6>
                        <button class="ms-auto btn btn-dark" wire:click="activate()">
                            Aktifkan Absen
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endvolt
</x-layouts.app>
