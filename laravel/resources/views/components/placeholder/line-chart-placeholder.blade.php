<div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 shadow">
    <div class="flex justify-between items-center gap-x-2 mb-4">
        <div>
            <div class="h-5 w-28 bg-slate-200 rounded mb-2"></div>
            <div class="h-4 w-44 bg-slate-200 rounded"></div>
        </div>
        <div class="h-8 w-28 bg-slate-200 rounded-lg animate-pulse"></div>
    </div>

    <!-- Chart Skeleton -->
    <div class="relative h-72 animate-pulse">
        <!-- grid lines -->
        <div class="absolute inset-0 flex flex-col justify-between">
            <div class="h-px bg-slate-200 w-full"></div>
            <div class="h-px bg-slate-200 w-full"></div>
            <div class="h-px bg-slate-200 w-full"></div>
            <div class="h-px bg-slate-200 w-full"></div>
            <div class="h-px bg-slate-200 w-full"></div>
        </div>

        <!-- fake lines -->
        <div class="absolute inset-0">
            <div class="w-full h-full bg-linear-to-r from-transparent via-slate-200 to-transparent opacity-40"></div>
        </div>
    </div>

    <!-- X-axis labels -->
    <div class="mt-4 flex justify-between animate-pulse">
        <div class="h-3 w-16 bg-slate-200 rounded"></div>
        <div class="h-3 w-20 bg-slate-200 rounded"></div>
        <div class="h-3 w-20 bg-slate-200 rounded"></div>
        <div class="h-3 w-20 bg-slate-200 rounded"></div>
        <div class="h-3 w-20 bg-slate-200 rounded"></div>
        <div class="h-3 w-20 bg-slate-200 rounded"></div>
        <div class="h-3 w-16 bg-slate-200 rounded"></div>
    </div>

    <!-- Legend -->
    <div class="mt-6 flex justify-center gap-6 animate-pulse">
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-slate-200 rounded-full"></div>
            <div class="h-3 w-16 bg-slate-200 rounded"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-slate-200 rounded-full"></div>
            <div class="h-3 w-20 bg-slate-200 rounded"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-4 h-4 bg-slate-200 rounded-full"></div>
            <div class="h-3 w-20 bg-slate-200 rounded"></div>
        </div>
    </div>
</div>
