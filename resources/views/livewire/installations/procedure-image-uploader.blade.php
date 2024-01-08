<?php
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use App\Models\InstallationProcedure;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use function Livewire\Volt\{computed, state, on, rules, usesFileUploads, mount};

usesFileUploads();

state([
    'data' => fn() => $this->data,
    'picture'
]);

// rules
$save = function () {
    if ($this->data->picture) Storage::disk('private')->delete($this->data->picture);
    $filename = 'installations/'.$this->data->title.'/'.Str::random(1).'/'. Str::random(32).'.jpeg';
    $manager = new ImageManager(new Driver());
    $encoded = $manager
        ->read($this->picture)
        ->scaleDown(width: 500)
        ->toJpeg(50);
    Storage::disk('private')->put($filename, $encoded);

    $this->data->picture = $filename;
    $this->data->user_id = auth()->user()->id;
    $this->data->save();
    $this->picture = '';
};

?>
<div>
    @volt
    <div class="d-flex align-items-end gap-3">
        <input type="file" class="d-none" accept="image/*" capture="environment" wire:model.change="picture" x-ref="picture">
        @if (!$data->picture && !$picture)
        <div @click="$refs.picture.click()" style="width: 7rem; height: 7rem;"
            class="d-flex lh-1 cursor-pointer flex-column align-items-center justify-content-center border rounded-3">
            <span><i class="fa-solid fa-camera"></i></span>
            <span class="text-xs text-center">{{$data->title}}</span>
        </div>
        @else
        <div class="procedure-image"
            @click="$dispatch('lightbox', '{{ $picture ? $picture->temporaryUrl() : route('storage', $data->picture) }}')">
            <img wire:loading.remove wire:target="picture" src="{{ $picture ? $picture->temporaryUrl() : route('storage', $data->picture) }}">
            <div wire:loading wire:target="picture" class="h-100 d-flex align-items-center justify-content-center">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>
        @endif
        <div>
            <button @click="$refs.picture.click()" class="ms-auto mb-2 btn btn-sm btn-{{ $data->picture || $picture ? 'secondary' : 'dark'}}">
                <i class="me-1 fa-solid fa-{{ $data->picture || $picture ? 'pen-to-square' : 'plus'}}"></i>
                {{  $data->picture || $picture ? 'Edit' : 'Tambah'}}
            </button>
            @if ($picture)
            <button wire:click="save()" wire:loading.attr="disabled" class="ms-auto mb-2 btn btn-sm bg-gradient-success">
                <i wire:loading.remove wire:target="save()" class="me-1 fa-solid fa-check"></i>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading wire:target="save()"></span>
                <span wire:loading.remove wire:target="save()">Simpan</span>
                <span wire:loading wire:target="save()">Menyimpan...</span>
            </button>
            @endif

            <div class="">{{$data->title}}</div>
            <div class="text-sm font-weight-light">
                <i class="fa-solid fa-calendar me-1"></i>
                {{ $data->updated_at == $data->created_at? '-': $data->updated_at->translatedFormat('l, j F Y | H:i') }}
            </div>
            <div class="text-sm font-weight-light">
                <i class="fa-solid fa-user me-1"></i>
                {{ $data->user->name ?? '-' }}
            </div>
        </div>
    </div>
    @endvolt
</div>