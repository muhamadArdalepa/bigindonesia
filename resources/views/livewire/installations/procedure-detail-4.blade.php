<?php
use App\Models\Odp;
use Illuminate\Support\Facades\DB;
use App\Models\InstallationProcedure;
use App\Models\InstallationProcedureDetail;
use function Livewire\Volt\{state, on};

state([
    'procedure' => fn() => $this->procedure,
    'form' => fn() => $this->procedure->details[0],
    'user' => fn() => $this->procedure->details[1],
    'desc',
    'isFilled' => fn() => $this->form->picture && $this->user->picture,
]);
on([
    'picture-added' => function () {
        if ($this->form->picture && $this->user->picture) {
            $this->isFilled = true;
        }
    },
]);

$save = function () {
    try {
        DB::beginTransaction();
        $this->procedure->desc = $this->desc;
        $this->procedure->is_done = true;
        $this->procedure->save();
        $this->procedure->installation->status = 2;
        $this->procedure->installation->save();

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
        <div class="d-flex gap-4 flex-column">
            <livewire:installations.procedure-image-uploader :data="$form" />
            <livewire:installations.procedure-image-uploader :data="$user" />
            <form wire:submit="save">
                @if ($isFilled)
                    <div class="text-end">
                        <button class="btn btn-dark">Simpan</button>
                    </div>
                @endif
            </form>
        </div>
    @endvolt
</div>
