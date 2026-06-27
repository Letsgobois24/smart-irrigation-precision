<main class="space-y-6">
    {{-- Energy Monitoring --}}
    <section>
        <h1 class="mb-2 text-2xl font-bold">Energy Monitoring</h1>
        <x-card.energy-cards :energy-data="$energy_data" />
    </section>

    {{-- Global Monitoring --}}
    <section>
        <h1 class="mb-2 text-2xl font-bold">Global Monitoring</h1>
        <x-card.global-cards :global-data="$global_data" />
    </section>

    {{-- Node Monitoring --}}
    <section>
        <h1 class="mb-2 text-2xl font-bold">Node Monitoring</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <!-- New 4 Trees Data -->
            @foreach ($node_data as $tree)
                <x-card.tree-card :tree="$tree" />
            @endforeach
        </div>
    </section>
</main>
