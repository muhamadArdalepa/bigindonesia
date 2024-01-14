<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset('img/logos/big-warna.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('plugins/fontawesome/css/all.min.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <title>{{ (isset($title) ? $title . ' | ' : '') . 'Borneo Inovasi Gemilang' }}</title>
    @stack('css')
</head>

<body class="g-sidenav-show">

    <div class="min-height-300 bg-danger position-fixed top-0 w-100"></div>
    <div class="position-relative overflow-hidden d-flex vh-100 w-100">
        <x-sidenav />
        <main class="position-relative main-content overflow-auto w-100">
            <x-topnav />
            <div class="px-2 px-md-4 mb-4">
                {{ $slot }}
            </div>
            <x-footer />
        </main>
    </div>
    <script defer data-navigate-once src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script data-navigate-once src="{{ asset('js/before.js') }}"></script>
    <script data-navigate-once src="{{ asset('js/app.js') }}"></script>
    <script data-navigate-once src="{{ asset('js/custom.js') }}"></script>
    @stack('modal')
</body>

</html>