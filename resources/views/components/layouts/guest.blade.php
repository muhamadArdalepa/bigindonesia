<!DOCTYPE html>
<html>

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

<body>

    <main class="content-middle vh-100 w-100 bg-light p-3">
        {{ $slot }}
    </main>
    <script data-navigate-once src="{{ asset('js/before.js') }}"></script>
    <script data-navigate-once src="{{ asset('js/app.js') }}"></script>
    <script data-navigate-once src="{{ asset('js/custom.js') }}"></script>
    @stack('modal')
</body>

</html>