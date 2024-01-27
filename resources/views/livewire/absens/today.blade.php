<?php
use App\Models\Absen;
use function Livewire\Volt\{state, computed, on};

state([
    'absen' => fn() => $this->absen,
    'absen_details' => fn() => $this->absen->absen_details,
    'status' => function () {
        if (auth()->user()->isActive) {
            if (date('H:i') >= Absen::times[0] && date('H:i') < Absen::max) {
                return auth()->user()->isLate ? ['warning', 'Terlambat'] : ['success', 'Hadir'];
            }
            return [['success','Hadir'],['warning', 'Terlambat'],['danger', 'Alpa']][$this->absen->status - 1];
        }
        return ['danger', 'Alpa'];
    },
]);

?>
@volt
    <div class="card">
        <div class="card-header">
            <h5 class="m-0">
                Absen Hari Ini
            </h5>
            <span class="badge bg-gradient-{{ $status[0] }}">{{ $status[1] }}</span>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row gap-3 align-items-stretch">
                <x-absens.daily :details="$absen_details" />
            </div>
        </div>
    </div>
@endvolt
