<?php
use function Livewire\Volt\{state, computed, placeholder};
state([
    'absen_id' => fn() => $this->absen_id,
    'editable' => fn() => $this->editable,
])->reactive();
$absen = computed(fn() => \App\Models\Absen::find($this->absen_id));
placeholder('<div style="height: 10rem" class="content-middle flex-column gap-3">
    <div class="spinner-border"></div>
</div>');
?>
<div>
    @volt
        <div class="d-flex flex-column flex-md-row gap-4 gap-md-3">
            @for ($i = 0; $i < 4; $i++)
                <div class="w-100">
                    @if ($detail = $this->absen->absen_details->where('index', $i)->first())
                        <x-absens.detail desc="{{ $detail->desc }}" time="{{ $detail->created_at->format('H:i') }}"
                            coordinate="{{ $detail->coordinate }}" address="{{ $detail->address }}"
                            picture="{{ $detail->picture }}" />
                        @if ($editable)
                            <div class="text-end"></div>
                            <button class="btn btn-">
                                <i></i>
                            </button>
                        @endif
                    @else
                        @if ($editable)
                            <div style="min-height: 10rem" class="bg-light content-middle py-3  h-100 rounded-3 flex-column gap-1 cursor-pointer content-middle "
                                 x-data @click="$dispatch('modal-show',{{$absen_id}})">
                                <span><i class="fa-solid fa-plus-circle fa-xl"></i></span>
                                Tambah Absen
                            </div>
                        @else
                            <div style="min-height: 10rem" class="bg-light content-middle py-3  h-100 rounded-3">
                                Tidak ada data
                            </div>
                        @endif
                    @endif
                </div>
            @endfor
        </div>  
    @endvolt
</div>
