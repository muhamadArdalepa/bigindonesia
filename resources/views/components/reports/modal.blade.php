<?php

use App\Models\Report;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use function Livewire\Volt\{computed, on, state, usesFileUploads, rules};

usesFileUploads();

state([
    'customer', 
    'search', 
    'report_types' => ['Gangguan', 'Ganti Password', 'Pemutusan', 'Pindah Alamat', 'Lainnya'], 
    'report_type' => fn()=> $this->report_types[0], 
    'pictures' => [],
    'picture' => [],
    'desc',
]);

$customers = computed(
    fn() => Customer::where(['status' => 1, 'has_report' => false, 'region_id' => auth()->user()->region_id])
        ->where('name', 'LIKE', "%$this->search%")
        ->orWhere('number', 'LIKE', "%$this->search%")
        ->orderBy('name')
        ->limit(10)
        ->get(),
);

$select_customer = function($customer_id){
    $this->customer = Customer::find($customer_id);
};
$deselect_customer = function(){
    $this->customer = null;
};
$add_picture = function () {
    count($this->picture) > 0 ? $this->pictures = array_merge($this->pictures, $this->picture) : null;
    $this->picture = [];
};



$submit = function () {
    if ($this->report_type == 'Gangguan') {
        $this->validate([
                'pictures' => 'array',
                'pictures.*' => 'image',
                'pictures.*' => 'image',
                'desc' => 'required'
        ]);
        $this->add_picture();
        $filenames = '';
        if (count($this->pictures) > 0) {
            $manager = new ImageManager(new Driver());
            foreach ($this->pictures as $picture) {
                $filename = 'installations/' . Str::kebab($this->data->title) . '/' . Str::random(1) . '/' . Str::random(32) . '.jpeg';
                $encoded = $manager
                    ->read($picture)
                    ->scaleDown(width: 1080)
                    ->toJpeg(50);
                Storage::disk('private')->put($filename, $encoded);
            }
        }
        Report::create([
            'customer_id'=>$this->customer->id,
            'cs_id'=>auth()->user()->id,
            'report_type'=>$this->report_type,
        ]);
    }
    try {
        DB::beginTransaction();

        DB::commit();
        $this->dispatch('order-created');
        $this->reset();
    } catch (\Throwable $th) {
        $this->dispatch('order-failed', errors: $th->getMessage());
    }
};

?>
<div wire:ignore.self class="modal fade" id="Modal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Laporan</h1>
                <span class="p-2 cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"> </i>
                </span>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="submit">
                    @if (!$customer)
                    <input type="search" wire:model.live.debounce="search" class="form-control"
                        placeholder="Cari Teknisi" />

                    <div class="list-group">
                        @foreach ($this->customers as $customers_val)
                        <div class="list-group-item list-group-item-action cursor-pointer"
                            wire:click="select_customer({{ $customers_val->id }})">
                            <div class="text-sm font-weight-bold">{{ $customers_val->number }}</div>
                            <div class="">{{ $customers_val->name }}</div>
                            <div class="text-sm">{{ $customers_val->address }}</div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="list-group mb-3">
                        <div class="list-group-item d-flex">
                            <div class="me-auto">
                                <div class="text-sm font-weight-bold">{{ $customer->number }}</div>
                                <div class="">{{ $customer->name }}</div>
                                <div class="text-sm">{{ $customer->address }}</div>
                            </div>
                            <sapn class="cursor-pointer p-2 align-self-start" wire:click="deselect_customer">
                                <i class="fa-solid fa-xmark"></i>
                            </sapn>
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <select class="form-select" wire:model.change="report_type">
                            @foreach ($report_types as $val)
                            <option value="{{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                        <label>Jenis Laporan</label>
                    </div>


                    {{-- memiliki picture --}}
                    @if( in_array($report_type,['Gangguan','Lainnya']))
                    <div class="form-floating has-validation">
                        <input type="text" wire:model="desc" class="form-control @error('desc') is-invalid @enderror" placeholder="desc">
                        <label>Keterangan</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('desc')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <input type="file" class="d-none" accept="image/*" wire:model.change="picture" x-ref="picture" multiple>
                    <label class="mb-0 ms-3">Gambar (Opsional)</label>
                    <div class="flex-wrap d-flex">
                        @foreach ($pictures as $pictures_val)
                        <div class="p-2 w-50" style="height: 10rem">
                            <div class="rounded-3 overflow-hidden h-100">
                                <img @click="$dispatch('lightbox','{{ $pictures_val->temporaryUrl() }}')"
                                    src="{{ $pictures_val->temporaryUrl() }}"
                                    style="height: 100%;width: 100%;object-fit: cover">
                            </div>
                        </div>
                        @endforeach
                        @if ($picture)
                            @foreach($picture as $pics)
                            <div class="p-2 w-50" style="height: 10rem">
                                <div class="rounded-3 overflow-hidden h-100">
                                    <img @click="$dispatch('lightbox','{{ $pics->temporaryUrl() }}')"
                                        src="{{ $pics->temporaryUrl() }}"
                                        style="height: 100%;width: 100%;object-fit: cover">
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <div class="p-2 w-50" style="height: 10rem">
                            <div class="border rounded-3 d-flex flex-column align-items-center justify-content-center h-100"
                                @click="$wire.add_picture(); $refs.picture.click()"
                                wire:target="picture">
                                <i class="fa-solid fa-image fa-lg"></i>
                            </div>
                        </div>
                    </div>
                    @endif
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
    @push('modal')
    <x-lightbox />
    @endpush
    @endvolt
</div>