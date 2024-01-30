<?php
use App\Models\User;
use function Livewire\Volt\{state, computed, on, mount};

state(['search', 'date' => date('Y-m-d')]);

$users = computed(function () {
    $users = User::select('id', 'name', 'picture')
        ->role('Karyawan')
        ->where('name', 'LIKE', "%$this->search%")
        ->paginate(50);
    $users->map(function ($user) {
        $absen = $user
            ->absens()
            ->select('id', 'status', 'created_at')
            ->whereDate('created_at', $this->date)
            ->first();
        if ($absen) {
            $details = [];
            for ($i = 0; $i < 4; $i++) {
                $detail = $absen
                    ->absen_details()
                    ->select('created_at')
                    ->where('index', $i)
                    ->pluck('created_at')
                    ->first();
                array_push($details, $detail ? $detail->format('H:i') : '--:--');
            }
            $absen->details = $details;
            $user->absen = $absen;
            return $user;
        }
    });
    return $users;
});

?>
<x-layouts.app>
    @volt
        <div class="card">
            <div class="card-header p-3 p-md-4 pb-0">
                <h5 class="m-0">List Absensi</h5>
                <div class="">
                    <input type="date" wire:model.change="date" class="form-control">
                </div>
            </div>
            <div class="card-body p-3 p-md-4">
                <input type="search" wire:model.live="search" class="form-control form-control-sm"
                    placeholder="Cari Nama Karyawan. . .">
                <div class="table-responsive" id="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                                <th class="text-center">Status</th>
                                <th class="freeze"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    @if ($user->absen)
                                    @for ($i = 0; $i < 4; $i++)
                                        <td class="text-center">{{ $user->absen->details[$i] }}</td>
                                        @endfor
                                    <td>{{ $user->absen->status }}</td>

                                    @else
                                        <td colspan="5" class="text-center">Tidak ada absensi tanggal ini</td>
                                    @endif
                                    <th class="freeze"></th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $this->users->links('components.pagination') }}
            </div>
        </div>
        @script
            <script>
                $wire.on('fire-success', (event) => {
                    Success.fire(event.message)
                })
                $wire.on('fire-failed', (event) => {
                    console.error(event.errors)
                    Failed.fire(event.message)
                })
            </script>
        @endscript
    @endvolt
    <x-lightbox />
</x-layouts.app>
