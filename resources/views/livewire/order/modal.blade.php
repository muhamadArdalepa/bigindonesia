<?php

use function Livewire\Volt\{state, usesFileUploads, rules};
usesFileUploads();
state(['house_picture', 'name', 'phone']);
rules(fn() => [
    'name' => 'required',
    'phone' => 'required',
]);
$submit = function () {
    $this->validate();
    \App\Models\Customer::create([
        'name' => $this->name,
        'phone' => $this->phone,
        'region_id' => 1,
        'server_id' => 1,
        'packet_id' => 1,
        'address' => fake()->address,
        'coordinate' => '0,1',
    ]);
    $this->dispatch('order-created');
    $this->reset();
};
?>
<div class="modal fade" id="Modal" tabindex="-1" @hide-bs-modal.dot="$wire.refresh()">
    @volt
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Penjualan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent>
                        <div class="form-floating has-validation">
                            <input id="name" type="text" wire:model="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Nama">
                            <label for="name">Nama Calon User</label>
                            <div class="invalid-feedback ps-2 text-xs">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-floating has-validation">
                            <input id="phone" type="tel" wire:model="phone"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="Phone">
                            <label for="phone">Phone</label>
                            <div class="invalid-feedback ps-2 text-xs">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        @if ($house_picture)
                            <img src="{{ $house_picture->temporaryUrl() }}" class="w-100 rounded-3">
                        @endif
                        <div class="form-floating has-validation">
                            <input type="file" id="house_picture" class="form-control form-control-file"
                                wire:model="house_picture" placeholder="Foto KTP">
                            <label for="house_picture">Foto KTP</label>
                            <div class="invalid-feedback ps-2 text-xs">
                                @error('house_picture')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" wire:click="submit()" wire:loading.attr="disabled">
                        <i class="fa-solid fa-spin fa-spinner" wire:loading></i>
                        <span class="ms-1">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
        @script
            <script>
                $wire.on('order-created', () => {
                    document.querySelector('button[data-bs-dismiss="modal"]').click()
                    Success.fire('Order berhasil dibuat')
                })
            </script>
        @endscript
    @endvolt
</div>
