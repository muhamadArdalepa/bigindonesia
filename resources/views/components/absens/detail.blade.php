<div class="{{$class ?? null}}">
    <div class="rounded-3 overflow-hidden">
        <img class="w-100 h-100"  @click="$dispatch('lightbox','{{asset('storage/'.$picture)}}')" src="{{asset('storage/'.$picture)}}" style="object-fit: contain">
    </div>
    <div style="white-space: initial" class="my-1">
        {{ $desc }}
    </div>
    <div style="white-space: initial" class="text-sm my-1">
        <i class="fa-regular fa-clock"></i>
        {{ $time }}
    </div>
    <div style="white-space: initial" class="text-sm my-1">
        <i class="fa-solid fa-location-dot"></i>
        {{ $coordinate }}
    </div>
    <div style="white-space: initial" class="text-sm">{{$address}}</div>
</div>