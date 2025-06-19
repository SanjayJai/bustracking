<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Top Grid with Fake Data -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Card 1 -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white p-4 dark:bg-neutral-900">
                <h3 class="text-lg font-bold">Total Buses</h3>
                <p class="text-3xl font-semibold mt-2">12</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">3 Active, 9 Idle</p>
            </div>

            <!-- Card 2 -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white p-4 dark:bg-neutral-900">
                <h3 class="text-lg font-bold">Total Distance Covered Today</h3>
                <p class="text-3xl font-semibold mt-2">482 km</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Last updated: 5 mins ago</p>
            </div>

            <!-- Card 3 -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white p-4 dark:bg-neutral-900">
                <h3 class="text-lg font-bold">Average ETA</h3>
                <p class="text-3xl font-semibold mt-2">14 min</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Based on 5 active buses</p>
            </div>
        </div>

        <!-- Bus Map or Livewire Component -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4">
            <h2 class="text-xl font-semibold mb-2">Bus Location Map</h2>
            {{-- Optional: Replace this with your map or real Livewire --}}
            <div class="h-[400px] bg-gray-100 dark:bg-neutral-800 flex items-center justify-center rounded-lg">
                <span class="text-gray-500 dark:text-gray-400">Map will appear here</span>
            </div>

            {{-- Or keep your Livewire component --}}
          
        </div>
    </div>
</x-layouts.app>
