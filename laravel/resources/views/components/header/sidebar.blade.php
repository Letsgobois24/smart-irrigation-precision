{{-- Sidebar --}}
<aside x-cloak x-show="isOpenSidebar" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-50 -translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-50 -translate-x-full"
    class="fixed block inset-y-0 left-0 z-40 w-full overflow-y-auto bg-white p-6 sm:w-xs sm:ring-1 sm:ring-gray-900/10">
    <button @click="isOpenSidebar = !isOpenSidebar" type="button"
        class="-m-2.5 inline-flex hover:bg-green-100 transition cursor-pointer items-center justify-center rounded-full p-2 text-gray-100">
        <x-icons.hamburger size="28" class="text-gray-900" />
    </button>
    <a href="/" class="block w-fit mx-auto">
        <img src="{{ asset('img/person-logo.png') }}" alt="Logo Artikula" class="h-28 w-auto grayscale-50" />
    </a>
    <button type="button" @click="isOpenSidebar = false"
        class="absolute top-4 right-4 cursor-pointer rounded-md p-1 text-gray-700 hover:bg-gray-50">
        <x-icons.cross size="24" />
    </button>
    <div class="mt-6 flow-root">
        <div class="-my-6 divide-y divide-gray-500/10">
            <div class="space-y-2 py-6">
                <x-header.sidelink href="/" :active="request()->is('/')">Home</x-header.sidelink>
                <x-header.sidelink href="/notification" :active="request()->is('notification')">Notification</x-header.sidelink>
            </div>
        </div>
    </div>
</aside>
