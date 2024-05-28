<?php
use App\Models\Absen;
use function Livewire\Volt\{state, computed, on, boot, mount, booted, hydrate, dehydrate, updating, updated};

state(['string']);

boot(function () {$this->string .= 'boot';});
mount(function () {$this->string .= 'mount';});
booted(function () {$this->string .= 'booted';});
hydrate(function () {$this->string .= 'hydrate';});
dehydrate(function () {$this->string .= 'dehydrate';});
$absen = computed(fn() => auth()->user()->absens()->whereDate('created_at', now())->first());

$must = computed(function () {
    if (!$this->absen) {
        return false;
    }

    $now = now()->format('H:i');
    $details = $this->absen->absen_details;

    // absen pertama
    if ($now >= Absen::times[0] && $now < Absen::alpa && $details->count() == 0) {
        return true;
    }

    if ($details->count() == 0) {
        return false;
    }
    if ($now >= Absen::times[1] && $now < Absen::max) {
        $last = $details->last()->created_at->format('H:i');
        for ($i = 1; $i < 2; $i++) {
            if ($now >= Absen::times[$i] && $last < Absen::times[$i]) {
                return true;
            }
        }
        if ($now >= last(Absen::times) && $last < last(Absen::times)) {
            return true;
        }
    }

    return false;
});

on([
    'absen-success' => function () {
        $this->absen = $this->absen;
        $this->dispatch('fire-success', message: 'Absen Berhasil');
    },
    'absen-selected' => function ($id) {
        $this->absen_id = $id;
        $this->dispatch('show-absen-detail-modal');
    },
]);

?>
<x-layouts.app>
    @volt
        <div>
            {{ $string }}
            @if ($this->must)
                <livewire:absens.create :absen="$this->absen" />
            @else
                <div>
                    @if ($this->absen)
                        <livewire:absens.today :absen="$this->absen" />
                    @endif
                    <livewire:absens.monthly />
                </div>
            @endif
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
                $wire.on('show-absen-detail-modal', () => {
                    const absenDetailModal = new bootstrap.Modal(document.getElementById('absenDetailModal'))
                    absenDetailModal.show()
                });
            </script>
        @endscript
    @endvolt
    <x-lightbox />
</x-layouts.app>
