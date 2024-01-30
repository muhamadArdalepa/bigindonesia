<?php

use App\Models\AbsenPlace;
use App\Models\AbsenDetail;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, usesFileUploads, mount};

usesFileUploads();

state([
    'absen' => fn() => $this->absen,
    'index' => function () {
        foreach ($this->absen::times as $i => $time) {
            if ($time >= now()->format('H:i')) {
                return $i - 1;
            }
        }
    },
    'whichAbsen' => fn()=> ['Pertama', 'Kedua', 'Ketiga', 'Keempat'][$this->index],
    'isIphone' => strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone'),
    'coordinate',
    'address',
    'picture',
    'desc',
    'stream',
]);

mount(function () {
    // dd($this->index);
});

$save = function () {
    $filename = 'absens/' . auth()->user()->id . '/' . Str::random(1) . '/' . Str::random(64) . uniqid() . '.jpeg';

    try {
        if ($this->isIphone) {
            $this->validate([
                'picture' => 'image',
            ]);
            $manager = new Intervention\Image\ImageManager(new Intervention\Image\Drivers\Gd\Driver());
            $encoded = $manager
                ->read($this->picture)
                ->scaleDown(width: 1080)
                ->toJpeg(50);
            Storage::disk('public')->put($filename, $encoded);
        } else {
            [$type, $image_parts] = explode(';', $this->picture);
            [, $image_parts] = explode(',', $image_parts);
            $image_base64 = base64_decode($image_parts);
            Storage::disk('public')->put($filename, $image_base64);
        }
        DB::beginTransaction();

        if ($this->whichAbsen == 'Pertama') {
            auth()->user()->isActive = true;
            auth()->user()->isLate = now()->format('H:i') > $this->absen::late ? 1 : 0;
            auth()
                ->user()
                ->save();
        }

        AbsenDetail::create([
            'absen_id' => $this->absen->id,
            'index'=>$this->index,
            'picture' => $filename,
            'coordinate' => $this->coordinate,
            'address' => $this->address,
            'desc' => $this->desc,
        ]);

        if ($this->absen->absen_details->count() > $this->absen::minAbsen) {
            $this->absen->status = auth()->user()->isLate ? 2 : 1;
        }

        $this->absen->save();
        DB::commit();
        $this->dispatch('absen-success');
    } catch (\Throwable $th) {
        dd($th->getMessage());
        $this->dispatch('absen-fails');
    }
};

$setStream = fn($stream) => ($this->stream = $stream);
$setPicture = fn($picture) => ($this->picture = $picture);
$checkPlace = function ($coordinate) {
    $coord = explode(',', $coordinate);
    $places = AbsenPlace::select('coordinate')->pluck('coordinate');
    foreach ($places as $pcoord) {
        $pcoord = explode(',', $pcoord);
        $lat1 = deg2rad($coord[0]);
        $lon1 = deg2rad($coord[1]);
        $lat2 = deg2rad($pcoord[0]);
        $lon2 = deg2rad($pcoord[1]);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $radius_of_earth = 6371000;

        $distance = $radius_of_earth * $c;

        if ($distance <= AbsenPlace::RADIUS) {
            return $coordinate;
        }
    }
    return 'place';
};

$setCoordinate = function ($coordinate) {
    if ($coordinate == 'error') {
        $this->coordinate = $coordinate;
        return;
    }
    if ($this->whichAbsen != 'Pertama' || !auth()->user()->isPlace) {
        $this->coordinate = $coordinate;
        return;
    }
    $this->coordinate = $this->checkPlace($coordinate);
};

