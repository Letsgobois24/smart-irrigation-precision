<div class="bg-slate-50 p-6 max-w-full overflow-hidden rounded-2xl border border-slate-200 shadow">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
        <div>
            <div class="h-5 w-28 bg-slate-200 rounded mb-2 animate-pulse"></div>
            <div class="h-4 w-40 sm:w-44 bg-slate-200 rounded animate-pulse"></div>
        </div>
        <div class="h-8 w-24 sm:w-28 bg-slate-200 rounded-lg animate-pulse"></div>
    </div>

    <!-- Chart Skeleton -->
    <div class="relative h-56 sm:h-64 md:h-72 animate-pulse">
        <!-- grid lines -->
        <div class="absolute inset-0 flex flex-col justify-between">
            <div class="h-px bg-slate-200 w-full"></div>
            <div class="h-px bg-slate-200 w-full"></div>
            <div class="h-px bg-slate-200 w-full"></div>
            <div class="h-px bg-slate-200 w-full"></div>
            <div class="h-px bg-slate-200 w-full"></div>
        </div>

        <!-- shimmer effect -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="w-full h-full bg-linear-to-r from-transparent via-slate-200 to-transparent opacity-40"></div>
        </div>
    </div>

    <!-- X-axis labels (GRID biar tidak overflow) -->
    <div class="mt-4 grid grid-cols-3 sm:grid-cols-5 md:grid-cols-7 gap-2 animate-pulse">
        <div class="h-3 w-full bg-slate-200 rounded"></div>
        <div class="h-3 w-full bg-slate-200 rounded"></div>
        <div class="h-3 w-full bg-slate-200 rounded"></div>
        <div class="h-3 w-full bg-slate-200 rounded"></div>
        <div class="h-3 w-full bg-slate-200 rounded"></div>
        <div class="h-3 w-full bg-slate-200 rounded"></div>
        <div class="h-3 w-full bg-slate-200 rounded"></div>
    </div>

    <!-- Legend (wrap biar aman) -->
    <div class="mt-6 flex flex-wrap justify-center gap-4 animate-pulse">
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-slate-200 rounded-full"></div>
            <div class="h-3 w-14 sm:w-16 bg-slate-200 rounded"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-slate-200 rounded-full"></div>
            <div class="h-3 w-16 sm:w-20 bg-slate-200 rounded"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-slate-200 rounded-full"></div>
            <div class="h-3 w-16 sm:w-20 bg-slate-200 rounded"></div>
        </div>
    </div>

</div>
