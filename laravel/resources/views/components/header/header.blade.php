<nav class="bg-gray-900 text-gray-100" x-data="{ isOpen: false }">
    {{-- Ketika layar medium --}}
    <div class="flex items-center justify-between p-5 lg:px-8">
        {{-- Logo --}}
        <div class="flex md:flex-1">
            <a href="/" wire:navigate class="-m-1.5 p-1.5">
                <img src="{{ asset('img/logo/logo-only.png') }}" alt="Logo Artikula" class="h-10 w-auto grayscale-50" />
            </a>
        </div>
        {{-- Navigasi --}}
        <div class="hidden md:flex md:space-x-12 text-sm/6 font-semibold">
            <x-header.link href="/" :active="request()->is('/')">Home</x-header.link>
        </div>

        <div class="hidden md:flex md:flex-1 md:justify-end md:items-center">
            <div class="cursor-pointer ml-3 mr-7 h-9 w-9 overflow-hidden rounded-full group-focus:ring-2"
                type="button">
                <img src="{{ asset('img/person-logo.png') }}" alt="my-logo" />
            </div>
        </div>

        {{-- Ketika layar small --}}

        {{-- Hamburger menu --}}
        <div class="flex md:hidden">
            <button @click="isOpen = !isOpen" type="button"
                class="-m-2.5 inline-flex cursor-pointer items-center justify-center rounded-md p-2.5 text-gray-100">
                <x-icons.hamburger size="24" />
            </button>
        </div>
    </div>

    {{-- Sidebar --}}
    <aside x-show="isOpen" x-on:click.outside="isOpen = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-50 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-50 translate-x-full"
        class="fixed md:hidden block inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <a href="/" class="block w-fit mx-auto">
            <img src="{{ asset('img/logo/logo-name.png') }}" alt="Logo Artikula" class="h-28 w-auto grayscale-50" />
        </a>
        <button type="button" @click="isOpen = false"
            class="absolute top-4 right-4 cursor-pointer rounded-md p-1 text-gray-700 hover:bg-gray-50">
            <x-icons.cross size="24" />
        </button>
        <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
                <div class="space-y-2 py-6">
                    <x-header.sidelink href="/" :active="request()->is('/')">Home</x-header.sidelink>
                </div>
            </div>
        </div>
    </aside>

</nav>
