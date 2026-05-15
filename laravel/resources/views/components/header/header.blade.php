<nav {{ $attributes }} class="bg-gray-900">
    {{-- Ketika layar medium --}}
    <div class="flex items-center justify-between p-5 lg:px-8">
        {{-- Hamburger menu --}}
        <div class="flex-1">
            <button @click="isOpenSidebar = !isOpenSidebar" type="button"
                class="-mx-2.5 flex hover:bg-green-50/30 transition cursor-pointer items-center justify-center rounded-full size-10 text-gray-100">
                <x-icons.hamburger size="28" />
            </button>
        </div>

        <div class="justify-end items-center">
            <livewire:components.notification-modal />
        </div>
    </div>
    {{-- Notification Modal --}}

</nav>
