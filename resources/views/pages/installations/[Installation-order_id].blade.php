<?php

use function Livewire\Volt\{state, on};

state(['installation' => fn() => $installation]);
on([
    'techy-assigned' => function () {
        $this->insallation = $this->installation;
    },
]);

?>
<x-layouts.app>
    @volt
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h6 class="m-0">
                        Pemasangan {{ $installation->order_id }}
                    </h6>
                </div>
            </div>
            <div class="card-body" x-data="{ active: 1 }">
                @if ($installation->status != 0)
                    <nav class="nav nav-pills bg-light p-2 flex-column flex-md-row mb-3">
                        <span class="nav-link cursor-pointer" :class="section == active ? 'active' : ''"
                            @click="active=0;console.log(active)" x-data="{ section: 0 }">Data User</span>
                        <span class="nav-link cursor-pointer" :class="section == active ? 'active' : ''"
                            @click="active=1;console.log(active)" x-data="{ section: 1 }">Proses Instalasi</span>
                    </nav>
                @endif
                <div x-show="active==0">
                    @if ($installation->status == 0)
                        <div class="border rounded-3 p-3 mb-4 d-flex align-items-center">
                            <i class="fa-solid fa-exclamation-circle text-warning me-2 lh-base"></i>
                            <div class="">
                                <div class="text-sm fw-bold">Belum ada teknisi ditugaskan</div>
                            </div>
                            <a href="#assignModal" class="btn btn-dark ms-auto" data-bs-toggle="modal">
                                <x-i-btn-content icon="fa-solid fa-share-from-square" gap="2">
                                    Tugaskan Teknisi
                                </x-i-btn-content>
                            </a>
                            <livewire:installations.assign-modal :installation="$installation">
                        </div>
                    @endif

                    <div class="d-flex align-items-md-start flex-column flex-md-row gap-4">
                        <div class="w-100">
                            <div class="list-group list-group-custom">
                                <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                    <div class="text-xs font-weight-bolder">Nama Calon User</div>
                                    <div class="lh-1">
                                        {{ $installation->order->customer->name }}
                                    </div>
                                </div>
                                <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                    <div class="text-xs font-weight-bolder">Telepon</div>
                                    <div class="lh-1">
                                        {{ $installation->order->customer->phone }}
                                    </div>
                                </div>
                                <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                    <div class="text-xs font-weight-bolder">Wilayah</div>
                                    <div class="lh-1">
                                        {{ $installation->order->customer->region->name }}
                                    </div>
                                </div>
                                <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                    <div class="text-xs font-weight-bolder">Server</div>
                                    <div class="lh-1">
                                        {{ $installation->order->customer->server->name }}
                                    </div>
                                </div>
                                <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                    <div class="text-xs font-weight-bolder">Koordinat</div>
                                    <div class="lh-1">
                                        {{ $installation->order->customer->coordinate }}
                                    </div>
                                </div>
                                <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                    <div class="text-xs font-weight-bolder">Alamat</div>
                                    <div class="lh-1">
                                        {{ $installation->order->customer->address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column gap-4 w-100">
                            @if ($installation->team)
                                <div class="border rounded-3 pt-2 p-3">
                                    <div class="text-xs mb-3 font-weight-bolder">Tim Pemasangan</div>
                                    <div class="d-flex gap-3 flex-column">
                                        <div class="d-flex gap-3 align-items-center">
                                            <img src="{{ asset('storage/' . $installation->team->leader->picture) }}"
                                                class="avatar avatar-sm">
                                            <div>
                                                {{ $installation->team->leader->name }}
                                                <span class="font-weight-light ms-1 text-sm">(Ketua)</span>
                                            </div>
                                        </div>
                                        @if ($installation->team->team_members)
                                            @foreach ($installation->team->team_members as $member)
                                                <div class="d-flex gap-3 align-items-center">
                                                    <img src="{{ asset('storage/' . $member->user->picture) }}"
                                                        class="avatar avatar-sm">
                                                    <div>{{ $member->user->name }}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex flex-column flex-md-row gap-4 align-items-start w-100">
                                <div class="border overflow-hidden rounded-3 w-100">
                                    <img src="https://dummyimage.com/16:9x100/" class="card-img-top rounded-0">
                                    <div class="p-3 text-sm">
                                        Foto Rumah
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($installation->has('procedures'))
                    <div x-show="active==1">
                        <livewire:installations.procedure :id="$installation->id" />
                    </div>
                @endif
            </div>
        </div>
    @endvolt
    <x-lightbox />
</x-layouts.app>
