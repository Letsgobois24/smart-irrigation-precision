<div wire:ignore x-cloak x-data="{
    toasts: [],
    colors: {
        success: 'bg-emerald-100 text-emerald-600',
        danger: 'bg-red-100 text-red-600',
        warning: 'bg-yellow-100 text-yellow-600',
    },

    addToast(detail) {
        const id = Math.random();

        this.toasts.push({
            id,
            message: detail.message,
            type: detail.type ?? 'success'
        });

        setTimeout(() => {
            this.removeToast(id);
        }, 2000);
    },

    removeToast(id) {
        this.toasts = this.toasts.filter(
            toast => toast.id !== id
        );
    }
}" @toast.window="addToast($event.detail)"
    class="fixed bottom-2 right-2 z-50 space-y-2">

    <template x-for="toast in toasts" :key="toast.id">
        <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-6"
            :class="toast.type in colors ? colors[toast.type] : colors.success"
            class="flex items-center w-sm p-4 bg-white text-gray-700 rounded-lg shadow border border-gray-200">

            <div class="inline-flex items-center justify-center shrink-0 w-7 h-7 rounded">
                <template x-if="toast.type === 'success'">
                    <x-icons.check size="20" />
                </template>
                <template x-if="toast.type === 'danger'">
                    <x-icons.danger size="20" />
                </template>
                <template x-if="toast.type === 'warning'">
                    <x-icons.warning size="20" />
                </template>
            </div>

            <div class="ms-3 text-sm font-normal" x-text="toast.message"></div>

            <button type="button" @click="removeToast(toast.id)"
                class="cursor-pointer ms-auto flex items-center justify-center text-gray-400 hover:text-gray-700 bg-transparent hover:bg-gray-100 rounded-lg text-sm h-8 w-8">
                <x-icons.cross size="20" />
            </button>
        </div>
    </template>
</div>
