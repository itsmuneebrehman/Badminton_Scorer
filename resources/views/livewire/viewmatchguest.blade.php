<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use App\Models\MatchModel;
use App\Models\Score;
use App\Models\Team;
 
new
#[Layout('layouts.guest')]
#[Title('Login')]
class extends Component
{
     public $match;
    public $scores = [];

    public function mount($id)
    {
        $matchId = $id; // Assuming $id is passed as a parameter to the component
        $this->match = MatchModel::with('teams')->findOrFail($matchId);
        $this->match->status='ongoing';
        $this->match->save();

        // Load scores for the first set (default)
        foreach ($this->match->teams as $team) {
            $this->scores[$team->id] = Score::firstOrCreate(
                ['match_id' => $this->match->id, 'team_id' => $team->id, 'set_number' => 1],
                ['points' => 0]
            )->points;
        }
    }


}; ?>

<style>
    @keyframes ballPulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }
    }

    .animate-ball-pulse {
        animation: ballPulse 2s ease-in-out infinite;
    }


    /* Mobile optimizations */
    @media (max-width: 640px) {
        .court-container {
            width: calc(100vw - 2rem);
            max-width: 350px;
            height: 400px;
        }
    }
</style>
<div class=" min-h-screen">
    <div>
    <div class="flex justify-between bg-gray-800 p-4 rounded-xl">
        @foreach ($match->teams as $team)
            <div class="flex items-center justify-between w-1/2 px-2">
                <div class="flex items-center space-x-3">
                    <flux:avatar size="sm" name="{{ $team->name }}" color="auto"/>
                    <span class="text-white text-lg">{{ $team->name }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xl text-white">{{ $scores[$team->id] ?? 0 }}</span>
                    <button wire:click="addPoint({{ $team->id }})"
                        class="bg-gray-700 px-4 py-2 rounded-lg text-white hover:bg-gray-600">
                        +1
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

    <main class="bg-gray-800 mx-2 sm:mx-4 my-2 sm:my-4 border rounded-2xl min-h-screen sm:min-h-0">

        <!-- Timer Section -->
        <div class="flex items-center rounded-t-2xl justify-center bg-gray-900 p-3 pb-0 sm:p-4 sm:pb-0">
            <div class="w-full max-w-md">
                <!-- Timer Display -->
                <div class="mb-4 sm:mb-6 flex justify-center">
                    <div class="bg-opacity-80 flex items-center space-x-2 rounded-full bg-gray-700 px-3 sm:px-4 py-2">
                        <div class="flex h-3 w-3 sm:h-4 sm:w-4 items-center justify-center rounded-full bg-gray-400">
                            <svg class="h-2 w-2 sm:h-2.5 sm:w-2.5 text-gray-600" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="font-mono text-xs sm:text-sm text-white">00:00:08</span>
                    </div>
                </div>

                <!-- Voice Chat Container -->
                <div class="overflow-hidden md:flex justify-between items-center gap-4  rounded-2xl ">
                    <!-- First Participant -->
                    <div
                        class="flex md:w-96 items-center bg-gray-800 justify-between border-b border-gray-700 p-3 sm:p-2">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <span class="text-sm sm:text-base text-gray-400">-</span>
                            <div
                                class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center overflow-hidden rounded-full bg-gray-600">
                                <!-- UK Flag -->
                                <flux:avatar size="sm" name="A" color="auto" {{-- color:seed="{{ $user->id }}" --}} />
                            </div>
                            <span class="text-base sm:text-lg text-white">Sajid</span>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <div class="h-2 w-2 sm:h-3 sm:w-3 animate-pulse rounded-full bg-green-500"></div>
                            <span class="text-lg sm:text-xl text-white">0</span>
                        </div>
                    </div>

                    <!-- Second Participant -->
                    <div class="flex items-center bg-gray-800 md:w-96 justify-between p-3 sm:p-2">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <span class="text-sm sm:text-base text-gray-400">-</span>
                            <div
                                class="flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center overflow-hidden rounded-full bg-gray-600">
                                <!-- UK Flag -->
                                <flux:avatar size="sm" name="B" color="auto" {{-- color:seed="{{ $user->id }}" --}} />



                            </div>
                            <span class="text-base sm:text-lg text-white">Badshah</span>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <span class="text-lg sm:text-xl text-white">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id="court-and-controls" class="md:flex md:items-center md:justify-center bg-gray-900 md:gap-4 flex-wrap">


            <!-- Points Button -->
            <section class="flex items-center justify-center bg-gray-900 p-3 sm:p-4">
                <div class="w-full max-w-md space-y-3 sm:space-y-4">

                    <div class="flex justify-center">
                        <button
                            class="w-full max-w-xs rounded-2xl bg-gray-700 px-4 sm:px-6 py-3 md:py-28 md:px-4 sm:py-4 text-base sm:text-lg font-medium text-gray-300 transition-colors duration-200 hover:bg-gray-600">+1</button>
                    </div>
                </div>
            </section>
            <!-- Court Section -->
            <section class="bg-gray-900 flex justify-center items-center p-3 sm:p-5 font-sans">
                <div class="relative">
                    <!-- Court Container -->
                    <div
                        class="court-container w-80 sm:w-96 h-80  md:aspect-video sm:h-[500px] md:w-[640px] md:h-96 bg-gray-800 border-4 border-emerald-400 rounded-xl relative shadow-2xl">
                        <!-- Court Lines -->
                        <div class="absolute inset-0">
                            <!-- Mobile (default) -->
                            <div
                                class="absolute md:hidden left-0 right-0 h-0.5 bg-[#6ee7b7] top-1/2 transform -translate-y-0.5">
                            </div>
                            <div
                                class="absolute md:hidden top-0 bottom-0 w-0.5 bg-[#6ee7b7] left-1/2 transform -translate-x-0.5">
                            </div>
                            <div class="absolute md:hidden left-0 right-0 h-0.5 bg-[#6ee7b7]" style="top: 30%;"></div>
                            <div class="absolute md:hidden left-0 right-0 h-0.5 bg-[#6ee7b7]" style="bottom: 30%;">
                            </div>

                            <!-- Desktop (md and up, swapped) -->
                            <div
                                class="absolute hidden md:block top-0 bottom-0 w-0.5 bg-[#6ee7b7] left-1/2 transform -translate-x-0.5">
                            </div>
                            <div
                                class="absolute hidden md:block left-0 right-0 h-0.5 bg-[#6ee7b7] top-1/2 transform -translate-y-0.5">
                            </div>
                            <div class="absolute hidden md:block top-0 bottom-0 w-0.5 bg-[#6ee7b7]" style="left: 30%;">
                            </div>
                            <div class="absolute hidden md:block top-0 bottom-0 w-0.5 bg-[#6ee7b7]" style="right: 30%;">
                            </div>
                        </div>

                        {{-- Extraaaas --}}
                        <!-- Player Sajid -->
                        <div
                            class="absolute top-2 sm:top-5 left-2 sm:left-5 flex items-center gap-1 sm:gap-2 text-white text-sm sm:text-lg font-medium">
                            <div
                                class="w-4 h-4 sm:w-6 sm:h-6 bg-purple-500 rounded-full flex items-center justify-center text-xs">
                                👤
                            </div>
                            <span class="text-xs sm:text-base">Sajid</span>
                        </div>

                        <!-- Player Badshah -->
                        <div
                            class="absolute bottom-2 sm:bottom-5 right-2 sm:right-5 flex items-center gap-1 sm:gap-2 text-white text-sm sm:text-lg font-medium">
                            <div
                                class="w-4 h-4 sm:w-6 sm:h-6 bg-purple-500 rounded-full flex items-center justify-center text-xs">
                                👤
                            </div>
                            <span class="text-xs sm:text-base">Badshah</span>
                        </div>

                        <!-- Ball -->
                        <div id="ball"
                            class="absolute w-3 h-3 sm:w-4 sm:h-4 bg-emerald-500 rounded-full shadow-emerald-500/60 shadow-lg animate-ball-pulse transition-all duration-700 ease-in-out"
                            style="left: 100px; top: 160px;"></div>
                    </div>
                </div>
            </section>


            <!-- Controls Section -->
           <section class="flex items-center justify-center bg-gray-900 p-3 sm:p-4">
                <div class="w-full max-w-md space-y-3 sm:space-y-4">

                    <div class="flex justify-center">
                        <button
                            class="w-full  max-w-xs rounded-2xl bg-gray-700 px-4 sm:px-6 py-3 sm:py-4 md:py-28 md:px-4 text-base sm:text-lg font-medium text-gray-300 transition-colors duration-200 hover:bg-gray-600">+1</button>
                    </div>
                </div>
            </section>
        </section>

        <section class="bg-gray-900 rounded-2xl flex flex-col items-center justify-center pt-0 sm:pt-0 p-3 sm:p-4 gap-3 sm:gap-4">


            <!-- Control Buttons Row -->
            <div class="flex gap-2 sm:gap-3 flex-wrap justify-center">
                <!-- Layers/Stack Icon -->
                <button
                    class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-700 hover:bg-gray-600 rounded-xl sm:rounded-2xl flex items-center justify-center text-white transition-all duration-200 hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                </button>

                <!-- Chat/Message Icon -->
                <button
                    class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-700 hover:bg-gray-600 rounded-xl sm:rounded-2xl flex items-center justify-center text-cyan-400 transition-all duration-200 hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </button>



                <!-- Undo Icon -->
                <button
                    class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-600 hover:bg-gray-500 rounded-xl sm:rounded-2xl flex items-center justify-center text-gray-400 transition-all duration-200 hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                </button>

                <!-- Redo Icon -->
                <button
                    class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-600 hover:bg-gray-500 rounded-xl sm:rounded-2xl flex items-center justify-center text-gray-400 transition-all duration-200 hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6" />
                    </svg>
                </button>

                <!-- Menu/Hamburger Icon -->
                <button
                    class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-600 hover:bg-gray-500 rounded-xl sm:rounded-2xl flex items-center justify-center text-gray-400 transition-all duration-200 hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </section>
    </main>
</div>
