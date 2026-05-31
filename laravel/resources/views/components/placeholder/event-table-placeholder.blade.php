<div class="animate-pulse">
    {{-- Date Range Skeleton --}}
    <div class="mb-4 w-full sm:w-64">
        <div class="h-10 rounded-xl bg-gray-200"></div>
    </div>

    {{-- Table Skeleton --}}
    <div class="overflow-x-auto rounded-xl border border-gray-100">
        <x-placeholder.table columns='10' rows='5' />
    </div>

    {{-- Pagination Skeleton --}}
    <div class="flex sm:flex-row flex-col-reverse sm:justify-between items-center mt-4 gap-3">
        {{-- Count --}}
        <div class="h-4 w-52 rounded bg-gray-200"></div>

        {{-- Buttons --}}
        <div class="flex items-center gap-2">
            <div class="h-10 w-20 rounded-lg bg-gray-200"></div>

            <div class="h-4 w-16 rounded bg-gray-200"></div>

            <div class="h-10 w-20 rounded-lg bg-green-100"></div>
        </div>
    </div>
</div>
