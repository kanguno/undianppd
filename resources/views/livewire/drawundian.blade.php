<div class="w-full h-screen py-20 grid justify-items-center bg-gradient-to-tr from-[#9a41d7] to-[#400060]">

    <audio id="background-music" src="{{ asset('storage/sound/sound-undian.mp3') }}" preload="auto"></audio>

    <div>
        
        <button wire:click="undiPemenang" class="bg-[#ce6113] text-white text-4xl rounded-full px-[20px] py-[42px] justify-center shadow-lg" onclick="playMusic(); this.classList.add('hidden')">Mulai</button>
        
        <div wire:loading>
            <div class="w-full -m-20">
                <div class="w-full fixed left-0">
                    <img class="w-72 animate-[spin_2s_linear_infinite] mx-auto" src="{{ asset('storage/image/roda.png') }}" alt="logo">
                </div>    
                <div class="w-full fixed left-0">
                    <img class="w-72 mx-auto" src="{{ asset('storage/image/text-roda.png') }}" alt="logo">
                </div>
            </div>
        </div>

        @if($finishDraw)
            <div class="pemenang grid w-full justify-center">
                <h1 class="font-bold text-4xl text-white text-center">Pemenang Hadiah Scoopy</h1>
                @if($hadiah===1)
                <div class="grid w-full my-10 bg-[#ce6113] p-5 rounded-xl shadow-xl">
                    <div class="flex h-full">
                        <img class="w-72 m-auto align-middle animate-[bounce_10s_ease-out_infinite]" src="{{ asset('storage/image/scoopy.png') }}" alt="Scoopy" />
                    </div>
                    <ul class="w-full">
                       
                        <li class="w-full m-auto font-semibold align-center text-lg text-center">
                                <div class="grid justify-center bg-white p-2 rounded-md">
                                    <span class="text-5xl font-black w-full border-b-2">{{ $winner1no}}</span>
                                    <span class="text-2xl font-black w-full">{{ $winner1name }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                @else
                <div class="flex w-full my-10 gap-10 bg-[#ce6113] p-5 rounded-xl shadow-xl">
                    <div class="flex w-1/3 h-full">
                        <img class="w-72 m-auto align-middle animate-[bounce_10s_ease-out_infinite]" src="{{ asset('storage/image/scoopy.png') }}" alt="Scoopy" />
                    </div>
                    <ul class="w-2/3">
                        @foreach ([$winner1no, $winner2no, $winner3no, $winner4no, $winner5no] as $index => $winnerNo)
                            <li class="w-full font-semibold text-lg text-center">
                                <div class="flex justify-center mb-2 bg-white p-2 rounded-md">
                                    <span class="text-xl font-black w-[25%] border-e-2">{{ $winnerNo }}</span>
                                    <span class="text-lg font-black w-[75%] border-s-2">{{ ${'winner' . ($index + 1) . 'name'} }}</span>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                        @endif
            </div>
        @endif
    </div>
</div>

<script>
    function playMusic() {
        const music = document.getElementById('background-music');
        music.play().catch(function(error) {
            console.log("Playback failed: " + error);
        });
    }
</script>

