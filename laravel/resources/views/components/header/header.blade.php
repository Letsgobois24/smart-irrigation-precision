<nav {{ $attributes }} class="bg-gray-900">
    {{-- Ketika layar medium --}}
    <div class="flex items-center justify-between h-20 px-5 lg:px-8">
        {{-- Hamburger menu --}}
        <button @click="isOpenSidebar = !isOpenSidebar" type="button"
            class="-mx-2.5 flex hover:bg-green-50/30 transition cursor-pointer items-center justify-center rounded-full size-10 text-gray-100">
            <x-icons.hamburger size="28" />
        </button>

        @persist('header')
            <div class="flex items-center gap-4">
                <!-- 🟢 Toggle Sistem -->
                <livewire:components.system-toggle />

                <div class="h-8 w-px bg-gray-700"></div>

                <!-- 🕒 Clock -->
                <!-- Clock -->
                <div wire:ignore x-data="clock(@js($now))" x-init="init()" class="font-mono text-right">

                    <div class="text-lg font-semibold text-white">
                        <span x-text="time"></span>
                    </div>

                    <div class="text-xs text-gray-400">
                        <span x-text="date"></span>
                    </div>
                </div>

                <div class="h-8 w-px bg-gray-700"></div>

                {{-- Notification Modal --}}
                <div class="justify-end items-center">
                    <livewire:components.notification-modal />
                </div>
            </div>
        @endpersist
    </div>

</nav>
