<?php

use App\Models\Installation;
use App\Models\Modem;
use App\Models\Odp;
use Illuminate\Support\Facades\DB;

use function Livewire\Volt\{computed, on, state};

state([
    'status' => 1,
    'order' => fn() => $order,
    'search',
    'odp_id',
    'distance',
]);

$odps = computed(function () {
    $order = $this->order;
    return Odp::select('id', 'name')
        ->whereHas('odc', function ($query) use ($order) {
            $query->where('server_id', $order->customer->server_id);
        })
        ->where('name', 'LIKE', "%$this->search%")
        ->get();
});

$submit = function () {
    $this->validate([
        'status' => 'required|in:1,2,3',
    ]);

    if ($this->status == 1) {
        $this->validate([
            'odp_id' => 'required',
            'distance' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
            $modem = Modem::create([
                'odp_id'=>$this->odp_id,
                'distance'=>$this->distance,
            ]);

            $this->order->customer->modem_id = $modem->id;
            $this->order->customer->save();

            $this->order->verifier_id = auth()->user()->id;
            $this->order->status = $this->status;
            $this->order->save();

            Installation::create([
                'order_id' => $this->order->id,
            ]);
            DB::commit();
            $this->dispatch('order-verified');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('verif-failed', errors: $th->getMessage());
        }
    }else{
        $this->order->verifier_id = auth()->user()->id;
        $this->order->status = $this->status;
        $this->order->save();
    }
};

?>
<div wire:ignore.self class="modal fade" id="verifModal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content  overflow-visible">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Verifikasi Calon User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  overflow-visible">
                    <form wire:submit.prevent="submit">
                        <div class="form-floating has-validation">
                            <select id="status" class="form-select @error('status') is-invalid @enderror"
                                wire:model.change="status">
                                <option value="1">Tercover</option>
                                <option value="2">Tidak Tercover</option>
                                <option value="3">Tarik Jalur</option>
                            </select>
                            <label for="status">Status</label>
                            <div class="invalid-feedback ps-2 text-xs">
                                @error('status')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        @if ($status == 1)
                            <div class="position-relative form-floating has-validation" x-data={focus:false}>
                                <input class="form-control  @error('odp_id') is-invalid @enderror"
                                    wire:loading.attr="disabled" wire:target="status" @focus="focus = true"
                                    @click.outside="focus=false" type="search" wire:model.live.debounce="search"
                                    placeholder="Cari ODP" x-ref="search">
                                <label for="odp_id">ODP</label>
                                <div x-show="focus" class="z-index-1 list-group position-absolute overflow-auto w-100"
                                    style="max-height: 20rem !important" wire:loading.remove>
                                    @forelse ($this->odps as $odp)
                                        <div class="cursor-pointer list-group-item list-group-item-action"
                                            @click="$wire.odp_id = {{ $odp->id }};$refs.search.value = '{{ $odp->name }}'">
                                            {{ $odp->name }}
                                        </div>
                                    @empty
                                        <div class="list-group-item disabled">
                                            Tidak ada data
                                        </div>
                                    @endforelse
                                </div>
                                <div class="list-group position-absolute w-100 z-index-1" wire:loading wire:target="search">
                                    <div class="list-group-item">
                                        <i class="fa-solid fa-spin fa-spinner me-1"></i>
                                        Mendapatkan data...
                                    </div>
                                </div>
                                <div class="invalid-feedback ps-2 text-xs">
                                    @error('odp_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-floating has-validation">
                                <input type="number" id="distance" wire:model="distance"
                                    class="form-control @error('distance') is-invalid @enderror" placeholder="Tarikan">
                                <label for="distance">Tarikan</label>
                                <div class="invalid-feedback ps-2 text-xs">
                                    @error('distance')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        @endif
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
                $wire.on('order-verified', () => {
                    document.querySelector('button[data-bs-dismiss="modal"]').click()
                    Success.fire('Verifikasi Berhasil')
                })
                $wire.on('verification-failed', () => {
                    Failed.fire('Verifikasi Gagal')
                })
            </script>
        @endscript
    @endvolt
</div>
