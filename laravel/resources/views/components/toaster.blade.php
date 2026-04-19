<div wire:ignore x-cloak x-data="{
    isShow: false,
    type: 'success',
    message: '',
    colors: {
        success: 'bg-emerald-100 text-emerald-600',
        danger: 'bg-red-100 text-red-600',
        warning: 'bg-yellow-100 text-yellow-600',
    }
}" x-show="isShow"
    x-on:toast.window="
    isShow=true;
    message=$event.detail.message;
    type=$event.detail.type;
    setTimeout(() => isShow = false, 2000);
    "
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-6"
    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-6"
    :class="colors[type]"
    class="fixed bottom-2 right-2 flex items-center w-full max-w-sm p-4 bg-white text-gray-700 rounded-lg shadow border border-gray-200"
    role="alert">

    <div class="inline-flex items-center justify-center shrink-0 w-7 h-7 rounded">
        <template x-if="type=='success'">
            <x-icons.check size="20" />
        </template>
        <template x-if="type=='danger'">
            <x-icons.danger size="20" />
        </template>
        <template x-if="type=='warning'">
            <x-icons.warning size="20" />
        </template>
    </div>

    <div class="ms-3 text-sm font-normal" x-text="message"></div>

    <button type="button" x-on:click="isShow=false"
        class="cursor-pointer ms-auto flex items-center justify-center text-gray-400 hover:text-gray-700 bg-transparent hover:bg-gray-100 rounded-lg text-sm h-8 w-8 focus:outline-none focus:ring-2 focus:ring-gray-300">
        <x-icons.cross size="20" />
    </button>
</div>
