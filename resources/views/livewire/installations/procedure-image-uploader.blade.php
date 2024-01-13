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
    'picture',
]);

$save = function () {
    $this->validate(['picture' => 'required|image']);
    if ($this->data->picture) {
        Storage::disk('private')->delete($this->data->picture);
    }
    $filename = 'installations/' . Str::kebab($this->data->title) . '/' . Str::random(1) . '/' . Str::random(32) . '.jpeg';
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
    $this->dispatch('picture-added');
};
?>
<div>
    @volt
        <div class="d-flex flex-column flex-md-row gap-3">
            <input type="file" class="d-none" accept="image/*" capture="environment" wire:model.change="picture"
                x-ref="picture">
            <div class="">
                <div class="procedure-image border @error('picture') border-danger @enderror">
                    <div wire:loading.flex wire:target="picture" class="h-100 align-items-center justify-content-center">
                        <div class="spinner-border" role="status"></div>
                    </div>
                    @if (!$data->picture && !$picture)
                        <div wire:loading.remove wire:target="picture" @click="$refs.picture.click()"
                            class="d-flex cursor-pointer align-items-center h-100 justify-content-center">
                            <span><i class="fa-solid fa-camera"></i></span>
                        </div>
                    @else
                        <div class="position-absolute bottom-3 end-3">
                            <button wire:loading.attr="disabled" wire:target="picture" class="btn btn-dark btn-sm "
                                @click="$refs.picture.click()">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            @if ($picture)
                                <button wire:loading.remove wire:target="picture" class="btn btn-success btn-sm"
                                    wire:click="save">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            @endif
                        </div>
                        <img class="h-100 w-100" wire:loading.remove wire:target="picture"
                            src="{{ $picture ? $picture->temporaryUrl() : route('storage', $data->picture) }}"
                            @click="$dispatch('lightbox', '{{ $picture ? $picture->temporaryUrl() : route('storage', $data->picture) }}')">
                    @endif
                </div>
                @error('picture')
                    <div class="text-danger ps-2 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <div class="">{{ $data->title }}</div>
                <div class="text-sm font-weight-light">
                    <i class="fa-solid fa-calendar me-1"></i>
                    {{ $data->updated_at == $data->created_at ? '-' : $data->updated_at->translatedFormat('l, j F Y | H:i') }}
                </div>
                <div class="text-sm font-weight-light">
                    <i class="fa-solid fa-user me-1"></i>
                    {{ $data->user->name ?? '-' }}
                </div>
            </div>

        </div>
    @endvolt
</div>
