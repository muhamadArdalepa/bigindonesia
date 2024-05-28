<?php

use Carbon\Carbon;
use App\Models\Poin;
use App\Models\Order;
use App\Models\Installation;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{state, on};

state([
    'report' => fn() => $report,
]);
?>
<x-layouts.app>
    @volt
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">
                    Laporan {{ $report->id }}
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-md-row flex-column gap-3 gap-4 mb-4">
                    <div class="border w-100 rounded-3 p-3 d-flex gap-2">
                        @switch($report->status)
                            @case(0)
                                <div><i class="fa-solid fa-exclamation-circle text-warning"></i></div>
                                <div class="text-sm fw-bold me-auto">Laporan belum ditangani</div>
                                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#verifModal">
                                    Check
                                </button>
                                @push('modal')
                                    <x-reports.check-modal :report="$report" />
                                @endpush
                            @break

                            {{-- @case(1)
                                <div><i class="fa-solid fa-check-circle text-success"></i></div>
                                <div>
                                    <div class="text-sm fw-bold">User Tercover</div>
                                    <div class="text-sm text-muted">{{ $order->customer->modem->odp->name }}</div>
                                </div>
                            @break

                            @case(2)
                                <div><i class="fa-solid fa-xmark-circle text-danger"></i></div>
                                <div class="text-sm fw-bold">User Tidak Tercover</div>
                            @break

                            @case(3)
                                <div><i class="fa-solid fa-exclamation-circle text-warning"></i></div>
                                <div class="text-sm fw-bold">Tarik Jalur</div>
                            @break --}}
                        @endswitch
                    </div>
                    {{-- @if ($order->installation)
                        <div class="border w-100 rounded-3 p-3 d-flex gap-2 flex-wrap">
                            @switch($order->installation->status)
                                @case(0)
                                    <div><i class="fa-solid fa-exclamation-circle text-warning"></i></div>
                                    <div class="text-sm fw-bold me-auto">Instalasi belum dimulai</div>
                                @break

                                @case(1)
                                    <div><i class="fa-solid fa-gear fa-spin text-warning"></i></div>
                                    <div class="text-sm fw-bold me-auto">Instalasi diproses</div>
                                @break

                                @case(2)
                                    <div><i class="fa-solid fa-check-circle text-success"></i></div>
                                    <div class="text-sm fw-bold me-auto">Instalasi Selesai</div>
                                @break

                                @case(3)
                                    <div><i class="fa-solid fa-xmark-circle text-danger"></i></div>
                                    <div class="text-sm fw-bold me-auto">Instalasi Dibatalkan</div>
                                @break
                            @endswitch
                            <a href="{{ url('installations/' . $order->id) }}" class="btn btn-dark" wire:navigate>
                                Detail
                            </a>
                        </div>
                    @endif --}}

                </div>
                {{-- <div class="d-flex align-items-md-start flex-column flex-md-row gap-4">
                    <div class="w-100">
                        <div class="list-group list-group-custom">
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
                                    {{ $order->customer->packet->name . ' - ' . ' Rp. ' . number_format($order->customer->packet->price) }}
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
                    <div class="d-flex flex-column gap-4 w-100">
                        <div class="border rounded-3 pt-2 p-3">
                            <div class="text-xs mb-2 font-weight-bolder">Marketer</div>
                            <div class="d-flex gap-2 align-items-center">
                                <img src="{{ asset($order->marketer->picture) }}" class="avatar avatar-sm" alt="">
                                <div>
                                    {{ $order->marketer->name }}
                                </div>
                            </div>
                        </div>
                        @if ($order->verifier)
                            <div class="border rounded-3 pt-2 p-3">
                                <div class="text-xs mb-2 font-weight-bolder">Diverifikasi oleh</div>
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="{{ asset($order->verifier->picture) }}" class="avatar avatar-sm"
                                        alt="">
                                    <div>
                                        {{ $order->verifier->name }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex gap-4 align-items-start w-100">
                            <div class="border overflow-hidden rounded-3 w-100">
                                <img src="{{ route('storage', $order->customer->ktp_picture) }}"
                                    class="card-img-top rounded-0"
                                    @click="$dispatch('lightbox', '{{ route('storage', $order->customer->ktp_picture) }}')">
                                <div class="p-3 text-sm">
                                    Foto KTP
                                </div>
                            </div>
                            <div class="border overflow-hidden rounded-3 w-100">
                                <img src="{{ route('storage', $order->customer->house_picture) }}"
                                    class="card-img-top rounded-0"
                                    @click="$dispatch('lightbox', '{{ route('storage', $order->customer->house_picture) }}')">
                                <div class="p-3 text-sm">
                                    Foto Rumah
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
       
        {{-- @push('modal')
            @if ($invoice)
                @if (!$invoice->is_paid_off)
                    <x-orders.pay-modal :invoice="$invoice" />
                @else
                    @if (!$invoice->is_valid)
                        <x-orders.validation-modal :invoice="$invoice" />
                    @endif
                @endif
            @endif
            <x-lightbox />
        @endpush --}}
    @endvolt
</x-layouts.app>
