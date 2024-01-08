<?php
use function Livewire\Volt\{computed, state, on};

state([
    'procedures' => fn() => $this->procedures,
    'procedure' => fn() => $this->procedures->last(),
    'step' => fn() => $this->procedure->step,
]);

on([
    'set-step' => function ($step) {
        $this->step = $step;
        $this->procedure = $this->procedures->where('step',$step)->first();
    },
]);
?>
<div class="">
    @volt
        <div class="d-flex bg-light p-2 rounded-3">
            <div class="d-flex flex-column w-100 my-3">
                @foreach ($procedures as $proc)
                    <div class="procedure-item {{ $proc->is_done ? 'done' : 'process' }}"
                        :class="$wire.step == {{ $proc->step }} ? 'active' : ''"
                        @click="$wire.step = {{ $proc->step }};
                                $dispatch('set-step',{
                                    step:{{ $proc->step }}
                                })">
                        <div class="procedure-item-icon">
                            <div></div>
                            <i class="fa-solid fa-{{ $proc->is_done ? 'circle-check' : 'gear fa-spin' }} lh-1 "></i>
                            <div></div>
                        </div>
                        <div class="p-3 lh-1">
                            <div class="">{{ $proc->title }}</div>
                            <div class="text-sm">{{ $proc->created_at->translatedFormat('j F Y | H:i') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-100 p-3 bg-white rounded-3">
                @if ($step == 1)<livewire:installations.procedure-detail-1 :procedure="$procedure" />@endif
            </div>
        </div>
    @endvolt
</div>