$setAddress = fn($address) => ($this->address = $address);
?>
<div>
    @volt
        <div class="d-flex justify-content-center" x-data="{ coordinate: null, picture: null }" x-init="if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async (position) => {
                coordinate = [position.coords.latitude, position.coords.longitude]
                $wire.setCoordinate(position.coords.latitude + ',' + position.coords.longitude);
            }, (error) => {
                $wire.setCoordinate('error');
                console.error(error);
            });
        }">
            <div class="card w-100 w-md-50">
                <div class="card-header">
                    Absen {{ $whichAbsen }}
                    <div class="text-sm">{{ now()->translatedFormat('l, j F Y') }}</div>
                </div>
                <div class="card-body">
                    {{-- @dump($coordinate) --}}
                    @if ($coordinate && !in_array($coordinate, ['error', 'place']))
                        <div class="text-sm"><i class="fa-regular fa-clock me-1"></i>{{ date('H:i') }}</div>
                        <div class="text-sm">
                            <i class="fa-solid fa-location-dot me-1"></i>
                            {{ $coordinate }}
                        </div>
                        <div class="text-sm" x-init="fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${coordinate[0]}&lon=${coordinate[1]}&accept-language=id`)
                            .then(response => response.json())
                            .then(result => { $wire.setAddress(result.display_name) })
                            .catch(error => { $wire.setAddress('Geolocation API Error!') })">
                            <span class="spinner-border spinner-border-sm" x-show="$wire.address == null"></span>
                            {{ $address }}
                        </div>

                        @if (!$isIphone)
                            <div x-init="if (!$wire.isIphone) {
                                navigator.mediaDevices.getUserMedia({ video: true })
                                    .then(async (stream) => {
                                        _stream = stream;
                                        $wire.setStream('success');
                                    }).catch((error) => {
                                        $wire.setStream('error');
                                        console.error(error)
                                    });
                            }">
                                @if (!$stream)
                                    <div style="height: 20rem;" class="flex-column gap-3 content-middle">
                                        <span class="spinner-border"></span>
                                        <div>Mendapatkan Koordinat</div>
                                    </div>
                                @endif
                                @if ($stream == 'success')
                                    <div class="my-2">
                                        @if ($picture)
                                            <img src="{{ $picture }}" class="w-100 rounded-3">
                                        @else
                                            <video x-show="!picture" x-ref="video" x-init="$el.srcObject = await _stream"
                                                class="w-100 rounded-3" style="transform: scaleX(-1)" autoplay>
                                            </video>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button class="btn camera-button"
                                            x-on:click="if(!$wire.picture){
                                                const canvas = document.createElement('canvas');
                                                canvas.width = $refs.video.videoWidth;
                                                canvas.height = $refs.video.videoHeight;
                                                canvas.getContext('2d').scale(-1, 1);
                                                canvas.getContext('2d').drawImage($refs.video, 0, 0, -canvas.width, canvas.height);
                                                $wire.setPicture(canvas.toDataURL('image/jpeg'))
                                                $refs.video.srcObject.getTracks().forEach(track => track.stop());
                                                $refs.video.srcObject = null;
                                            }else {
                                                $wire.setPicture(null)
                                                navigator.mediaDevices.getUserMedia({ video: true })
                                                .then((stream) => {
                                                    $refs.video.srcObject = stream;
                                                });
                                        }">
                                            <i class="fa-solid  fa-xl"
                                                x-bind:class="$wire.picture ? 'fa-arrow-rotate-back' : 'fa-camera'"></i>
                                        </button>
                                    </div>
                                @endif
                                @if ($stream == 'error')
                                    <div class="d-flex flex-column gap-3 align-items-center justify-content-center p-3">
                                        <div @click="window.location.reload()">
                                            <i class="fa-solid fa-arrow-rotate-back fa-xl"></i>
                                        </div>
                                        <div class="">Izinkan Akses Kamera</div>
                                    </div>
                                    <img src="{{ asset('gifs/permission.gif') }}" class="border rounded-3 w-100 my-2">
                                @endif
                            </div>
                        @else
                            <input type="file" class="d-none" wire:model.change="picture" accept=".jpg,.jpeg,.png"
                                capture="user" x-ref="picture">
                            <div @click="$refs.picture.click()"
                                class="overflow-hidden flex-column gap-3 content-middle border rounded-3 my-3">
                                <div class="py-5" wire:loading wire:target="picture">
                                    <span class="spinner-border"></span>
                                </div>
                                @if ($picture)
                                    <img src="{{ $picture->temporaryUrl() }}" class="w-100 h-100"
                                        style="object-fit: contain" wire:loading.remove wire:target="picture">
                                @else
                                    <span wire:loading.remove wire:target="picture" class="py-5">
                                        <i class="fa-solid fa-camera fa-xl"></i>
                                    </span>
                                @endif
                            </div>
                        @endif
                        <input type="text" class="form-control" wire:model.live="desc" placeholder="Keterangan...">
                        @if ($picture && $desc && $coordinate && $address)
                            <button class="btn btn-dark btn-lg mt-3 w-100" wire:click="save" wire:loading.attr="disabled" wire:target="save">
                                <span class="spinner-border spinner-border-sm" wire:loading wire:target="save"></span>
                                Absen
                            </button>
                        @endif
                    @else
                        @if (!$coordinate)
                            <div style="height: 20rem;"
                                class="d-flex flex-column gap-3 align-items-center justify-content-center">
                                <span class="spinner-border"></span>
                                <div>Mendapatkan Koordinat</div>
                            </div>
                        @else
                            @if ($coordinate == 'error')
                                <div class="d-flex flex-column gap-3 align-items-center justify-content-center p-3">
                                    <div @click="window.location.reload()">
                                        <i class="fa-solid fa-arrow-rotate-back fa-xl"></i>
                                    </div>
                                    <div class="">Izinkan Akses GPS dan Kamera</div>
                                </div>
                                <img src="{{ asset('gifs/permission.gif') }}" class="border w-100 rounded-3">
                            @else
                                <div style="height: 20rem;" class="flex-column gap-3 content-middle">
                                    <div @click="window.location.reload()">
                                        <i class="fa-solid fa-arrow-rotate-back fa-xl"></i>
                                    </div>
                                    <div>Absen Pertama Harus Di Kantor!</div>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        @endvolt
    </div>
