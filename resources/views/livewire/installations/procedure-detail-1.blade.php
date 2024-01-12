<?php
use Illuminate\Support\Facades\DB;
use App\Models\InstallationProcedure;
use App\Models\InstallationProcedureDetail;
use function Livewire\Volt\{computed, state, on, rules, usesFileUploads, mount};

usesFileUploads();

state([
    'procedure' => fn() => $this->procedure,
    'modem' => fn() => $this->procedure->details[0],
    'cable' => fn() => $this->procedure->details[1],
    'sn' => fn() => $this->procedure->installation->order->customer->modem->sn,
    'desc',
    'cable_type' => fn() => $this->procedure->installation->cable_type,
    'isFilled' => fn()=>$this->modem->picture && $this->cable->picture
]);

on([
    'picture-added' => function () {
        if ($this->modem->picture && $this->cable->picture) {
            $this->isFilled = true;
        }
    }
]);

mount(function () {
});

rules([
    'sn' => 'required|max:255',
    'cable_type' => 'required|max:255',
]);

$save = function () {
    $this->validate();
    try {
        DB::beginTransaction();
        $this->procedure->installation->cable_type = $this->cable_type;
        $this->procedure->installation->save();
        
        $this->procedure->installation->order->customer->modem->sn = $this->sn;
        $this->procedure->installation->order->customer->modem->save();


        $this->procedure->desc = $this->desc;
        
        if (!$this->procedure->is_done) {
            $this->procedure->is_done = true;
            $new_proc = InstallationProcedure::create([
                'installation_id' => $this->procedure->installation->id,
                'title' => 'Instalasi Pada ODP',
                'step' => 2
            ]);
    
            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title'=>'Foto fisik ODP',
            ]);
            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title'=>'Foto tunjuk port yang digunakan',
            ]);
            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title'=>'Foto Output ODP',
            ]);
        }
        $this->procedure->save();
        DB::commit();
        $this->dispatch('procedure-updated');
    } catch (\Throwable $th) {
        DB::rollBack();
        dd($th);
    }
}


?>
<div>
    @volt
    <div class="d-flex gap-3 flex-column">
        <livewire:installations.procedure-image-uploader :data="$modem" />
        <livewire:installations.procedure-image-uploader :data="$cable" />
        <form wire:submit="save">
            <div class="form-floating ">
                <input type="text" class="form-control @error('sn') is-invalid @enderror" placeholder="SN Modem"
                    wire:model="sn">
                <label>SN Modem</label>
                <div class="invalid-feedback">@error('sn') {{$message}} @enderror</div>
            </div>
            <div class="form-floating has-validation">
                <select class="form-select  @error('cable_type') is-invalid @enderror" wire:model="cable_type">
                    <option>-- Pilih Jenis Kabel --</option>
                    <option value="precon">Precon</option>
                    <option value="dw">Kabel DW</option>
                </select>
                <label>Jenis Kabel</label>
                <div class="invalid-feedback">@error('cable_type') {{$message}} @enderror</div>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" placeholder="Keterangan" wire:model="desc">
                <label>Keterangan (Opsional)</label>
            </div>
            @if($isFilled)
            <div class="text-end">
                <button class="btn btn-dark">Simpan</button>
            </div>
            @endif
        </form>
    </div>
    @endvolt
</div>