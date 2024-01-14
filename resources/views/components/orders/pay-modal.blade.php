<?php

use App\Models\Installation;
use App\Models\Modem;
use App\Models\Odp;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{computed, on, state};

state([
    'invoice' => fn() => $this->invoice,
    'nominal',
]);

$submit = function () {

};

?>
<div wire:ignore.self class="modal fade" id="payModal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content  overflow-visible">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Konfirmasi Pembayaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  overflow-visible">
                    <form wire:submit="submit">
                        <div class="form-floating">
                            
                            <input x-mask:dynamic="$money($input)" placeholder="Nominal" class="form-control">
                            <label>Nominal</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" wire:click="submit()" wire:loading.attr="disabled">
                        <i class="fa-solid fa-spin fa-spinner" wire:loading wire:target="submit"></i>
                        <span class="ms-1">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
        @script
            <script>
                $wire.on('order-verified', () => {
                    document.querySelector('button[data-bs-dismiss="modal"]').click()
                    Success.fire('Verifikasi Berhasil')
                })
                $wire.on('verification-failed', () => {
                    Failed.fire('Verifikasi Gagal')
                })
            </script>
        @endscript
    @endvolt
</div>
