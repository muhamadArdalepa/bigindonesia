<span x-data="{ hover: false, copy: false }"
    @mouseover="hover=true"
    @mouseout="hover=false"
    @click="navigator.clipboard.writeText('{{$text ?? ''}}');copy=true"
    class="cursor-pointer d-inline-block {{ $class ?? '' }} text-{{ $color ?? 'dark' }} bg-white py-1 ps-2"
    >
    <i class="fa-solid" :class="!copy ? 'fa-copy':'fa-check'"></i>
    <span x-transition.duration.100ms x-transition.origin.left x-show="hover" x-text="copy?'Disalin':'Salin'"></span>
</span>
