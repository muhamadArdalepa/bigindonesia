<?php

use App\Models\Installation;
use App\Models\Modem;
use App\Models\Odp;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{computed, on, state};

state([
    'report' => fn() => $report,
    'disrupt_types' => ['Tidak Konek', 'Redaman Tinggi', 'LOS','Lainnya'],
    'disrupt_type' => fn()=> $this->disrupt_types[0],
    'desc',
]);

$submit = function () {
    $this->validate([
        'disrupt_type' => 'required',
        'desc' => 'nullable|max:255'
    ]);

    try {
        DB::beginTransaction();
         
        DB::commit();
        $this->dispatch('fire-success');
    } catch (\Throwable $th) {
        $this->dispatch('fire-failed', errors: $th->getMessage());
    }
};

?>
<div wire:ignore.self class="modal fade" id="verifModal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content  overflow-visible">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Identifikasi Gangguan</h1>
                    <span class="p-2 cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"> </i>
                    </span>
                </div>
                <div class="modal-body  overflow-visible">
                    <form wire:submit.prevent="submit">
                        <div class="form-floating has-validation">
                            <select class="form-select @error('disrupt_type') is-invalid @enderror"
                                wire:model="disrupt_type">
                                @foreach ($disrupt_types as $type)
                                    <option value="{{$type}}">{{$type}}</option>
                                @endforeach
                            </select>
                            <label>Jenis Gangguan</label>
                            <div class="invalid-feedback ps-2 text-xs">
                                @error('disrupt_type')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-floating has-validation">
                            <input type="text" wire:model="desc" class="form-control @error('desc') is-invalid @enderror" placeholder="desc">
                            <label>Keterangan (opsional)</label>
                            <div class="invalid-feedback ps-2 text-xs">
                                @error('desc')
                                    {{ $message }}
                                @enderror
                            </div>
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
    @endvolt
</div>
