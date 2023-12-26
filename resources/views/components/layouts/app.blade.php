<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset('img/logos/big-warna.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('plugins/fontawesome/css/all.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <title>{{ (isset($title) ? $title . ' | ' : '') . 'Borneo Inovasi Gemilang' }}</title>

</head>

<body class="g-sidenav-show">
    {{-- @guest
        {{ $slot }}
    @endguest
    @auth --}}
    <div class="min-height-300 bg-danger position-fixed top-0 w-100"></div>
    <div class="position-relative overflow-hidden d-flex vh-100 w-100">
        <livewire:components.sidenav />
        <main class="position-relative main-content overflow-auto w-100">
            <livewire:components.topnav />
            <div class="container-fluid mb-4">
                {{ $slot }}
            </div>
            <livewire:components.footer />
        </main>
    </div>
    {{-- @endauth --}}


    <script data-navigate-once src="{{ asset('js/before.js') }}"></script>
    <script data-navigate-once src="{{ asset('js/app.js') }}"></script>
    <script data-navigate-once src="{{ asset('js/custom.js') }}"></script>
    @stack('modal')
</body>

</html>
