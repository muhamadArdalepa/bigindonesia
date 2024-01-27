<?php

use App\Models\Odp;
use App\Models\Modem;
use Illuminate\Support\Str;
use App\Models\Installation;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use function Livewire\Volt\{usesFileUploads, rules, state};
usesFileUploads();

state([
    'invoice' => fn() => $this->invoice,
]);
$save = function () {
    try {
        DB::beginTransaction();
        $this->invoice->is_valid = true;
        $this->invoice->save();

        $this->invoice->order->cs_id = auth()->user()->id;
        $this->invoice->order->save();
        $this->dispatch('fire-success');
        $this->dispatch('order-verified');
        DB::commit();
    } catch (\Throwable $th) {
        $this->dispatch('validation-failed', errors: $th->getMessage());
    }
};

?>
<div wire:ignore.self class="modal fade" id="validationModal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
        <div class="modal-dialog modal-lg modal-fullscreen-md-down modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Validasi Pembayaran</h1>
                    <span class="p-2 cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"> </i>
                    </span>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column flex-md-row gap-3">
                        <div class="w-100">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">ID Order</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->customer->order->id }}
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Nama User</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->customer->name }}
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Nomor Anggota</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->customer->number }}
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Nomor VA</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->customer->va }}
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Paket</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->customer->packet->name }}
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Harga</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->customer->packet->price }}
                                    </div>
                                </div>
                            </div>
                            <button class="d-none"></button>
                        </div>
                        <div class="w-100">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Dibayar Pada</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->transactions->first()->created_at->translatedFormat('l, j F Y | H:i') }}
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Penerima</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->transactions->first()->user->name }}
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Metode Pembayaran</div>
                                    <div class="lh-1 mt-2">
                                        {{ $invoice->transactions->first()->via }}
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="text-xs font-weight-bolder">Bukti Pembayaran</div>
                                    <div class="mt-2">
                                        <img src="{{route('storage',$invoice->transactions->first()->picture)}}" class="w-100 rounded-3" >    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" wire:click="save" wire:loading.attr="disabled" wire:target="save">
                        <span class="ms-1">Validasi</span>
                    </button>
                </div>
            </div>
        </div>
        @script
            <script>
                $wire.on('validation-success', () => {
                    document.querySelector('[data-bs-dismiss="modal"]').click()
                    Success.fire('Validasi Berhasil')
                })
                $wire.on('validation-failed', (e) => {
                    console.error(e)
                    Failed.fire('Validasi Gagal')
                })
            </script>
        @endscript
    @endvolt
</div>
