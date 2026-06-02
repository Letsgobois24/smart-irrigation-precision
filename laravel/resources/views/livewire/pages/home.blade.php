<main class="bg-green-50 min-h-screen p-6 px-2 sm:px-6 w-full">
    <livewire:components.dashboard-header />
    <livewire:components.global-monitoring />
    <livewire:components.node-monitoring />
    <x-container title="🚨 System Event Monitoring" description='Riwayat proses irigasi otomatis'>
        <livewire:components.system-event-table lazy />
    </x-container>
</main>
