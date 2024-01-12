<?php
use App\Models\InstallationProcedure;
use function Livewire\Volt\{computed, state, on};

state([
    'id' => fn() => $this->id,
])->locked();
$procedures = computed(fn() => InstallationProcedure::where('installation_id', $this->id)->get());
state([
    'procedure' => fn() => $this->procedures->last(),
    'step' => fn() => $this->procedure->step,
]);

on([
    'set-step' => function ($step) {
        $this->step = $step;
        $this->procedure = $this->procedures->where('step', $step)->first();
    },
    'procedure-updated' => function () {
        $this->procedures = $this->procedures;
        $this->procedure = $this->procedures->last();
        $this->step = $this->procedure->step;
    },
]);
?>
<div class="">
    @volt
        <div class="d-flex bg-light p-2 rounded-3" x-data="{ open: false, width: window.innerWidth }">
            <div class="flex-column my-3 d-flex w-100" x-show.important="!open || width > 768" x-transition:enter.delay.1ms>
                @foreach ($this->procedures as $proc)
                    <div class="procedure-item {{ $proc->is_done ? 'done' : 'process' }}"
                        :class="$wire.step == {{ $proc->step }} ? 'active' : ''"
                        @click="$wire.step = {{ $proc->step }};
                                $dispatch('set-step',{
                                    step:{{ $proc->step }}
                                });
                                open=true;
                                ">
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

            <div class="w-100 px-2 pt-1 bg-white rounded-3" x-show="open  || width > 768" x-transition:enter.delay.1ms>
                <div class="d-flex justify-content-between align-items-center d-md-none">

                    <button class="btn btn-link link-dark p-2" @click="open=false">
                        <i class="fa-solid fa-chevron-circle-left"></i>
                        Kembali
                    </button>

                    <div class="text-sm">{{ $procedure->title }}</div>
                </div>

                <div wire:loading wire:target="step" class="w-100" style="height: 20rem">
                    <div class="d-flex justify-content-center align-items-center w-100 h-100">
                        <div class="spinner-border" role="status">
                        </div>
                    </div>
                </div>
                <div class="p-3" wire:loading.remove wire:target="step">
                    @switch($step)
                        @case(1)
                            <livewire:installations.procedure-detail-1 :procedure="$procedure" />
                        @break

                        @case(2)
                            <livewire:installations.procedure-detail-2 :procedure="$procedure" />
                        @break

                        @case(3)
                            <livewire:installations.procedure-detail-3 :procedure="$procedure" />
                        @break

                        @case(4)
                            <livewire:installations.procedure-detail-4 :procedure="$procedure" />
                        @break

                        @default
                    @endswitch
                </div>
            </div>
        </div>
    @endvolt
</div>
