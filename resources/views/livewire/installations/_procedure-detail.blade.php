<?php
use App\Models\InstallationProcedure;
use function Livewire\Volt\{computed, state, on,rules};
state([
    'id' => fn() => $this->id,
])->reactive();

$procedure = computed(fn() => InstallationProcedure::find($this->id));
// rules
$submit = function () {
    dd($this->procedure->details);
};
?>
<div>
    @volt
        <div>
            <form wire:submit.prevent="submit">
                @foreach ($this->procedure->details as $detail)
                    <input type="text" wire:model="{{$detail->id}}" class="form-control">
                @endforeach
                <button class="btn">Haha{{ $this->procedure->title }}</button>
            </form>
        </div>
    @endvolt
</div>
