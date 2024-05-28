<?php
use function Livewire\Volt\{computed, state};

state([
    'absen_id' => fn() => $this->absen_id,
])->reactive();

?>
<div wire:ignore.self class="modal fade" @hide-bs-modal.dot="$dispatch('setnull')" id="absenDetailModal" tabindex="-1">
    @volt
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Detail Absen</h1>
                    <span class="p-2 cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"> </i>
                    </span>
                </div>
                <div class="modal-body">
                    @if ($this->absen_id)
                        <livewire:absens.daily  :absen_id="$absen_id" />
                    @else
                        <div style="height: 10rem" class="content-middle flex-column gap-3">
                            <div class="spinner-border"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endvolt
</div>
