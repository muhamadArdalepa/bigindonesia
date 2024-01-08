<?php

use App\Models\InstallationProcedure;
use App\Models\InstallationProcedureDetail;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{computed, state, on, rules, mount};

state([
    'installation' => fn () => $this->installation
])->locked();
state([
    'search',
    'member_ids' => [],
    'leader_id',
    'techy_ids'
]);
$techys = computed(
    fn () => User::select('id', 'name', 'picture')
        ->whereNot('id', $this->leader_id)
        ->whereNotIn('id', $this->member_ids)
        ->where('name', 'like', "%$this->search%")
        ->get(),
);
$leader = computed(fn () => $this->leader_id ? User::select('id', 'name', 'picture')->find($this->leader_id) : null);
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
        $this->leader = $this->leader;
        $this->members = $this->members;
    },
]);
rules([
    'leader_id' => 'required|numeric|exists:users,id',
    'member_ids' => 'array|nullable',
    'member_ids.*' => 'required|numeric|exists:users,id',
]);
$submit = function () {
    $this->validate();
    try {
        DB::beginTransaction();
        $team = Team::create([
            'user_id' => $this->leader_id,
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
            'installation_id'=> $this->installation->id,
            'step' => 1
        ]);


        InstallationProcedureDetail::create([
            'installation_procedure_id' => $procedure->id,
            'title' => 'Foto SN modem'
        ]);
        InstallationProcedureDetail::create([
            'installation_procedure_id' => $procedure->id,
            'title' => 'Foto kabel'
        ]);
        DB::commit();
        $this->dispatch('techy-assigned');
    } catch (\Throwable $th) {
        DB::rollBack();
        $this->dispatch('assigning-failed', errors: $th->getMessage());
    }
};

?>
<div wire:ignore.self class="modal fade" id="assignModal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tugaskan Teknisi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="submit" class="d-flex flex-column gap-3" x-data="{ hasLeader: false }">
                    @if ($this->leader)
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="text-xs font-weight-bolder lh-1">Ketua</div>
                        </div>
                        <div class="list-group-item list-group-item-action cursor-pointer gap-2 align-items-center"
                            x-data="{ hover: false }" @mouseover="hover=true" @mouseout="hover=false"
                            @click="hasLeader=false;$wire.leader_id=null;$dispatch('selected')">
                            <img src="https://dummyimage.com/1:1X300" class="avatar avatar-sm" alt="">
                            <div>{{ $this->leader->name }}</div>
                            <div class="ms-auto text-xs" x-show="hover">Hapus</div>
                        </div>
                    </div>
                    @endif
                    @if (count($this->members) > 0)
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="text-xs font-weight-bolder lh-1">Anggota</div>
                        </div>
                        @foreach ($this->members as $member)
                        <div class="list-group-item list-group-item-action cursor-pointer gap-2 align-items-center"
                            x-data="{ hover: false }" @mouseover="hover=true" @mouseout="hover=false"
                            @click="$wire.member_ids=$wire.member_ids.filter(id => id != {{ $member->id }});$dispatch('selected')">
                            <img src="https://dummyimage.com/1:1X300" class="avatar avatar-sm" alt="">
                            <div>{{ $member->name }}</div>
                            <div class="ms-auto text-xs" x-show="hover">Hapus</div>
                        </div>
                        @endforeach

                    </div>
                    @endif
                    <div class="">

                        <input type="search" wire:model.live.debounce="search"
                            class="form-control @if($errors->any()) is-invalid @endif" placeholder="Cari Teknisi" />
                        <div class="invalid-feedback ps-2 text-xs">
                            @foreach ($errors->all() as $error)
                            <div class="">{{$error}}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="list-group">
                        @foreach ($this->techys as $techy)
                        <div class="list-group-item list-group-item-action cursor-pointer align-items-center gap-2"
                            @mouseover="hover=true" @mouseout="hover=false" @click="if(!hasLeader){
                                        hasLeader=true;
                                        $wire.leader_id={{ $techy->id }};
                                    }else{
                                        $wire.member_ids.push({{ $techy->id }});
                                    }
                                    $dispatch('selected')" x-data="{
                                        hover: false,
                                    }">
                            <img src="" class="avatar avatar-sm" alt="">
                            <div class="">{{ $techy->name }}</div>
                            <div class="ms-auto text-xs" x-show="hover"
                                x-text="!hasLeader ? 'Pilih Ketua' : 'Pilih Anggota'"></div>
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
            document.querySelector('button[data-bs-dismiss="modal"]').click()
            Success.fire('Teknisi berhasil ditugaskan')
        })
        $wire.on('assigning-failed', (e) => {
            console.log(e.errors);
            Failed.fire('Menugaskan teknisi gagal')
        })
    </script>
    @endscript
    @endvolt
</div>