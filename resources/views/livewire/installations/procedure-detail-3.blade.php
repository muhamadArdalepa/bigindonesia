<?php
use App\Models\Odp;
use Illuminate\Support\Facades\DB;
use App\Models\InstallationProcedure;
use App\Models\InstallationProcedureDetail;
use function Livewire\Volt\{computed, state, on, rules, usesFileUploads, mount};

usesFileUploads();

state([
    'procedure' => fn() => $this->procedure,
    'rumah' => fn() => $this->procedure->details[0],
    'modem' => fn() => $this->procedure->details[1],
    'opm' => fn() => $this->procedure->details[2],
    'kabel' => fn() => $this->procedure->details[3],
    'ssid' => fn() => $this->procedure->installation->order->customer->modem->ssid,
    'password' => fn() => $this->procedure->installation->order->customer->modem->password,
    'desc',
    'isFilled' => fn() => $this->rumah->picture && $this->modem->picture && $this->opm->picture && ($this->procedure->installation->cable_type == 'dw' ? $this->kabel->picture : true),
]);
on([
    'picture-added' => function () {
        if ($this->rumah->picture && $this->modem->picture && $this->opm->picture && ($this->procedure->installation->cable_type == 'dw' ? $this->kabel->picture : true)) {
            $this->isFilled = true;
        }
    },
]);

rules([
    'ssid' => 'required|max:255',
    'password' => 'required|max:255',
]);

$save = function () {
    $this->validate();
    try {
        DB::beginTransaction();
        $this->procedure->installation->order->customer->modem->ssid = $this->ssid;
        $this->procedure->installation->order->customer->modem->password = $this->password;
        $this->procedure->installation->order->customer->modem->save();

        $this->procedure->desc = $this->desc;

        if (!$this->procedure->is_done) {
            $this->procedure->is_done = true;
            $new_proc = InstallationProcedure::create([
                'installation_id' => $this->procedure->installation->id,
                'title' => 'Selesai Instalasi',
                'step' => 4,
            ]);

            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title' => 'Foto Formulir',
            ]);
            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title' => 'Foto User dan Formulir',
            ]);

        }
        $this->procedure->save();
        DB::commit();
        $this->dispatch('procedure-updated');
    } catch (\Throwable $th) {
        DB::rollBack();
        dd($th);
    }
};

?>
<div>
    @volt
        <div class="d-flex gap-3 flex-column">
            <livewire:installations.procedure-image-uploader :data="$rumah" />
            <livewire:installations.procedure-image-uploader :data="$modem" />
            <livewire:installations.procedure-image-uploader :data="$opm" />
            @if ($procedure->installation->cable_type == 'dw')
            <livewire:installations.procedure-image-uploader :data="$kabel" />
            @endif
            <form wire:submit="save">
                <div class="form-floating has-validation">
                    <input type="text" wire:model="ssid" class="form-control @error('ssid') is-invalid @enderror" placeholder="">
                    <label>SSID</label>
                    <div class="invalid-feedback">
                        @error('ssid')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-floating has-validation">
                    <input type="text" wire:model="password" class="form-control @error('password') is-invalid @enderror" placeholder="">
                    <label>Password</label>
                    <div class="invalid-feedback">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="Keterangan" wire:model="desc">
                    <label>Keterangan (Opsional)</label>
                </div>
                @if ($isFilled)
                    <div class="text-end">
                        <button class="btn btn-dark">Simpan</button>
                    </div>
                @endif
            </form>
        </div>
    @endvolt
</div>
