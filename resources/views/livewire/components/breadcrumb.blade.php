<nav class="w-100">
    <ol class="breadcrumb bg-transparent my-0 py-0 px-0">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="{{ url('dashboard') }}" wire:navigate>
                <i class="fa-solid fa-house"></i>
            </a>
        </li>
        @php($link = '')
        @foreach ($currentPath as $path)
            @php($link .= '/' . $path)
            @if (!$loop->last)
                <li class="breadcrumb-item text-sm text-white">
                    <a class="opacity-5 text-white text-capitalize" href="{{ url($link) }}" wire:navigate>
                        {{ $path }}
                    </a>
                </li>
            @else
                <li class="breadcrumb-item text-sm text-white text-capitalize">
                    {{ $path }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
