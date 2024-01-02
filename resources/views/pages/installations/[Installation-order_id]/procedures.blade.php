<?php

use function Livewire\Volt\{mount, state};

state(['installation' => fn () => $this->installation]);

?>

<x-layouts.app>
    @volt
    <div class="card">
        <div class="card-header">
            {{ $installation->id }}
        </div>
        <div class="card-body">

        </div>
    </div>
    @endvolt
</x-layouts.app>
