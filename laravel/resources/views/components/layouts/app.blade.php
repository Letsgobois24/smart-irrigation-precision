<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap"
        rel="stylesheet" />

    <title>{{ $title ?? 'Smart Irrigation Precision' }}</title>
    <meta name="description" content="@yield('meta_description', 'Artikula adalah ruang baca digital berisi artikel berkualitas.')">
</head>

<body class="min-h-screen" x-data="{ isOpenSidebar: window.matchMedia('(min-width: 768px)').matches }">
    <x-header.header />
    <div class="flex-1">
        <div x-show="isOpenSidebar" @click="isOpenSidebar = false"
            class="left-0 right-0 bottom-0 top-0 bg-black/20 hidden sm:block lg:hidden fixed"></div>
        <x-header.sidebar />
        <div :class="isOpenSidebar ? 'lg:ml-80' : 'lg:ml-0'">
            {{ $slot }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    <x-toaster />
</body>


</html>
