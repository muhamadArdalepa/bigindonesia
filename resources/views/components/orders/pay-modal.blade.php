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
    'via' => 'Tunai',
    'picture',
]);
rules([
    'via' => 'required',
    'picture' => 'required|image',
]);
$save = function () {
    $this->validate();
    $filename = 'transactions/' . Str::random(1) . '/' . Str::random(32) . '.jpeg';
    try {
        $manager = new ImageManager(new Driver());
        $encoded = $manager
            ->read($this->picture)
            ->scaleDown(width: 500)
            ->toJpeg(80);
        Storage::disk('private')->put($filename, $encoded);
        DB::beginTransaction();
        Transaction::create([
            'invoice_id' => $this->invoice->id,
            'user_id' => auth()->user()->id,
            'via' => $this->via,
            'nominal' => $this->invoice->total,
            'picture' => $filename,
        ]);
        $this->invoice->paid = $this->invoice->total;
        $this->invoice->is_paid_off = true;
        $this->invoice->save();
        DB::commit();
        $this->dispatch('pay-success');
        $this->dispatch('order-verified');
    } catch (\Throwable $th) {
        Storage::disk('private')->delete($filename);
        $this->dispatch('pay-failed', errors: $th->getMessage());
    }
};

?>
<div wire:ignore.self class="modal fade" id="payModal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content  overflow-visible">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Konfirmasi Pembayaran</h1>
                    <span class="p-2 cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"> </i>
                    </span>
                </div>
                <div class="modal-body  overflow-visible">
                    <form wire:submit="save">
                        <div class="text-center mb-3">
                            <label class="m-0">Total Bayar</label>
                            <h4 class="m-0">{{ 'Rp. ' . number_format($invoice->total) }}</h4>
                        </div>
                        <div class="form-floating">
                            <select wire:model.change="via" class="form-select">
                                <option value="Tunai">Tunai</option>
                                <option value="Virtual Akun">Virtual Akun</option>
                            </select>
                            <label>Metode Bayar</label>
                        </div>
                        @if ($via == 'Virtual Akun')
                            <div class="form-floating">
                                <div class="form-control">
                                    <div class="d-flex align-items-center justify-content-between">
                                        {{ $invoice->customer->va }}
                                        <span @click="copyText('{{ $invoice->customer->va }}','Nomor')">
                                            <i class="fa-solid fa-copy"></i>
                                        </span>
                                    </div>
                                </div>
                                <label>Nomor Virtual Akun</label>
                            </div>
                        @endif
                        <div>
                            <label>Bukti Pembayaran</label>
                            <input type="file" class="d-none @error('picture') is-invalid @enderror" wire:model="picture"
                                x-ref="picture">
                            <div class="rounded-3 border overflow-hidden position-relative  @error('picture') border-danger @enderror"
                                style="height: 10rem">
                                <div wire:loading.flex wire:target="picture"
                                    class="justify-content-center align-items-center h-100">
                                    <div class="spinner-border"></div>
                                </div>
                                @if ($picture)
                                    <button type="button" @click="$refs.picture.click()"
                                        class="btn btn-dark btn-sm position-absolute" style="top:1rem;right: 1rem;">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <img @click="$dispatch('lightbox','{{ $picture->temporaryUrl() }}')"
                                        src="{{ $picture->temporaryUrl() }}"
                                        style="height: 100%;width: 100%;object-fit: cover">
                                @else
                                    <div class="w-100 h-100  d-flex flex-column align-items-center justify-content-center"
                                        @click="$refs.picture.click()" wire:loading.remove wire:target="picture">
                                        <i class="fa-solid fa-image fa-lg"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="invalid-feedback ps-2 text-xs">
                                @error('picture')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <button class="d-none"></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" wire:click="save" wire:loading.attr="disabled" wire:target="save">
                        <span class="ms-1">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    @endvolt
</div>
