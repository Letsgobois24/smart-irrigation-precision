<nav {{ $attributes }} class="bg-gray-900">
    {{-- Ketika layar medium --}}
    <div class="flex items-center justify-between gap-3 h-16 sm:h-20 px-3 sm:px-5 lg:px-8">
        {{-- Hamburger menu --}}
        <div class="flex items-center gap-3 sm:gap-5">
            <button @click="isOpenSidebar = !isOpenSidebar" type="button"
                class="-mx-2.5 flex hover:bg-green-50/30 transition cursor-pointer items-center justify-center rounded-full size-10 text-gray-100">
                <x-icons.hamburger size="28" />
            </button>

            <a href="/" wire:navigate class="block w-fit">
                <img src="{{ asset('img/avonexa-light-title.png') }}" alt="Logo Avonexa" class="h-4 sm:h-5 w-auto">
            </a>
        </div>

        @persist('header')
            <div class="flex items-center sm:gap-3">
                <!-- Toggle Sistem -->
                <livewire:components.system-toggle />

                <div class="hidden sm:block h-8 w-px bg-gray-700"></div>

                <!-- Clock -->
                <div wire:ignore x-data="clock(@js($now))" x-init="init()"
                    class="hidden sm:block font-mono text-right">
                    <div class="text-lg font-semibold text-white">
                        <span x-text="time"></span>
                    </div>
                    <div class="text-xs text-gray-400">
                        <span x-text="date"></span>
                    </div>
                </div>

                <div class="hidden sm:block h-8 w-px bg-gray-700"></div>

                <!-- Notification -->
                <livewire:components.notification-modal />
            </div>
        @endpersist
    </div>

</nav>
