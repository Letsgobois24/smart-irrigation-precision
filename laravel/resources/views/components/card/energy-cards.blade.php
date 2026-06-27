<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    {{-- Hero Card --}}
    <div class="rounded-2xl border-2 {{ $source_config['border'] }} {{ $source_config['bg'] }} p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-widest text-gray-500">
                    Active Energy Source
                </p>

                <h1 class="text-4xl font-bold mt-2">
                    {{ $source_config['icon'] }}
                    {{ $source_config['title'] }}
                </h1>

                <p class="text-sm text-gray-600 mt-2">
                    Currently supplying the irrigation system.
                </p>
            </div>

            <div class="text-right">
                <p class="text-xs text-gray-500">
                    ATS Relay
                </p>
                <div class="text-2xl font-bold {{ $is_switching ? 'text-red-500' : 'text-green-600' }}">
                    {{ $is_switching ? 'SWITCHING' : 'NORMAL' }}
                </div>
                <span class="text-[11px] text-gray-400">
                    Last Update {{ smartTimeFormat($energyData['time']) }}
                </span>
            </div>

        </div>

    </div>

    {{-- Information Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        @foreach ($energy_cards as $card)
            <div class="rounded-xl border {{ $card['border'] }} p-5 hover:shadow-md transition">

                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        {{ $card['title'] }}
                    </p>
                    <span class="text-xl">
                        {{ $card['icon'] }}
                    </span>
                </div>

                <div class="mt-4">

                    <div class="text-2xl font-semibold {{ $card['valueClass'] }}">
                        {{ $card['value'] }}
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        {{ $card['subtitle'] }}
                    </p>

                    @if ($card['progress'] !== null)
                        <div class="w-full h-2 bg-gray-200 rounded-full mt-3">
                            <div class="h-2 bg-yellow-500 rounded-full transition-all duration-500"
                                style="width: {{ $card['progress'] }}%">
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach

    </div>

</div>
