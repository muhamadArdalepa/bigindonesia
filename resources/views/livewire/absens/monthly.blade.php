<?php
use App\Models\Absen;
use Carbon\Carbon;
use function Livewire\Volt\{state, computed, on, mount};

state([
    'n' => date('n'),
    'Y' => date('Y'),
    'status' => ['success', 'warning', 'danger'],
    'temp' => 1,
]);

$N = computed(
    fn() => Carbon::createFromFormat('n/Y', $this->n . '/' . $this->Y)
        ->endOfMonth()
        ->format('j'),
);

$week = computed(fn() => (int) floor($this->N / 7) + 1);
$start = computed(fn() => (int) Carbon::createFromFormat('j/n/Y', '1/' . $this->n . '/' . $this->Y)->format('N'));
$analytics = computed(function () {
    $absen = auth()
        ->user()
        ->absens()
        ->whereMonth('created_at', $this->n)
        ->whereYear('created_at', $this->Y)
        ->get();
    return [
        'h' => $absen->where('status', 1)->count(),
        'l' => $absen->where('status', 2)->count(),
        'a' => $absen->where('status', 3)->count(),
    ];
});

?>
<div>
    @volt
        <div class="card mt-4" x-data="{ selected: null }">
            <div class="card-header flex-wrap">
                <h5 class="m-0 flex-grow-1">
                    Rekap Bulanan
                </h5>
                <div class="flex-grow-1 d-flex gap-3">
                    <select class="form-select" wire:model.change="n" @change="$wire.$refresh()">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select class="form-select" wire:model.change="Y">
                        @for ($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="card-body overflow-hidden" >
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">M</th>
                            <th class="text-center">S</th>
                            <th class="text-center">S</th>
                            <th class="text-center">R</th>
                            <th class="text-center">K</th>
                            <th class="text-center">J</th>
                            <th class="text-center">S</th>
                        </tr>
                    </thead>
                    <tbody>

                        @for ($i = 0; $i < $this->week; $i++)
                            <tr>
                                @for ($j = 0; $j < 7; $j++)
                                    @if ($this->start != 7 && ($j < $this->start && $i == 0))
                                        <td class="py-4 px-0 text-sm bg-light"></td>
                                    @else
                                        @if ($temp <= $this->N)
                                            @if ($absen = auth()->user()->absens()->whereDate('created_at', "$Y-$n-$temp")->first())
                                                <td class="py-4 px-0 text-sm text-center text-white bg-gradient-{{ $absen->created_at->isToday() && (date('H:i') >= Absen::times[0] && date('H:i') < Absen::max)
                                                    ? $status[auth()->user()->isActive ? (auth()->user()->isLate ? 0 : 1) : 2]
                                                    : $status[$absen->status - 1] }}"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal"
                                                    @click="selected = {{ $absen->id }}">
                                                    <span
                                                        class="p-1 rounded-1 {{ Carbon::createFromFormat('Y/n/j', "$Y/$n/$temp")->isToday() ? 'bg-gradient-primary text-white' : '' }}">
                                                        {{ $temp }}
                                                    </span>
                                                </td>
                                            @else
                                                <td class="py-4 px-0 text-sm text-center">
                                                    <span
                                                        class="p-1 rounded-1 {{ Carbon::createFromFormat('Y/n/j', "$Y/$n/$temp")->isToday() ? 'bg-gradient-primary text-white' : '' }}">
                                                        {{ $temp }}
                                                    </span>
                                                </td>
                                            @endif
                                            @php $temp++; @endphp
                                        @else
                                            <td class="py-4 px-0 text-sm bg-light"></td>
                                        @endif
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <div class="d-flex flex-column flex-md-row gap-4 flex-wrap">
                    <div class="lh-base d-flex align-items-center gap-2">
                        <span class="badge bg-gradient-success">{{$this->analytics['h']}}</span>
                        <span>Hadir</span>
                    </div>
                    <div class="lh-base d-flex align-items-center gap-2">
                        <span class="badge bg-gradient-warning">{{$this->analytics['l']}}</span>
                        <span>Terlambat</span>
                    </div>
                    <div class="lh-base d-flex align-items-center gap-2">
                        <span class="badge bg-gradient-danger">{{$this->analytics['a']}}</span>
                        <span>Tidak Hadir</span>
                    </div>
                </div>
            </div>
            <x-absens.modal />
        </div>
    @endvolt
</div>
