<?php
use App\Models\Absen;
use function Livewire\Volt\{state, computed, on};

state([
    'absen' => fn() => $this->absen,
]);

$status = computed(function () {
    if (auth()->user()->isActive) {
        if (date('H:i') >= Absen::times[0] && date('H:i') < Absen::max) {
            return auth()->user()->isLate ? ['warning', 'Terlambat'] : ['success', 'Hadir'];
        }
        return [['success', 'Hadir'], ['warning', 'Terlambat'], ['danger', 'Alpa']][$this->absen->status - 1];
    }
    return ['danger', 'Alpa'];
});

?>
<div>
    @volt
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">
                    Absen Hari Ini
                </h5>
                <span class="badge bg-gradient-{{ $this->status[0] }}">{{ $this->status[1] }}</span>
            </div>
            <div class="card-body">
                <livewire:absens.daily :absen_id="$absen->id" lazy />
            </div>
        </div>
    @endvolt
</div>
