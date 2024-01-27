<?php

use Carbon\Carbon;
use App\Models\Poin;
use App\Models\Order;
use App\Models\Installation;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{state, on};

state([
    'order' => fn() => $order,
    'invoice' => fn() => $this->order->customer->invoices->where('type', 0)->first(),
]);
on([
    'order-verified' => function () {
        $this->order = $this->order;
    },
]);
$activate = function () {
    try {
        DB::beginTransaction();
        $this->order->customer->status = 1;
        $this->order->customer->save();

        $marketer = $this->order->marketer;
        $marketer_poin = $marketer->poins->where('period',now()->firstOfMonth())->first();
        if (!$marketer_poin) {
            $marketer_poin = Poin::create([
                'user_id'=>$marketer->id,
                'period'=>now()->startOfMonth()
            ]);
        }
        $marketer_poin->amount = $marketer_poin->amount + Order::POIN;
        $marketer_poin->save();

        $leader = $this->order->installation->team->leader;
        $leader_poin = $leader->poins->where('period',now()->firstOfMonth())->first();
        if (!$leader_poin) {
            $leader_poin = Poin::create([
                'user_id'=>$leader->id,
                'period'=>now()->startOfMonth()
            ]);
        }
        $leader_poin->amount = $leader_poin->amount + Installation::POIN;
        $leader_poin->save();

        if ($this->order->installation->team->team_members()->exists()) {
            foreach ($this->order->installation->team->team_members as $member) {
                $poin = $member->user->poins->where('period',now()->firstOfMonth())->first();
                if (!$poin) {
                    $poin = Poin::create([
                        'user_id'=>$member->user_id,
                        'period'=>now()->startOfMonth()
                    ]);
                }
                $poin->amount = $poin->amount + Installation::POIN;
                $poin->save();
            }
        }
        
        DB::commit();
        $this->dispatch('fire-success',message:"User Berhasil diaktifkan"); 
        $this->order = $this->order;
    } catch (\Throwable $th) {
        $this->dispatch('fire-failed',message:"User gagal diaktifkan",errors:$th->getMessage()); 
    }


};
?>
<x-layouts.app>
    @volt
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">
                    Penjualan {{ $order->id }}
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-md-row flex-column gap-3 gap-4 mb-4">
                    <div class="border w-100 rounded-3 p-3 d-flex gap-2">
                        @switch($order->status)
                            @case(0)
                                <div><i class="fa-solid fa-exclamation-circle text-warning"></i></div>
                                <div class="text-sm fw-bold me-auto">Coverage user belum diverifikasi</div>
                                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#verifModal">
                                    Verifikasi
                                </button>
                                @push('modal')
                                    <x-orders.verif-modal :order="$order" />
                                @endpush
                            @break

                            @case(1)
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
                            @break
                        @endswitch
                    </div>
                    @if ($order->installation)
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
                        @if ($invoice)
                            <div class="border w-100 rounded-3 p-3 d-flex gap-2 flex-wrap">
                                <div> <i class="fa-solid fa-{{ !$invoice->is_paid_off || !$invoice->is_valid ? 'exclamation-circle text-warning' : 'check-circle text-success' }}"></i></div>
                                <div>
                                    <div class="text-sm fw-bold me-auto">  {{ !$invoice->is_paid_off ? 'Menunggu pembayaran' : 'Pembayaran berhasil' }}</div>
                                    @if ($invoice->is_paid_off)
                                    <div class="text-sm fw-bold">
                                        {{ !$invoice->is_valid ? 'Menunggu Validasi' : '' }}
                                    </div>
                                    @else
                                    <div class="text-sm">
                                        {{ ' Rp. ' . number_format($order->customer->packet->price) }}
                                    </div>
                                @endif
                                </div>
                                @if (!$invoice->is_paid_off)
                                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#payModal">
                                        Bayar
                                    </button>
                                @else
                                    @if (!$invoice->is_valid)
                                        <button class="btn btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#validationModal">
                                            Validasi
                                        </button>
                                    @endif
                                @endif
                            </div>
                            @if ($invoice->is_valid)
                                <div class="border w-100 rounded-3 p-3 d-flex gap-2 flex-wrap">
                                    <div><i class="fa-solid fa-{{ $order->customer->status == 0 ? 'exclamation-circle text-warning' : 'check-circle text-success' }}"></i></div>
                                    <div class="text-sm fw-bold me-auto"> {{ $order->customer->status == 0 ? 'User belum aktif' : 'User aktif' }}</div>
                                    @if ($order->customer->status == 0)                                            
                                        <button wire:loading.attr="disabled" wire:target="activate" class="btn btn-dark"
                                            @click="Question.fire({
                                                title: 'Aktifkan User Ini?',
                                                showLoaderOnConfirm:false,
                                                width: '20em'
                                            }).then(result => result.isConfirmed ? $wire.activate() : null)">
                                            Aktifkan
                                        </button>
                                    @endif
                                </div>
                            @endif
                        @endif
                    @endif

                </div>
                <div class="d-flex align-items-md-start flex-column flex-md-row gap-4">
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
                </div>
            </div>
        </div>
        @script
        <script>
            $wire.on('fire-success', (event) => {
                Success.fire(event.message)
            })
            $wire.on('fire-failed', (event) => {
                console.error(event.errors)
                Failed.fire(event.message)
            })
        </script>
        @endscript
        @push('modal')
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
        @endpush
    @endvolt
</x-layouts.app>
