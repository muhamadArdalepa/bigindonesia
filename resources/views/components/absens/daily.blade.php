@for ($i=0;$i<4;$i++)
    <div class="w-100 ">
        @if ($detail = $details->where('index', $i)->first())
            <x-absens.detail 
                desc="{{$detail->desc}}"
                time="{{$detail->created_at->format('H:i')}}"
                coordinate="{{$detail->coordinate}}"
                address="{{$detail->address}}"
                picture="{{$detail->picture}}"
                />
        @else
            <div class="bg-light content-middle py-3  h-100 rounded-3">
                Tidak ada data
            </div>
        @endif
    </div>
@endfor
