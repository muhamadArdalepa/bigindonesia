<?php
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use App\Models\InstallationProcedure;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use function Livewire\Volt\{computed, state, on, rules, usesFileUploads, mount};

usesFileUploads();

state([
    'procedure' => fn() => $this->procedure,
    'modem' => fn() => $this->procedure->details[0],
    'cable' => fn() => $this->procedure->details[1],
    'sn' => fn() => $this->procedure->installation->order->customer->modem->sn,
    'cable_type' => fn() => $this->procedure->installation->cable_type,
]);

$save = function () {};

?>
<div>
    @volt
        <div class="d-flex gap-3 flex-column">
            <livewire:installations.procedure-image-uploader :data="$modem" />
            <livewire:installations.procedure-image-uploader :data="$cable" />
            <form wire:submit="save">
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="SN Modem" wire:model="sn">
                    <label>SN Modem</label>
                </div>
                <div class="form-floating">
                    <select class="form-select" wire:model="cable_type">
                        <option value="">-- Pilih Jenis Kabel --</option>
                        <option value="precon">Precon</option>
                        <option value="dw">Kabel DW</option>
                    </select>
                    <label>Jenis Kabel</label>
                </div>
                <div class="text-end">
                    <button class="btn btn-dark">Simpan</button>
                </div>
            </form>
        </div>
    @endvolt
</div>
