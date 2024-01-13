<?php
use App\Models\Odp;
use Illuminate\Support\Facades\DB;
use App\Models\InstallationProcedure;
use App\Models\InstallationProcedureDetail;
use function Livewire\Volt\{computed, state, on, rules, usesFileUploads, mount};

usesFileUploads();

state([
    'procedure' => fn() => $this->procedure,
    'fisik' => fn() => $this->procedure->details[0],
    'port' => fn() => $this->procedure->details[1],
    'output' => fn() => $this->procedure->details[2],
    'odp' => fn() => Odp::find($this->procedure->installation->order->customer->modem->odp_id),
    'not_avail' => fn() => $this->odp->modems
        ->whereNotNull('port')
        ->pluck('port')
        ->toArray(),
    'm_port' => fn() => $this->procedure->installation->order->customer->modem->port,
    'desc'=> fn() => $this->procedure->desc,
    'isFilled' => fn() => $this->fisik->picture && $this->port->picture && $this->output->picture,
]);
on([
    'picture-added' => function () {
        if ($this->fisik->picture && $this->port->picture && $this->output->picture) {
            $this->isFilled = true;
        }
    },
]);

rules([
    'm_port' => 'required|numeric',
]);

$save = function () {
    $this->validate();
    try {
        DB::beginTransaction();
        $this->procedure->installation->order->customer->modem->port = $this->m_port;
        $this->procedure->installation->order->customer->modem->save();

        $this->procedure->desc = $this->desc;

        if (!$this->procedure->is_done) {
            $this->procedure->is_done = true;
            $new_proc = InstallationProcedure::create([
                'installation_id' => $this->procedure->installation->id,
                'title' => 'Instalasi Pada Rumah User',
                'step' => 3,
            ]);

            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title' => 'Foto Rumah User',
            ]);
            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title' => 'Foto Letak Modem',
            ]);
            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title' => 'Foto OPM User',
            ]);
            InstallationProcedureDetail::create([
                'installation_procedure_id' => $new_proc->id,
                'title' => 'Foto Panjang Kabel Akhir',
            ]);
        }
        $this->procedure->save();
        DB::commit();
        $this->dispatch('procedure-updated');
    } catch (\Throwable $th) {
        DB::rollBack();
        $this->dispatch('procedure-fails');
    }
};

?>
<div>
    @volt
        <div class="d-flex gap-3 flex-column">
            <livewire:installations.procedure-image-uploader :data="$fisik" />
            <livewire:installations.procedure-image-uploader :data="$port" />
            <livewire:installations.procedure-image-uploader :data="$output" />
            <form wire:submit="save">
                <div class="form-floating has-validation">
                    <select class="form-select  @error('m_port') is-invalid @enderror" wire:model="m_port">
                        <option>-- Pilih Port ODP --</option>
                        @for ($i = 1; $i <= $odp->splitter; $i++)
                            <option value="{{ $i }}" {{ in_array($i, $not_avail) ? 'disabled' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                    <label>Port ODP</label>
                    <div class="invalid-feedback">
                        @error('m_port')
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
