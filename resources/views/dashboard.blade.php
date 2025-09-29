<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Welcome Section -->
        <div class="mb-2">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome back,
                {{ auth()->user()->name ?? 'Hero' }}!
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your badminton tournaments and matches from here.
            </p>
        </div>
        <!-- Main Actions Section -->
        <div
            class="relative  flex-1 overflow-hidden rounded-xl  dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="p-6 ">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Your Matches</h3>
                </div>
                <!-- Action Cards Grid -->
                <livewire:dashboard-cards />
                
            </div>
        </div>
    </div>
</x-layouts.app>