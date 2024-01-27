<?php
use App\Models\Absen;
use function Livewire\Volt\{state, computed, on, mount, placeholder};

state(['absen', 'must' => false]);

$updateAbsen = function () {
    $this->absen = auth()
        ->user()
        ->absens()
        ->whereDate('created_at', now())
        ->first();
    if (!$this->absen) {
        return;
    }
    $now = now()->format('H:i');
    if ($this->absen->absen_details->count() > 0) {
        $last = $this->absen->absen_details->last()->created_at->format('H:i');
        if ($this->absen->status != 3) {
            $this->must = false;
            return;
        }
        if ($now >= Absen::times[0] && $now < Absen::max) {
            for ($i = 0; $i < count(Absen::times) - 1; $i++) {
                if ($last >= Absen::times[$i] && $last < Absen::times[$i + 1] && ($now >= Absen::times[$i] && $now < Absen::times[$i + 1])) {
                    $this->must = false;
                    return;
                }
            }
        } else {
            $this->must = false;
            return;
        }
    }
    if ($now >= Absen::times[0] && $now < Absen::alpa) {
        $this->must = true;
        return;
    }
    $this->must = false;
    return;
};
mount(function () {
    $this->updateAbsen();
});

on([
    'absen-success' => function () {
        $this->updateAbsen();
        $this->dispatch('fire-success', message: 'Absen Berhasil');
    },
]);

?>
<x-layouts.app>
    @volt
        <div>
            @if ($must)
                <livewire:absens.create :absen="$absen" />
            @else
                <div>
                    @if ($absen)
                        <livewire:absens.today :absen="$absen" />
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
            </script>
        @endscript
    @endvolt
    <x-lightbox />
</x-layouts.app>
