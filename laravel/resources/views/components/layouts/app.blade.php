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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <title>{{ $title ?? 'Smart Irrigation Precision' }}</title>
    <meta name="description" content="@yield('meta_description', 'Artikula adalah ruang baca digital berisi artikel berkualitas.')">
</head>

<body class="min-h-screen" x-data="{
    isOpenSidebar: window.matchMedia('(min-width: 768px)').matches,
    showFloatingHamburger: false,
    handleScroll() {
        this.showFloatingHamburger = window.scrollY > $refs.header.offsetHeight + 20
    }

}" @scroll.window.throttle.30ms="handleScroll">
    <x-header.header x-ref="header" />
    <x-header.floating-hamburger x-show="showFloatingHamburger && !isOpenSidebar" />

    <div>
        <x-header.sidebar />
        <div :class="isOpenSidebar ? 'lg:ml-68' : 'lg:ml-0'">
            {{ $slot }}
        </div>
    </div>

    <x-toaster />
</body>


</html>
