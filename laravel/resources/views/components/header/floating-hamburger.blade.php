<button {{ $attributes }} x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-90 -translate-y-2"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
    @click="isOpenSidebar = !isOpenSidebar" type="button"
    class="
        fixed top-4 left-1.5 lg:left-4 z-50

        p-2 rounded-2xl

        bg-white/90
        backdrop-blur-md

        border border-green-100
        shadow-lg shadow-black/5

        text-green-700

        hover:bg-green-50
        hover:border-green-200
        hover:shadow-xl
        hover:scale-105

        active:scale-95

        transition-all duration-200
        cursor-pointer
    ">

    {{-- Glow Background --}}
    <div class="
            absolute inset-0
            rounded-2xl
            bg-green-500/5
        ">
    </div>

    {{-- Icon --}}
    <div class="relative">
        <x-icons.hamburger size="28" />
    </div>
</button>
