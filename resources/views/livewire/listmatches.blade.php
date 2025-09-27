<?php

use Livewire\Volt\Component;
use App\Models\MatchModel;
use Livewire\Attributes\On;


new class extends Component {

    public $matches;
    public function mount()
    {
        $this->getData();
    }

    #[On('match-created')]
    public function updatePostList()
    {
        $this->getData();
    }

    public function getData()
    {
        $this->matches = MatchModel::where('created_by', auth()->id())->latest()->get();
        // dd($this->matches[0]->teams);

    }
}; ?>

<div>
    <style>
        .filter-btn {
            background-color: rgb(249 250 251);
            color: rgb(75 85 99);
            border: 1px solid rgb(209 213 219);
        }

        .dark .filter-btn {
            background-color: rgb(55 65 81);
            color: rgb(156 163 175);
            border: 1px solid rgb(75 85 99);
        }

        .filter-btn:hover {
            background-color: rgb(243 244 246);
            color: rgb(55 65 81);
        }

        .dark .filter-btn:hover {
            background-color: rgb(75 85 99);
            color: rgb(209 213 219);
        }

        .filter-btn.active {
            background: linear-gradient(to right, rgb(34 197 94), rgb(5 150 105));
            color: white;
            border: 1px solid rgb(34 197 94);
        }

        .match-card {
            transition: all 0.3s ease;
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    <div class="max-w-7xl border mx-auto  p-4 border-gray-500 rounded-lg ">

        <header
            class="bg-white mb-6 dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">

                        <div class="flex items-center space-x-3">

                            <div>
                                <h1 class="text-xl font-bold text-gray-900 dark:text-white">My Matches</h1>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Manage all your badminton matches
                                </p>
                            </div>
                        </div>
                    </div>

                    <flux:modal name="create-match" class="min-w-136">
                        <livewire:creatematch />
                    </flux:modal>

                    <div class="flex items-center space-x-4">
                        <flux:modal.trigger name="create-match">

                            <button
                                class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-emerald-700 font-medium transition-all transform hover:scale-105 flex items-center space-x-2">
                                <flux:icon.plus />
                                <span class="hidden sm:inline">New Match</span>
                            </button>
                        </flux:modal.trigger>

                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->

        <!-- Stats Bar -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-lg">
                        <flux:icon.live />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="liveCount">3</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Live</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                        <flux:icon.calendar-days />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="scheduledCount">7</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Scheduled</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg">

                        <flux:icon.check-circle />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="completedCount">24</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Completed</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg">
                        <flux:icon.trophy />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="totalCount">34</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-2">
                    <button class="filter-btn active px-4 py-2 rounded-lg font-medium transition-all" data-filter="all">
                        <div class="flex items-center gap-x-2">
                            <flux:icon.list-bullet />
                            All Matches
                        </div>
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all" data-filter="live">
                        <div class="flex items-center gap-x-2">
                            <flux:icon.bolt />
                            Live
                            <span
                                class="ml-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-2 py-0.5 rounded-full text-xs">3</span>
                        </div>

                    </button>
                    <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all" data-filter="scheduled">
                        <div class="flex items-center gap-x-2">
                            <flux:icon.calendar-days />
                            Scheduled
                            <span
                                class="ml-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-2 py-0.5 rounded-full text-xs">7</span>
                        </div>

                    </button>
                    <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-all" data-filter="completed">
                        <div class="flex items-center gap-x-2">
                            <flux:icon.check-circle />
                            Completed
                            <span
                                class="ml-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 px-2 py-0.5 rounded-full text-xs">24</span>
                        </div>

                    </button>
                </div>


                <div class="flex items-center space-x-2 ">
                    <span class=" text-xs dark:text-gray-400">Sorted By:</span>
                    <flux:select>
                        <flux:select.option value="newest" label="Newest First" selected />
                        <flux:select.option value="oldest" label="Oldest First" />
                        <flux:select.option value="name" label="Match Name" />
                        <flux:select.option value="status" label="Status" />
                    </flux:select>
                </div>
            </div>
        </div>

        <!-- Matches Grid -->
        <div id="matchesContainer" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Live Matches -->
            @forelse ($matches as $match)
                {{-- scheduled', 'ongoing', 'finished' --}}
                @if ($match->status == 'scheduled')
                    <div
                        class="match-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-blue-500 border  dark:border-gray-700 p-6 hover:shadow-lg transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                                    <flux:icon.calendar class="text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $match->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $match->location }} •
                                        {{ $match->type == 1 ? 'Singles' : 'Doubles' }} • Best of 3 </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span
                                    class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 px-3 py-1 rounded-full text-xs font-medium">
                                    SCHEDULED
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Teams -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <span
                                            class="font-semibold text-gray-900 dark:text-white capitalize">{{ $match->teams[0]->name }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400 capitalize">
                                            @foreach ($match->teams[0]->players as $player)
                                                {{ $player->name }}{{ !$loop->last ? ' & ' : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-400 dark:text-gray-500">VS</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <span
                                            class="font-semibold text-gray-900 dark:text-white capitalize">{{ $match->teams[1]->name }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400 capitalize">
                                            @foreach ($match->teams[1]->players as $player)
                                                {{ $player->name }}{{ !$loop->last ? ' & ' : '' }}
                                            @endforeach</span>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400 capitalize">
                                            {{ $match->date }} •
                                            {{ \Carbon\Carbon::parse($match->start_time)->format('g:i A') }}
                                        </span>
                                        <span class="text-blue-600 dark:text-blue-400 font-medium">
                                            Starts in 25 mins
                                        </span>

                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-3">
                                <a href="{{ route('match.view', $match->id) }}"
                                    class="flex-1 bg-gradient-to-r from-blue-500 to-cyan-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-cyan-700 font-medium transition-all flex items-center justify-center space-x-2">
                                    <flux:icon.play />
                                    <span>Start Match</span>
                                </a>
                                <button onclick="editMatch('scheduled-1')"
                                    class="px-4 py-2 border border-blue-300 dark:border-blue-600 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 font-medium transition-colors">
                                    <flux:icon.pencil-square />
                                </button>
                                <button onclick="deleteMatch('scheduled-1')"
                                    class="px-4 py-2 border border-red-300 dark:border-red-600 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 font-medium transition-colors">
                                    <flux:icon.trash />
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif ($match->status == 'ongoing')
                    <div class="match-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-red-500 border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all"
                        data-status="live" data-name="championship finals" data-date="2024-01-15">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-lg">
                                    <flux:icon.bolt class="text-red-600 dark:text-red-400" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $match->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $match->location }} •
                                        {{ $match->type == 1 ? 'Singles' : 'Doubles' }} • Best of 3 </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span
                                    class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 px-3 py-1 rounded-full text-xs font-medium flex items-center">
                                    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse mr-2"></div>
                                    LIVE
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Teams and Score -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <span
                                            class="font-semibold text-gray-900 dark:text-white">{{ $match->teams[0]->name }}</span>
                                        <span
                                            class="text-sm text-gray-500 dark:text-gray-400">@foreach ($match->teams[0]->players as $player)
                                                {{ $player->name }}{{ !$loop->last ? ' & ' : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">21</div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <span class="font-semibold text-gray-900 dark:text-white">Thunder Eagles</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Mike Johnson</span>
                                    </div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">18</div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Set 2 • Game Duration: 23:45</span>
                                        <div class="flex space-x-2">
                                            <span
                                                class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 px-2 py-1 rounded">21-15</span>
                                            <span
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-2 py-1 rounded">21-18</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-3">
                                <button onclick="viewMatch('live-1')"
                                    class="flex-1 bg-gradient-to-r from-red-500 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-red-600 hover:to-pink-700 font-medium transition-all flex items-center justify-center space-x-2">
                                    <flux:icon.eye />

                                    <span>Watch Live</span>
                                </button>
                                <button onclick="manageMatch('live-1')"
                                    class="px-4 py-2 border border-red-300 dark:border-red-600 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 font-medium transition-colors">
                                    <flux:icon.cog />
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Completed Match -->
                    <div class="match-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-green-500 border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all"
                        data-status="completed" data-name="quarter finals" data-date="2024-01-14">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg">
                                    <flux:icon.check-circle class="text-green-600 dark:text-green-400" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Quarter Finals</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Court 3 • Singles • Best of 3</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span
                                    class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-3 py-1 rounded-full text-xs font-medium">
                                    COMPLETED
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Final Score -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <span class="font-semibold text-gray-900 dark:text-white">Fire Hawks</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Emma Wilson</span>
                                        <flux:icon.crown class="text-yellow-500 ml-2" />
                                    </div>
                                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">2</div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                        <span class="font-semibold text-gray-900 dark:text-white">Ice Breakers</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">David Brown</span>
                                    </div>
                                    <div class="text-2xl font-bold text-gray-500 dark:text-gray-400">1</div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Yesterday • Duration: 47:32</span>
                                        <div class="flex space-x-2">
                                            <span
                                                class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded">21-18</span>
                                            <span
                                                class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 px-2 py-1 rounded">19-21</span>
                                            <span
                                                class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded">21-16</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-3">
                                <button onclick="viewMatchReport('completed-1')"
                                    class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-emerald-700 font-medium transition-all flex items-center justify-center space-x-2">
                                    <flux:icon.presentation-chart-line />
                                    <span>View Report</span>
                                </button>
                                <button onclick="downloadReport('completed-1')"
                                    class="px-4 py-2 border border-green-300 dark:border-green-600 text-green-700 dark:text-green-400 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 font-medium transition-colors">
                                    <flux:icon.arrow-down-on-square />
                                </button>
                                <button onclick="shareMatch('completed-1')"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors">
                                    <flux:icon.share />
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @empty

            @endforelse


            <!-- Completed Match -->
            <div class="match-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-green-500 border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all"
                data-status="completed" data-name="quarter finals" data-date="2024-01-14">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg">
                            <flux:icon.check-circle class="text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Quarter Finals</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Court 3 • Singles • Best of 3</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span
                            class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-3 py-1 rounded-full text-xs font-medium">
                            COMPLETED
                        </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Final Score -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="font-semibold text-gray-900 dark:text-white">Fire Hawks</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Emma Wilson</span>
                                <flux:icon.crown class="text-yellow-500 ml-2" />
                            </div>
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">2</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                <span class="font-semibold text-gray-900 dark:text-white">Ice Breakers</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">David Brown</span>
                            </div>
                            <div class="text-2xl font-bold text-gray-500 dark:text-gray-400">1</div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Yesterday • Duration: 47:32</span>
                                <div class="flex space-x-2">
                                    <span
                                        class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded">21-18</span>
                                    <span
                                        class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 px-2 py-1 rounded">19-21</span>
                                    <span
                                        class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 px-2 py-1 rounded">21-16</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-3">
                        <button onclick="viewMatchReport('completed-1')"
                            class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-emerald-700 font-medium transition-all flex items-center justify-center space-x-2">
                            <flux:icon.presentation-chart-line />
                            <span>View Report</span>
                        </button>
                        <button onclick="downloadReport('completed-1')"
                            class="px-4 py-2 border border-green-300 dark:border-green-600 text-green-700 dark:text-green-400 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 font-medium transition-colors">
                            <flux:icon.arrow-down-on-square />
                        </button>
                        <button onclick="shareMatch('completed-1')"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors">
                            <flux:icon.share />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add more match cards dynamically here -->

        </div>

        <!-- Load More Button -->
        <div class="mt-8 text-center">
            <button onclick="loadMoreMatches()"
                class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 font-medium transition-colors flex items-center space-x-2 mx-auto">
                <flux:icon.plus />
                <span>Load More Matches</span>
            </button>
        </div>
    </div>
</div>