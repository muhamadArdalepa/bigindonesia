@php($reverse = $reverse ?? false)
<span class="d-inline-flex align-items-center gap-{{$gap ?? 1}} flex-row{{$reverse ?  '-reverse' : ''}}">
    <span class="d-md-inline d-none">{{$slot}}</span>
    <span><i class="{{$icon ?? 'fa-solid fa-circle'}}"></i></span>
</span>
