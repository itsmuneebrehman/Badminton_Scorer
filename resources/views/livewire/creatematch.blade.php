<?php

use Livewire\Volt\Component;
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

    public $play;
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

    public function mount(){
                // 'created_by'=> ,
        // dd(auth()->id());
    
    }
    public function createMatch()
    {
        // dd($type, $this->match, $this->teams);
        // Start , Schedule
        $validated = $this->validate([
            'match.name' => 'required|string|max:255',
            'match.location' => 'required|string|max:255',
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

        // dd($validated);
        // 'name',
        // 'location',
        // 'start_time',
        // 'date',
        // 'status',
        // 'shuttles_used',
        if ($this->play) {
            $match = MatchModel::create([
                'name' => $this->match['name'],
                'location' => $this->match['location'],
                'date' => $this->match['date'],
                'start_time' => $this->match['time'],
                'shuttles_used' => 0,
                'status' => 'scheduled',
                'type' => $this->match['type'],
                'created_by'=> auth()->id(),
            ]);
        } else {
            $match = MatchModel::create([
                'name' => $this->match['name'],
                'location' => $this->match['location'],
                'type' => $this->match['type'],
                'shuttles_used' => 0,
                'status' => 'ongoing',
                'created_by'=> auth()->id(),
            ]);

        }

        // dd($match);


        // $this->data['match'][] = $match;

        foreach ($this->teams as $key => $team) {
            // dd($value);
            $createdTeam = Team::create([
                'match_id' => $match->id,
                'name' => $team['name'],
                'side' => $key
            ]);
            // dd($createdTeam,$team);
            // $this->data['teams'][] = $createdTeam;


            foreach ($team['players'] as $key => $player) {
                $createdPlayer = Player::create([
                    'team_id' => $createdTeam->id,
                    'name' => $player,
                ]);
                // $this->data['players'][] = $createdPlayer;
            }
        }
        // dd($this->data);
        $this->reset('teams','data','play','match');
        Flux::modal('create-match')->close();
        $this->dispatch('match-created');
        if ($match->status == 'ongoing') {
        $this->redirectRoute('match.view', $match->id);
        } else {
            $this->redirectRoute('listMatches');

        }


    }







}; ?>

<div>
    <!-- Main Content -->
    <div class=" ">
        <div class="space-y-8">

            <!-- Progress Indicator -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Match Setup </h2>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div id="progressBar"
                        class="bg-gradient-to-r from-green-500 to-emerald-600 h-2 rounded-full transition-all duration-500"
                        style="width: 90%"></div>
                </div>
            </div>
            <!-- Section 4: Match Controls -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-gradient-to-r from-purple-500 to-violet-600 p-2 rounded-lg">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Match Controls</h3>
                </div>

                <flux:select wire:model.live="play" label="When do you want to play this match?">
                    <flux:select.option value="0" label="Start Now" selected />
                    <flux:select.option value="1" label="Schedule for Later" />
                </flux:select>
            </div>



            <!-- Section 1: Match Details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-2 rounded-lg">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Match Details</h3>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <flux:input wire:model="match.name" label="Match Name *" placeholder="e.g., Championship Finals" />
                    <flux:input wire:model="match.location" label="Location *"
                        placeholder="e.g., Sports Complex Court 1" />
                    @if ($play)

                        <flux:input wire:model="match.date" label="Match Date *" placeholder="Select date" type="date" />

                        <flux:input wire:model="match.time" label="Match Time *" placeholder="Select time" type="time" />
                    @endif


                    <flux:select wire:model.live="match.type" label="Match Type *">
                        <flux:select.option value="1" selected> Singles</flux:select.option>
                        <flux:select.option value="2"> Doubles</flux:select.option>
                    </flux:select>
                </div>
            </div>

            <!-- Section 2: Team A -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-gradient-to-r from-red-500 to-pink-600 p-2 rounded-lg">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Team A</h3>
                </div>
                <div class=" ">
                    <flux:input wire:model="teams.A.name" label="Team Name *" placeholder="e.g., Lightning Warriors" />
                </div>

                <div class=" mt-2 grid grid-cols-1 gap-6">
                    <div class=" ">
                        <flux:input wire:model="teams.A.players.0" label=" Player 1 Name *"
                            placeholder="e.g., John Smith" />
                    </div>
                    @if ($match['type'] == 2)
                        <div class=" ">
                            <flux:input wire:model="teams.A.players.1" label=" Player 2 Name *"
                                placeholder="e.g., Jane Doe" />
                        </div>
                    @endif

                </div>
            </div>

            <!-- Section 3: Team B -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-2 rounded-lg">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Team B</h3>
                </div>
                <div class=" ">
                    <flux:input wire:model="teams.B.name" label="Team Name *" placeholder="e.g., Thunder Eagles" />
                </div>

                <div class=" mt-2 grid grid-cols-1 gap-4">
                    <div class=" ">
                        <flux:input wire:model="teams.B.players.0" label=" Player 1 Name *"
                            placeholder="e.g., Mike Johnson" />
                    </div>
                    @if ($match['type'] == 2)
                        <div class=" ">
                            <flux:input wire:model="teams.B.players.1" label=" Player 2 Name *"
                                placeholder="e.g., Sarah Connor" />
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 5: Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-end">

                    <flux:button wire:click="createMatch()" variant="primary">
                        <div class="flex items-center gap-2">
                            <flux:icon.play />
                            <span>Create Now</span>
                        </div>
                    </flux:button>

                </div>
            </div>
        </div>
    </div>
</div>