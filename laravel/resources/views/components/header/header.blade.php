<nav class="bg-gray-900 text-gray-100">
    {{-- Ketika layar medium --}}
    <div class="flex items-center justify-between p-5 lg:px-8">
        {{-- Hamburger menu --}}
        <div class="flex-1">
            <button @click="isOpenSidebar = !isOpenSidebar" type="button"
                class="-m-2.5 inline-flex hover:bg-green-50/30 transition cursor-pointer items-center justify-center rounded-full p-2 text-gray-100">
                <x-icons.hamburger size="28" />
            </button>
        </div>

        <div class="justify-end items-center">
            <div class="cursor-pointer ml-3 mr-7 h-9 w-9 overflow-hidden rounded-full group-focus:ring-2" type="button">
                <img src="{{ asset('img/person-logo.png') }}" alt="my-logo" />
            </div>
        </div>
    </div>
</nav>
