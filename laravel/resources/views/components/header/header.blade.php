<nav class="bg-gray-900">
    {{-- Ketika layar medium --}}
    <div class="flex items-center justify-between p-5 lg:px-8">
        {{-- Hamburger menu --}}
        <div class="flex-1">
            <button @click="isOpenSidebar = !isOpenSidebar" type="button"
                class="-m-2.5 flex hover:bg-green-50/30 transition cursor-pointer items-center justify-center rounded-full size-10 text-gray-100">
                <x-icons.hamburger size="28" />
            </button>
        </div>

        <div class="justify-end items-center">
            <button @click="isOpenNotification = true"
                class="flex relative cursor-pointer ml-3 mr-7 size-10 justify-center items-center rounded-full hover:bg-green-50/30">
                @if ($count_notifications > 0)
                    <div
                        class="absolute top-0.5 right-1 bg-orange-500 size-4 rounded-full flex justify-center items-center text-xs">
                        {{ $count_notifications }}</div>
                @endif
                <x-icons.notification size='30' class="text-gray-100" />
            </button>
        </div>
    </div>
    {{-- Notification Modal --}}
    <livewire:components.notification-modal />

</nav>
