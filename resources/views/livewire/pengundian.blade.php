<div class="w-full h-screen flex justify-items-center bg-white">

    <audio id="background-music" src="{{ asset('storage/sound/sound-undian.mp3') }}" preload="auto"></audio>

    <div class="bg-black w-1/3 p-20">
        <div class="w-full grid justify-items-center">
            <button wire:click="undiPemenang" class="bg-[#ce6113] text-white text-4xl rounded-full w-44 h-44 justify-center shadow-lg" onclick="playMusic(); this.classList.add('hidden')">Mulai</button>
                <div wire:loading class="w-full">
                    <img class="w-44 animate-[spin_2s_linear_infinite] mx-auto" src="{{ asset('storage/image/roda.png') }}" alt="logo">
                </div>
                
            </div>
            <div class="w-full">
                    <img class="w-72 mx-auto" src="{{ asset('storage/image/text-roda.png') }}" alt="logo">
                </div>
        
        
    </div>
    <div class="pemenang p-20 w-2/3 justify-center bg-white">


        
        <h1 class="font-bold text-4xl bg-[#ce6113] p-5 text-white text-center mb-20">Pemenang Hadiah Scoopy</h1>
        
        @if($hadiah===1)
        <div class="my-10 p-5 bg-[#ce6113] rounded-xl shadow-xl">
            <div class="flex h-full">
                <img class="w-64 m-auto align-middle animate-[bounce_10s_ease-out_infinite]" src="{{ asset('storage/image/scoopy.png') }}" alt="Scoopy" />
            </div>
            <ul class="">

                    @foreach (range(1, 1) as $index)
                    <li class="w-full font-semibold text-lg text-center">
                        <div class="grid justify-center mx-auto max-w-[70%] mb-2 bg-white min-h-36 p-2 rounded-md">
                            <span wire:stream="winner{{ $index }}no" class="text-4xl font-black min-h-5">{{ ${'winner' . $index . 'no'} }}</span>
                            <span wire:stream="winner{{ $index }}name" class="text-2xl font-black min-h-5">{{ ${'winner' . $index . 'name'} }}</span>
                        </div>
                    </li>
                @endforeach
                       
                </ul>
            </div>
            </div>
        @else
        <div class="flex w-full bg-[#ce6113] p-5 shadow-xl">
            <div class="flex w-1/3 self-center h-full">
                <img class="w-72 m-auto animate-[bounce_10s_ease-out_infinite]" src="{{ asset('storage/image/scoopy.png') }}" alt="Scoopy" />
            </div>
            <ul class="w-2/3">
                @foreach (range(1, 5) as $index)
                    <li class="w-full font-semibold text-lg text-center">
                        <div class="flex justify-center mb-2 bg-white p-2 rounded-md">
                            <span wire:stream="winner{{ $index }}no" class="text-xl font-black min-h-5 w-[25%] border-e-2">{{ ${'winner' . $index . 'no'} }}</span>
                            <span wire:stream="winner{{ $index }}name" class="text-lg font-black min-h-5 w-[75%] border-s-2">{{ ${'winner' . $index . 'name'} }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>


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


    window.addEventListener('start-drawing', function() {
        setInterval(() => {
            @this.call('updateRandomNomor');
        }, 100); // Update nomor setiap 1 detik
    });
</script>

