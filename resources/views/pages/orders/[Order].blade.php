<?php

use function Livewire\Volt\{state, on};

state(['order' => fn() => $order]);
on([
    'order-verified' => function () {
        $this->order = $this->order;
    },
]);
?>
<x-layouts.app>
    <style>
        .list-group-item {
            display: flex;
        }

        .list-group-item * {
            line-height: 1.625rem !important;
            word-break: break-word;
        }
    </style>
    @volt
        <div class="card">
            <div class="card-header">
                <div class="">

                    <h6 class="m-0">
                        Penjualan {{ $order->id }}
                    </h6>
                </div>
            </div>
            <div class="card-body">
                @if ($order->status == 0)
                    <div class="border rounded-3 p-3 mb-4 d-flex align-items-center justify-content-between">
                        <div class="">
                            <i class="fa-solid fa-exclamation-circle text-warning me-2"></i>
                            <span class="text-sm fw-bold">
                                Coverage user belum diverifikasi
                            </span>
                        </div>
                        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#verifModal">
                            Verifikasi
                        </button>
                        <x-orders.verif-modal :order="$order" />
                    </div>
                @elseif ($order->status == 1)
                    <div class="border rounded-3 p-3 mb-4 d-flex align-items-start">
                        <i class="fa-solid fa-check-circle text-success me-2 lh-base"></i>
                        <div class="">
                            <div class="text-sm fw-bold">User Tercover</div>
                            <div class="text-sm text-muted">{{ $order->customer->modem->odp->name }}</div>
                        </div>
                        <a href="{{ url('installations/' . $order->id) }}" class="btn btn-dark ms-auto"
                            wire:navigate.hover>
                            <x-i-btn-content icon="fa-solid fa-arrow-up-right-from-square" gap="2">
                                Lihat Detail Instalasi
                            </x-i-btn-content>
                        </a>
                    </div>
                @endif
                <div class="d-flex align-items-md-start flex-column flex-md-row gap-4">
                    <div class="w-100">
                        <div class="list-group ">
                            <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                <div class="text-xs font-weight-bolder">Nama Calon User</div>
                                <div class="lh-1">
                                    {{ $order->customer->name }}
                                </div>
                            </div>
                            <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                <div class="text-xs font-weight-bolder">Telepon</div>
                                <div class="lh-1">
                                    {{ $order->customer->phone }}
                                </div>
                            </div>
                            <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                <div class="text-xs font-weight-bolder">NIK</div>
                                <div class="lh-1">
                                    {{ $order->customer->nik }}
                                </div>
                            </div>
                            <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                <div class="text-xs font-weight-bolder">Wilayah</div>
                                <div class="lh-1">
                                    {{ $order->customer->region->name }}
                                </div>
                            </div>
                            <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                <div class="text-xs font-weight-bolder">Server</div>
                                <div class="lh-1">
                                    {{ $order->customer->server->name }}
                                </div>
                            </div>
                            <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                <div class="text-xs font-weight-bolder">Paket</div>
                                <div class="lh-1">
                                    {{ $order->customer->packet->name . ' - ' . $order->customer->packet->price }}
                                </div>
                            </div>
                            <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                <div class="text-xs font-weight-bolder">Koordinat</div>
                                <div class="lh-1">
                                    {{ $order->customer->coordinate }}
                                </div>
                            </div>
                            <div class="list-group-item flex-column flex-md-row gap-1 gap-md-3">
                                <div class="text-xs font-weight-bolder">Alamat</div>
                                <div class="lh-1">
                                    {{ $order->customer->address }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-4 w-100" >
                        <div class="border rounded-3 pt-2 p-3">
                            <div class="text-xs mb-2 font-weight-bolder">Marketer</div>
                            <div class="d-flex gap-2 align-items-center">
                                <img src="https://dummyimage.com/1:1X300" class="avatar avatar-sm" alt="">
                                <div>
                                    {{ $order->marketer->name }}
                                </div>
                            </div>
                        </div>
                        @if ($order->verifier)
                            <div class="border rounded-3 pt-2 p-3">
                                <div class="text-xs mb-2 font-weight-bolder">Diverifikasi oleh</div>
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="https://dummyimage.com/1:1X300" class="avatar avatar-sm" alt="">
                                    <div>
                                        {{ $order->verifier->name }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-md-row gap-4 align-items-start w-100">
                            <div class="border overflow-hidden rounded-3 w-100">
                                <img src="{{ $order->customer->ktp_picture ? route('storage', $order->customer->ktp_picture) : 'https://dummyimage.com/16:9x100/' }}"
                                    class="card-img-top rounded-0"
                                    @click="$dispatch('lightbox', '{{ $order->customer->ktp_picture ? route('storage', $order->customer->ktp_picture) : 'https://dummyimage.com/16:9x100/' }}')">
                                <div class="p-3 text-sm">
                                    Foto KTP
                                </div>
                            </div>
                            <div class="border overflow-hidden rounded-3 w-100">
                                <img src="https://dummyimage.com/16:9x100/" class="card-img-top rounded-0"
                                    @click="$dispatch('lightbox', 'https://dummyimage.com/16:9x3000/')">
                                <div class="p-3 text-sm">
                                    Foto KTP
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endvolt
    @push('modal')
        <x-lightbox />
    @endpush
</x-layouts.app>
