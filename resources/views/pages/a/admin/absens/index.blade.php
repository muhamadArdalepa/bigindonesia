<?php
use App\Models\User;
use App\Models\Absen;
use function Livewire\Volt\{state, computed, on, mount};

state([
    'search', 
    'date' => date('Y-m-d'), 
    'region_id' => fn()=>auth()->user()->region_id,
    'badges' => [[['H','adir'],'success'],[['T','erlambat'],'warning'],[['A','lpa'],'danger']],
    'absen_id',
]);

$regions = computed(fn()=>\App\Models\Region::select('id', 'name')->get());

$users = computed(function () {
    $users = User::select('id', 'name', 'picture', 'isActive','isLate')
        ->role('Karyawan')
        ->where('name', 'LIKE', "%$this->search%")
        ->where('region_id', $this->region_id)
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
                array_push($details, $detail ? $detail->format('H:i') : null);
            }
            $absen->details = $details;
            $user->absen = $absen;
            return $user;
        }
    });
    return $users;
});

$activateAbsen = function ($user_id) {
    try {
        throw new Exception("Error Processing Request");
        Absen::create(['user_id'=>$user_id]);
        $this->dispatch('fire-success', message:'berhasil');
    } catch (\Throwable $th) {
        $this->dispatch('fire-failed', message:'berhasil', errors:$th->getMessage());
    }
}
?>
<x-layouts.app>
    @volt
    <div>
        <div class="card">
            <div class="card-header p-3 p-md-4 pb-0 justify-start gap-3">
                <h5 class="m-0">List Absensi</h5>
                <div class="ms-auto">
                    <input type="date" wire:model.change="date" class="form-control">
                </div>
                <div class="">
                    <select wire:model.change="region_id" class="form-select pe-5">
                        <option value="">Semua Wilayah</option>
                        @foreach ($this->regions as $region)
                        <option value="{{$region->id}}">{{$region->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body p-3 p-md-4">
                <input type="search" wire:model.live="search" class="form-control form-control-sm" placeholder="Cari Nama Karyawan. . .">
                <div class="table-responsive" id="table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center text-md-start">Nama</th>
                                <th class="text-center">
                                    <div class="d-inline-flex align-items-center">
                                        <span>S</span>
                                        <span class="d-none d-md-inline" style="margin-left: .5px">tatus</span>
                                    </div>
                                </th>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDailyAbsen">
                            @foreach ($this->users as $user)
                            <tr class="cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapse{{$user->id}}">
                                <td class="border-bottom-0 text-center text-md-start">
                                    <div class="d-inline-flex align-items-center flex-column flex-md-row gap-2">
                                        <img src="{{asset($user->picture)}}" class="avatar avatar-sm">
                                        <div style="white-space: initial" class="lh-sm">
                                            {{$user->name}}
                                        </div>
                                    </div>
                                </td>
                                @php $n = 0; @endphp
                                    @if ($user->absen)
                                        <td class="border-bottom-0 text-center">
                                            @if ( $user->absen->created_at->isToday())
                                                <span class="badge d-inline-flex align-items-center bg-gradient-{{$badges[$user->isActive ? ($user->isLate ? 1 : 0) :  2][1]}}">
                                                    @php $status = $badges[($user->isActive ? ($user->isLate ? 1 : 0) :  2)][0]  @endphp
                                                    {{$status[0]}}
                                                </span>
                                            @else
                                                <span class="badge d-inline-flex align-items-center bg-gradient-{{$badges[$user->absen->status - 1][1]}}">
                                                    @php $status = $badges[$user->absen->status - 1][0]  @endphp
                                                    <span>{{$status[0]}}</span>
                                                    <span class="d-none d-md-inline" style="margin-left: .5px">{{$status[1]}}</span>
                                                </span>
                                            @endif
                                        </td>
                                        @for ($i = 0; $i < 4; $i++)
                                        @php if($user->absen->details[$i]) $n++; @endphp
                                        <td class="border-bottom-0 text-center">
                                            <div class="form-check p-0 justify-content-center flex-wrap m-0 d-inline-flex gap-2">
                                                <input class="form-check-input m-0 " type="checkbox" onclick="return false" {{ $user->absen->details[$i] ? 'checked' : null }}>
                                                <label class="custom-control-label m-0">{{ $user->absen->details[$i] ?? null }}</label>
                                            </div>
                                        </td>
                                        @endfor
                                    @else
                                        <td colspan="5" class="text-center border-bottom-0">Tidak ada absensi tanggal ini</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="6" class="p-0 border-top-0" >
                                        <div wire:ignore.self class="collapse" id="collapse{{$user->id}}" data-bs-parent="#tbodyDailyAbsen">
                                            <div class="p-3">
                                                @if ($user->absen)
                                                    <livewire:absens.daily editable :absen_id="$user->absen->id" lazy />
                                                @else
                                                    @if ($date == date('Y-m-d') && (date('H:i') >= Absen::times[0] && date('H:i') < Absen::alpa))
                                                        <div class="bg-light rounded-3 cursor-pointer content-middle flex-column gap-1 lh-1" @click="Question.fire({title: 'Aktifkan Absen?',showLoaderOnConfirm:false})
                                                            .then(result => {
                                                                if (result.isConfirmed) {
                                                                    $wire.activateAbsen({{$user->id}})
                                                                }
                                                            })" style="height: 10rem">
                                                            <span><i class="fa-solid fa-plus-circle fa-lg"></i></span>
                                                            Aktifkan Absen
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $this->users->links('components.pagination') }}
            </div>
        </div>
        <div x-data="{modal: null,absen_id:null}" x-init="modal = new bootstrap.Modal($el)" @modal-show.window="absen_id=$event.detail;modal.show()" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" x-text="absen_id">
                   
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
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
