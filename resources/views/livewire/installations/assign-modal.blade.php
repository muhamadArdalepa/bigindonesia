<?php

use App\Models\InstallationProcedure;
use App\Models\InstallationProcedureDetail;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{computed, state, on, rules, mount};

state([
    'installation' => fn() => $this->installation,
])->locked();
state(['search', 'member_ids' => []]);
$techys = computed(
    fn() => User::select('id', 'name', 'picture')
        // ->role('Teknisi')
        // ->where('is_active',true)
        ->whereNot('id', auth()->user()->id)
        ->whereNotIn('id', $this->member_ids)
        ->where('name', 'like', "%$this->search%")
        ->get(),
);
$members = computed(function () {
    $data = [];
    if (count($this->member_ids) > 0) {
        foreach ($this->member_ids as $id) {
            array_push($data, User::select('id', 'name', 'picture')->find($id));
        }
    }
    return $data;
});

on([
    'selected' => function () {
        $this->techys = $this->techys;
        $this->members = $this->members;
    },
]);

rules([
    'member_ids' => 'array|nullable',
    'member_ids.*' => 'required|numeric|exists:users,id',
]);
$submit = function () {
    $this->validate();
    try {
        DB::beginTransaction();
        $team = Team::create([
            'user_id' => auth()->user()->id,
        ]);
        foreach ($this->member_ids as $member) {
            TeamMember::create([
                'team_id' => $team->id,
                'user_id' => $member,
            ]);
        }

        $this->installation->team_id = $team->id;
        $this->installation->status = 1;
        $this->installation->save();

        $procedure = InstallationProcedure::create([
            'installation_id' => $this->installation->id,
            'title' => 'Persiapan',
            'step' => 1,
        ]);

        InstallationProcedureDetail::create([
            'installation_procedure_id' => $procedure->id,
            'title' => 'Foto SN modem',
        ]);
        InstallationProcedureDetail::create([
            'installation_procedure_id' => $procedure->id,
            'title' => 'Foto kabel',
        ]);
        DB::commit();
        $this->dispatch('techy-assigned');
    } catch (\Throwable $th) {
        $this->dispatch('assigning-failed', errors: $th->getMessage());
    }
};

?>
@push('css')
    <style>
        #assignModal .list-group-item {
            display: flex;
        }
    </style>
@endpush
<div wire:ignore.self class="modal fade" id="assignModal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Pilih Rekan Tim</h1>
                    <span class="p-2 cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"> </i>
                    </span>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submit" class="d-flex flex-column gap-3" x-data>
                        @if (count($this->members) > 0)
                            <div class="list-group">
                                @foreach ($this->members as $member)
                                    <div class="list-group-item list-group-item-action cursor-pointer gap-2 align-items-center"
                                        x-data="{ hover: false }" @mouseover="hover=true" @mouseout="hover=false"
                                        @click="$wire.member_ids=$wire.member_ids.filter(id => id != {{ $member->id }});$dispatch('selected')">
                                        <img src="{{ asset($member->picture) }}" class="avatar avatar-sm">
                                        <div>{{ $member->name }}</div>
                                        <div class="ms-auto text-xs" x-show="hover">Hapus</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <input type="search" wire:model.live.debounce="search" class="form-control" placeholder="Cari Teknisi" />
                        <div class="list-group">
                            @foreach ($this->techys as $techy)
                                <div class="list-group-item list-group-item-action cursor-pointer align-items-center gap-2"
                                    @mouseover="hover=true" @mouseout="hover=false"
                                    @click="$wire.member_ids.push({{ $techy->id }});$dispatch('selected')" x-data="{hover: false}">
                                    <img src="{{ asset($techy->picture) }}" class="avatar avatar-sm" alt="">
                                    <div class="">{{ $techy->name }}</div>
                                    <div class="ms-auto text-xs" x-show="hover" x-text="'Pilih Rekan'"></div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark" wire:click="submit()" wire:loading.attr="disabled">
                        <i class="fa-solid fa-spin fa-spinner" wire:loading wire:target="submit"></i>
                        <span class="ms-1">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
        @script
            <script>
                $wire.on('techy-assigned', () => {
                    document.querySelector('[data-bs-dismiss="modal"]').click()
                    Success.fire('Pekerjaan berhasil diambil')
                })
                $wire.on('assigning-failed', (e) => {
                    console.errors(e.errors);
                    Failed.fire('Pekerjaan gagal diambil')
                })
            </script>
        @endscript
    @endvolt
</div>
