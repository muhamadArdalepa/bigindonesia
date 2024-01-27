<div class="{{$class ?? null}}">
    <div class="rounded-3 overflow-hidden">
        <img class="w-100 h-100"  @click="$dispatch('lightbox','{{asset('storage/'.$picture)}}')" src="{{asset('storage/'.$picture)}}" style="object-fit: contain">
    </div>
    <div class="my-1">
        {{ $desc }}
    </div>
    <div class="text-sm my-1">
        <i class="fa-regular fa-clock"></i>
        {{ $time }}
    </div>
    <div class="text-sm my-1">
        <i class="fa-solid fa-location-dot"></i>
        {{ $coordinate }}
    </div>
    <div class="text-sm">{{$address}}</div>
</div>