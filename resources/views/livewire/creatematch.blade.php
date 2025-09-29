<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\MatchModel;
use App\Models\Team;
use App\Models\Player;
use Flux\Flux;

new class extends Component {
    public $match = [
        'name' => '',
        'location' => '',
        'date' => '',
        'time' => '',
        'type' => '1',
    ];

    public $play = "0";
    public $data = [];
    public $teams = [
        'A' => [
            'name' => '',
            'players' => [],
        ],
        'B' => [
            'name' => '',
            'players' => [],
        ],
    ];
    public $step = 1;//123

    public function mount()
    {
        // 'created_by'=> ,
        // dd(auth()->id());
    }

    #[On('modal-show')]
    public function updatePostList($name)
    {
        // dd($name);
        if ($name == 'create-match') {
            $this->reset('teams', 'data', 'play', 'match', 'step');
        }
    }

    public function nextStep()
    {
        if ($this->step < 4) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function createMatch()
    {
        // dd($type, $this->match, $this->teams);
        // Start , Schedule
        $validated = $this->validate([
            'match.name' => 'required|string|max:255',
            'match.location' => 'nullable|string|max:255',
            'match.date' => $this->play == 1 ? 'required|date|after_or_equal:today' : 'nullable',
            'match.time' => $this->play == 1 ? 'required' : 'nullable',
            'match.type' => 'required|in:1,2',
            'teams.A.name' => 'required|string|max:255',
            'teams.A.players.0' => 'required|string|max:255',
            'teams.A.players.1' => $this->match['type'] == 2 ? 'required|string|max:255' : 'nullable',
            'teams.B.players.1' => $this->match['type'] == 2 ? 'required|string|max:255' : 'nullable',
            'teams.B.name' => 'required|string|max:255',
            'teams.B.players.0' => 'required|string|max:255',
        ]);

        dd($validated);
        if ($this->play) {
            $match = MatchModel::create([
                'name' => $this->match['name'],
                'location' => $this->match['location'],
                'date' => $this->match['date'],
                'start_time' => $this->match['time'],
                'shuttles_used' => 0,
                'status' => 'scheduled',
                'type' => $this->match['type'],
                'created_by' => auth()->id(),
            ]);
        } else {
            $match = MatchModel::create([
                'name' => $this->match['name'],
                'location' => $this->match['location'],
                'type' => $this->match['type'],
                'shuttles_used' => 0,
                'status' => 'ongoing',
                'created_by' => auth()->id(),
            ]);
        }

        foreach ($this->teams as $key => $team) {
            $createdTeam = Team::create([
                'match_id' => $match->id,
                'name' => $team['name'],
                'side' => $key
            ]);

            foreach ($team['players'] as $key => $player) {
                $createdPlayer = Player::create([
                    'team_id' => $createdTeam->id,
                    'name' => $player,
                ]);
            }
        }

        $this->reset('teams', 'data', 'play', 'match');
        Flux::modal('create-match')->close();
        $this->dispatch('match-created');

        if ($match->status == 'ongoing') {
            $this->redirectRoute('match.view', $match->id);
        } else {
            $this->redirectRoute('listMatches');
        }
    }
}; ?>

<div class="max-w-2xl mx-auto">
    <!-- Main Content Card -->
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
       
        <div class="p-6 ">
            @if ($step == 1)
                <!-- Step 1: Match Details -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-r from-purple-500 to-violet-600 p-2 rounded-lg">
                            <i class="fas fa-cog text-white"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Match Controls</h3>
                    </div>

                    <flux:radio.group wire:model.live="play" label="When do you want to play this match?"
                        variant="segmented">
                        <flux:radio value="0" icon="play" label="Start Now" />
                        <flux:radio value="1" icon="clock" label="Schedule for Later" />
                    </flux:radio.group>

                    <flux:radio.group wire:model.live="match.type" variant="segmented">
                        <flux:radio value="1" icon="user" label="Singles" />
                        <flux:radio value="2" icon="users" label="Doubles" />
                    </flux:radio.group>


                    <flux:input wire:model="match.name" label="Match Name *" placeholder="e.g., Championship Finals" />
                    <flux:input wire:model="match.location" label="Location" placeholder="e.g., Sports Complex Court 1" />

                    @if ($play)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input wire:model="match.date" label="Match Date *" placeholder="Select date" type="date" />
                            <flux:input wire:model="match.time" label="Match Time *" placeholder="Select time" type="time" />
                        </div>
                    @endif
                </div>

            @elseif ($step == 2)
                <!-- Step 2: Team A -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-r from-red-500 to-pink-600 p-3 rounded-lg">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Team A Configuration</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Set up the first team details</p>
                        </div>
                    </div>

                    <flux:input wire:model="teams.A.name" label="Team Name *" placeholder="e.g., Lightning Warriors" />

                    <div class="space-y-4">
                        <flux:input wire:model="teams.A.players.0" label="Player 1 Name *" placeholder="e.g., John Smith" />

                        @if ($match['type'] == 2)
                            <flux:input wire:model="teams.A.players.1" label="Player 2 Name *" placeholder="e.g., Jane Doe" />
                        @endif
                    </div>
                </div>

            @elseif($step == 3)
                <!-- Step 3: Team B -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-lg">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Team B Configuration</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Set up the second team details</p>
                        </div>
                    </div>

                    <flux:input wire:model="teams.B.name" label="Team Name *" placeholder="e.g., Thunder Eagles" />

                    <div class="space-y-4">
                        <flux:input wire:model="teams.B.players.0" label="Player 1 Name *"
                            placeholder="e.g., Mike Johnson" />

                        @if ($match['type'] == 2)
                            <flux:input wire:model="teams.B.players.1" label="Player 2 Name *"
                                placeholder="e.g., Sarah Connor" />
                        @endif
                    </div>
                </div>
            @endif
            @if($step == 4)
                <div class=" bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
                    <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Match Summary</h4>
                    <div class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                        <p><strong>Match:</strong> {{ $match['name'] ?? 'Not specified' }}</p>
                        <p><strong>Location:</strong> {{ $match['location'] ?? 'Not specified' }}</p>
                        <p><strong>Type:</strong> {{ $match['type'] == 1 ? 'Singles' : 'Doubles' }}</p>
                        <p><strong>Team A:</strong> {{ $teams['A']['name'] ?? 'Not specified' }}</p>
                        <p><strong>Team A Player 1:</strong> {{ $teams['A']['players'][1] ?? 'Not specified' }}</p>
                        <p><strong>Team A Player 2:</strong> {{ $teams['A']['players'][2] ?? 'Not specified' }}</p>
                        <p><strong>Team B:</strong> {{ $teams['B']['name'] ?? 'Not specified' }}</p>
                        <p><strong>Team B Players 1:</strong> {{ $teams['B']['players'][1] ?? 'Not specified' }}</p>
                        <p><strong>Team B Players 2:</strong> {{ $teams['B']['players'][2] ?? 'Not specified' }}</p>
                    </div>
                </div>
            @endif
        </div>


        <!-- Action Buttons -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center justify-between">
                <!-- Previous Button -->
                @if($step > 1)
                    <flux:button wire:click="previousStep()" variant="outline">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-chevron-left text-sm"></i>
                            <span>Previous</span>
                        </div>
                    </flux:button>
                @else
                    <div></div>
                @endif

                <!-- Next/Create Button -->
                <div class="">
                      <span class="text-sm font-medium  mr-8 text-gray-600 dark:text-gray-300">
                    Step {{ $step }} of 3
                </span>
                    @if($step < 4)
                        <flux:button wire:click="nextStep()" variant="primary">
                            <div class="flex items-center gap-2">
                                <span>Next</span>
                                <i class="fas fa-chevron-right text-sm"></i>

                            </div>
                        </flux:button>
                    @else
                        <flux:button wire:click="createMatch()" variant="primary">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-play text-sm"></i>
                                <span>Create Match</span>
                            </div>
                        </flux:button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card (visible on final step) -->

</div>