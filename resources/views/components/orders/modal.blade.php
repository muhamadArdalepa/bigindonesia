<?php

use App\Models\Order;
use App\Models\Packet;
use App\Models\Server;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use function Livewire\Volt\{computed, on, state, usesFileUploads, rules};

usesFileUploads();

$packets = computed(
    fn () => Packet::select('id', 'name', 'price')
        ->where('server_id', $this->server_id)
        ->get(),
);
$servers = computed(
    fn () => Server::select('id', 'name')
        ->where('region_id', auth()->user()->region_id)
        ->get(),
);

state([
    'server_id' => fn () => $this->servers[0]->id,
    'packet_id' => fn () => $this->packets[0]->id,
    'name',
    'nik',
    'phone',
    'coordinate',
    'address',
    'ktp_picture',
    'house_picture',
]);

on(['change-server' => fn () => ($this->packets = $this->packets)]);

rules(
    fn () => [
        'server_id' => 'required|exists:servers,id',
        'packet_id' => 'required|exists:packets,id',
        'name' => 'required|max:255',
        'nik' => 'required|numeric|digits:16',
        'phone' => 'required|min:11|max:15',
        'coordinate' => ['required', 'regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/', 'max:255'],
        'address' => 'required|max:255',
        'ktp_picture' => 'required|image|mimes:jpg,png,jpeg,bmp',
        'house_picture' => 'required|image|mimes:jpg,png,jpeg,bmp',
    ],
);
$submit = function () {
    $validated = $this->validate();
    try {
        if ($this->ktp_picture || $this->house_picture)  $manager = new ImageManager(new Driver());
        if ($this->ktp_picture) {
            $ktp_filename = Str::random(32);
            $ktp_dir = Str::random(1);
            $ktp_encoded = $manager->read($this->ktp_picture)->toJpeg(50);
            Storage::disk('private')->put("customers/ktp/$ktp_dir/$ktp_filename.jpeg", $ktp_encoded);
            $validated['ktp_picture'] = "customers/ktp/$ktp_dir/$ktp_filename.jpeg";
        }
        if ($this->house_picture) {
            $house_filename = Str::random(32);
            $house_dir = Str::random(1);
            $house_encoded = $manager->read($this->house_picture)->toJpeg(50);
            Storage::disk('private')->put("customers/house/$house_dir/$house_filename.jpeg", $house_encoded);
            $validated['house_picture'] = "customers/house/$house_dir/$house_filename.jpeg";
        }

        DB::beginTransaction();
        $validated['region_id'] = auth()->user()->region_id;
        $validated['status'] = 0;

        $customer = Customer::create($validated);
        $last_id = Order::whereDate('created_at', now())
            ->latest()
            ->pluck('id')
            ->first();

        if ($last_id) {
            $last_id = str_split($last_id, 9);
            $order_id = 'O' . date('Ymd') . str_pad((int) $last_id[1] + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $order_id = 'O' . date('Ymd') . '001';
        }

        Order::create([
            'id' => $order_id,
            'customer_id' => $customer->id,
            'marketer_id' => auth()->user()->id,
            'status' => 0,
        ]);
        DB::commit();
        $this->dispatch('order-created');
        $this->reset();
    } catch (\Throwable $th) {
        DB::rollBack();
        if (Storage::disk('private')->exists($validated['ktp_picture'])) {
            Storage::disk('private')->delete($validated['ktp_picture']);
        }
        if ($this->house_picture) Storage::disk('private')->delete("customers/house/$house_dir/$house_filename.jpeg");
        $this->dispatch('order-failed', errors: $th->getMessage());
    }
};

?>
<div wire:ignore.self class="modal fade" id="Modal" tabindex="-1" @hide-bs-modal.dot="$wire.$refresh()">
    @volt
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Penjualan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="submit">
                    <div class="form-floating has-validation">
                        <select id="server_id" class="form-select @error('server') is-invalid @enderror" wire:model="server_id" wire:change="$dispatch('change-server')">
                            @foreach ($this->servers as $server)
                            <option value="{{ $server->id }}">{{ $server->name }}</option>
                            @endforeach
                        </select>
                        <label for="server_id">Zona</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('server_id')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <select id="packet_id" class="form-select @error('packet_id') is-invalid @enderror" wire:model="packet_id" wire:loading.attr="disabled" wire:target="server_id">
                            @foreach ($this->packets as $packet)
                            <option value="{{ $packet->id }}">{{ $packet->name }}</option>
                            @endforeach
                        </select>
                        <label for="packet_id">Paket Pilihan</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('packet_id')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <input id="name" type="text" wire:model.live.debouce="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama">
                        <label for="name">Nama Calon User</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <input id="nik" type="number" wire:model="nik" class="form-control @error('nik') is-invalid @enderror" placeholder="NIK">
                        <label for="nik">NIK</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('nik')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <input id="phone" type="tel" wire:model="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone">
                        <label for="phone">Phone</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('phone')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <input id="coordinate" type="text" wire:model="coordinate" class="form-control @error('coordinate') is-invalid @enderror" placeholder="coordinate">
                        <label for="coordinate">Koordinat</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('coordinate')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-floating has-validation">
                        <textarea type="text" id="address" class="form-control @error('address') is-invalid @enderror" style="height: 7rem" placeholder="Alamat" wire:model="address"></textarea>
                        <label for="address">Alamat</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('address')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="w-100">
                            <label for="">Foto KTP</label>
                            <input type="file" class="d-none" wire:model="ktp_picture" x-ref="ktp_picture">
                            <div class="rounded-3 border overflow-hidden d-flex flex-column align-items-center justify-content-center" style="height: 10rem" @click="$refs.ktp_picture.click()">
                                <div wire:loading.flex wire:target="ktp_picture" class="justify-content-center align-items-center h-100">
                                    <div class="spinner-border"></div>
                                </div>
                                @if ($ktp_picture)
                                <img @click="$dispatch('lightbox','{{ $ktp_picture->temporaryUrl() }}')" src="{{ $ktp_picture->temporaryUrl() }}" style="height: 100%;width: 100%;object-fit: cover">
                                @else
                                <span wire:loading.remove wire:target="ktp_picture"><i class="fa-solid fa-image fa-lg"></i></span>
                                @endif
                            </div>
                            <div class="invalid-feedback ps-2 text-xs">
                                @error('ktp_picture')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-floating" style="height: 12rem">
                        <label for="ktp_picture">Foto KTP</label>
                    </div>
                    <div class="form-floating has-validation">
                        <input type="file" id="ktp_picture" class="form-control form-control-file @error('ktp_picture') is-invalid @enderror" wire:model="ktp_picture" placeholder="Foto KTP">
                    </div>
                    @if ($house_picture)
                    <img src="{{ $house_picture->temporaryUrl() }}" class="w-100 rounded-3">
                    @endif
                    <div class="form-floating has-validation">
                        <input type="file" id="house_picture" class="form-control form-control-file @error('house_picture') is-invalid @enderror" wire:model="house_picture" placeholder="Foto KTP">
                        <label for="house_picture">Foto KTP</label>
                        <div class="invalid-feedback ps-2 text-xs">
                            @error('house_picture')
                            {{ $message }}
                            @enderror
                        </div>
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
        $wire.on('order-created', () => {
            document.querySelector('button[data-bs-dismiss="modal"]').click()
            Success.fire('Order berhasil dibuat')
        })
        $wire.on('order-failed', (event) => {
            console.error(event);
            Failed.fire('ds')
        })
    </script>
    @endscript
    @push('modal')
        <x-lightbox/>
    @endpush
    @endvolt
</div>
