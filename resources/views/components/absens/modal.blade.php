<?php
use function Livewire\Volt\{computed,state};

state(['id']);
$absen = computed(fn()=> $this->id ? auth()->user()->absens()->find($this->id) : null );
$setId = function ($id) {
    $this->id = $id;
};
$setNull = function () {
    $this->id = null;
};

?>

@volt
    <div wire:ignore.self x-ref="detailModal" @shown-bs-modal.dot="$wire.setId(selected)"
        @hide-bs-modal.dot="$wire.setNull()" class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Detail Absen</h1>
                    <span class="p-2 cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"> </i>
                    </span>
                </div>
                <div class="modal-body">
                    @if ($this->absen)
                        <div class="d-flex flex-column flex-md-row gap-5 gap-md-3">
                            <x-absens.daily :details="$this->absen->absen_details" />
                        </div>
                    @else
                        <div style="height: 20rem" class="content-middle">
                            <span class="spinner-border"></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endvolt
