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

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-full">
    <div class="">
        <flux:modal.trigger name="create-match">

            <div
                class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-neutral-900 dark:to-neutral-800 rounded-xl p-6 border border-gray-200 dark:border-neutral-700 hover:shadow-lg hover:scale-105 transition-all duration-200 cursor-pointer group">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-full group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
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
        <flux:custommodal   name="create-match" class="   min-w-136">
            <livewire:creatematch />
        </flux:custommodal>
    </div>

    @forelse ($matches as $match)
        {{-- scheduled', 'ongoing', 'finished' --}}
        @if ($match->status == 'scheduled')
            <div
                class="match-card capitalize bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-blue-500 border  dark:border-gray-700 p-6 hover:shadow-lg transition-all">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                            <flux:icon.calendar class="text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $match->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $match->location }} •
                                {{ $match->type == 1 ? 'Singles' : 'Doubles' }} • Best of 3
                            </p>
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
            <div class="match-card capitalize bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-red-500 border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all"
                data-status="live" data-name="championship finals" data-date="2024-01-15">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-red-100 dark:bg-red-900/30 p-2 rounded-lg">
                            <flux:icon.bolt class="text-red-600 dark:text-red-400" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $match->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $match->location }} •
                                {{ $match->type == 1 ? 'Singles' : 'Doubles' }} • Best of 3
                            </p>
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
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $match->teams[0]->name }}</span>
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
            <div class="match-card capitalize bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-green-500 border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all"
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
    <div class="match-card bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-green-500 border  border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all"
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
</div>