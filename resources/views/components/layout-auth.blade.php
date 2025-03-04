<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | Auth</title>

    {{-- Font Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- JQuery --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    {{-- Load Resource --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <main class="flex items-center justify-center bg-blue-600 p-6 md:p-10 min-h-screen">
        {{ $slot }}
    </main>
</body>

</html>
