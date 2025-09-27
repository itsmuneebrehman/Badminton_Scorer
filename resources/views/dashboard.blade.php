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

        {{-- <!-- Stats Cards Grid -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Live Matches Card -->
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <div class="flex h-full flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-full">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v3a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-red-400 rounded-full animate-pulse"></div>
                            <span
                                class="text-xs bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 px-2 py-1 rounded-full font-medium">Live</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Live Matches</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $liveMatches ?? 3 }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $newTodayMatches ?? 2 }} started today
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Matches Card -->
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <div class="flex h-full flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-3 rounded-full">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 px-2 py-1 rounded-full font-medium">Total</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Matches</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalMatches ?? 47 }}</p>
                        <p class="text-xs text-blue-600 dark:text-blue-400 flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $weeklyMatches ?? 5 }} this week
                        </p>
                    </div>
                </div>
            </div>

            <!-- Active Players Card -->
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <div class="flex h-full flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <div class="bg-gradient-to-r from-purple-500 to-violet-600 p-3 rounded-full">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400 px-2 py-1 rounded-full font-medium">Players</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Players</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $activePlayers ?? 28 }}</p>
                        <p class="text-xs text-purple-600 dark:text-purple-400 flex items-center mt-1">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $newPlayers ?? 4 }} new this month
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Main Actions Section -->
        <div
            class="relative  flex-1 overflow-hidden rounded-xl  dark:border-neutral-700 bg-white dark:bg-neutral-800">
            <div class="p-6 ">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Quick Actions</h3>
                    
                </div>




                <!-- Action Cards Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">
                    <!-- Create Match -->
                    <div class="">
                    <flux:modal.trigger name="create-match">

                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-neutral-900 dark:to-neutral-800 rounded-xl p-6 border border-gray-200 dark:border-neutral-700 hover:shadow-lg hover:scale-105 transition-all duration-200 cursor-pointer group"
                            {{-- onclick="window.location.href='{{ route('matches.create') ?? '#' }}'" --}}>
                            <div class="flex items-center justify-between mb-4">
                                <div
                                    class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-full group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span
                                    class="text-xs bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded-full font-medium">Quick
                                    Start</span>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Create New Match</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Set up a new badminton match with
                                teams and players. Start tracking scores in real-time.</p>
                            <div class="flex items-center text-xs text-green-700 dark:text-green-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Takes ~2 minutes to setup
                            </div>
                        </div>
                    </flux:modal.trigger>
                    <flux:modal name="create-match"  class="  min-w-136">
                    <livewire:creatematch />
                    </flux:modal>
                    </div>

                    <!-- View Live Matches -->
                    {{-- <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-neutral-900 dark:to-neutral-800 rounded-xl p-6 border border-gray-200 dark:border-neutral-700 hover:shadow-lg hover:scale-105 transition-all duration-200 cursor-pointer group"
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="bg-gradient-to-r from-blue-500 to-cyan-600 p-3 rounded-full group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-red-400 rounded-full animate-pulse"></div>
                                <span
                                    class="text-xs bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 px-2 py-1 rounded-full font-medium">{{ $liveMatches ?? 3 }}
                                    Live</span>
                            </div>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">View Live Matches</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Monitor ongoing matches, update scores,
                            and manage game statistics in real-time.</p>
                        <div class="flex items-center text-xs text-blue-700 dark:text-blue-400">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Real-time updates enabled
                        </div>
                    </div>

                    <!-- Match History -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-neutral-900 dark:to-neutral-800 rounded-xl p-6 border border-gray-200 dark:border-neutral-700 hover:shadow-lg hover:scale-105 transition-all duration-200 cursor-pointer group">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="bg-gradient-to-r from-purple-500 to-violet-600 p-3 rounded-full group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span
                                class="text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400 px-2 py-1 rounded-full font-medium">{{ $totalMatches ?? 47 }}
                                Total</span>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Match History</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Browse completed matches, view detailed
                            statistics, and download match reports.</p>
                        <div class="flex items-center text-xs text-purple-700 dark:text-purple-400">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Export reports available
                        </div>
                    </div> --}}
                </div>

                <!-- Recent Activity (Bottom Section) -->
                {{-- @if(isset($recentActivity) && count($recentActivity) > 0)
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-neutral-700">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Recent Activity</h4>
                            <button
                                class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">View
                                All</button>
                        </div>
                        <div class="space-y-3">
                            @foreach($recentActivity as $activity)
                                <div class="flex items-center space-x-3 text-sm">
                                    <div class="flex-shrink-0 w-2 h-2 bg-{{ $activity['color'] ?? 'green' }}-400 rounded-full">
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $activity['title'] }}</span>
                                        - {{ $activity['description'] }}
                                    </p>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $activity['time'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif --}}
            </div>
        </div>
    </div>

    {{-- @push('scripts')
    <script>
        // Add any dashboard-specific JavaScript here
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-refresh live stats every 30 seconds
            setInterval(function () {
                // This would trigger a Livewire refresh in your actual component
                // Livewire.emit('refreshStats');
            }, 30000);
        });
    </script>
    @endpush --}}
</x-layouts.app>