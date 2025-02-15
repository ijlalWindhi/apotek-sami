<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | Penyimpanan</title>

    {{-- Font Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- JQuery --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2.full.min.js') }}"></script>

    {{-- Load Resource --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <x-layout.edit-profile></x-layout.edit-profile>

    @if (request()->is('inventory*'))
        <x-layout.sidebar></x-layout.sidebar>
    @endif

    <x-layout.header></x-layout.header>

    <main class="mt-14 sm:mt-16 md:mt-[4.5rem] {{ request()->is('inventory*') ? 'sm:ml-64 p-4' : '' }}">
        <h1 class="text-blue-500 font-semibold text-lg md:text-xl lg:text-2xl mb-4">
            {{ $title }}</h1>
        {{ $slot }}
    </main>

</body>

</html>
