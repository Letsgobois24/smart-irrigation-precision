<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">

    {{-- Hero Card --}}
    <div class="rounded-2xl border-2 {{ $source_config['border'] }} {{ $source_config['bg'] }} p-4 mb-4">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500">
                    Active Energy Source
                </p>

                <h1 class="text-3xl font-bold mt-1">
                    {{ $source_config['icon'] }}
                    {{ $source_config['title'] }}
                </h1>

                <p class="text-xs text-gray-600 mt-1">
                    Currently supplying the irrigation system.
                </p>
            </div>

            <div class="text-right">
                <p class="text-xs text-gray-500">
                    ATS Relay
                </p>

                <div class="text-xl font-bold {{ $is_switching ? 'text-red-500' : 'text-green-600' }}">
                    {{ $is_switching ? 'SWITCHING' : 'NORMAL' }}
                </div>

                <span class="text-xs text-gray-400">
                    Last update: {{ smartTimeFormat($energyData['time']) }}
                </span>
            </div>

        </div>

    </div>

    {{-- Information Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

        @foreach ($energy_cards as $card)
            <div class="rounded-xl border {{ $card['border'] }} px-4 py-2 hover:shadow-md transition">

                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500">
                        {{ $card['title'] }}
                    </p>

                    <span class="text-lg">
                        {{ $card['icon'] }}
                    </span>
                </div>

                <div>
                    <div class="text-xl font-semibold {{ $card['valueClass'] }}">
                        {{ $card['value'] }}
                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $card['subtitle'] }}
                    </p>

                    @if ($card['progress'] !== null)
                        <div class="w-full h-1.5 bg-gray-200 rounded-full mt-2">
                            <div class="h-1.5 {{ $card['progressColor'] }} rounded-full transition-all duration-500"
                                style="width: {{ $card['progress'] }}%">
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        @endforeach

    </div>

</div>
