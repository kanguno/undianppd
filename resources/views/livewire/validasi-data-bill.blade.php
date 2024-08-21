<div class="bg-white p-10">
<h1 class="font-bold text-2xl text-center">Validasi Data Undian Pajak Daerah Tahun 2024</h1>    

@if ($notification) 
    <div 
        x-data="{ 
            open: @entangle('open'), 
            notificationType: @entangle('notificationType') 
        }"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex p-5 items-center justify-center z-50"
    >
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div 
            :class="{
                'text-green-500': notificationType === 'success',
                'text-red-500': notificationType === 'error',
                'text-blue-500': notificationType === 'info'
            }"
            class="relative bg-white text-center font-semibold rounded-2xl shadow-lg p-4 max-w-md mx-auto"
            role="alert"
            aria-live="assertive"
        >
            <button @click="open = false" class="absolute top-2 right-2 text-gray-900" aria-label="Tutup notifikasi">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <p class="p-2 my-2 mx-5">{{ $notification }}</p>
        </div>
    </div>
@endif


<div class="my-10 p-10">
    @forelse($dataregs as $index => $reg)
    <div class="grid md:flex gap-10">
        <div class="md:w-1/2">
        <table class="table border-none text-lg">
            <tbody>
                <tr>
                    <td colspan="3" class="py-5 font-bold text-center">Data Wajib Pajak</td> 
                </tr>
                <tr>
                    <td class="px-4 py-2 text-start">No Regristasi</td>
                    <td class="px-4 py-2 text-start">:</td>
                    <td class="px-4 py-2 text-start">{{ $reg->id }}</td>
                </tr>

                <tr>
                    <td class="px-4 py-2 text-start">NIK</td>
                    <td class="px-4 py-2 text-start">:</td>
                    <td class="px-4 py-2 text-start">{{ $reg->nik }}</td>
                </tr>
                <tr> 
                    <td class="px-4 py-2 text-start">Nama Wajib Pajak</td>
                    <td class="px-4 py-2 text-start">:</td>   
                    <td class="px-4 py-2 text-start">{{ $reg->nm_wp }}</td>
                </tr>
                <tr> 
                    <td class="px-4 py-2 text-start">Alamat Wajib Pajak</td>
                    <td class="px-4 py-2 text-start">:</td>   
                    <td class="px-4 py-2 text-start">{{ $reg->alm_wp }}</td>
                </tr>
                <tr> 
                    <td class="px-4 py-2 text-start">No HP Wajib Pajak</td>
                    <td class="px-4 py-2 text-start">:</td>   
                    <td class="px-4 py-2 text-start">{{ $reg->nohp }}</td>
                </tr>
                <tr> 
                    <td class="px-4 py-2 text-start">Email</td>
                    <td class="px-4 py-2 text-start">:</td>   
                    <td class="px-4 py-2 text-start">{{ $reg->email }}</td>
                </tr>
        
                <tr>
                    <td colspan="3" class="py-5"></td> 
                </tr>
                <tr>
                    <td colspan="3" class="py-5 font-bold text-center">Data Transaksi</td> 
                </tr>
                <tr>
                    <td class="px-4 py-2 text-start">Nama Merchant</td>
                    <td class="px-4 py-2 text-start">:</td>   
                    <td class="px-4 py-2 text-start">{{ $reg->nm_merchant }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 text-start">Tanggal Transaksi</td>
                    <td class="px-4 py-2 text-start">:</td>   
                    <td class="px-4 py-2 text-start">{{ $reg->tgl_bill }}</td>
                </tr>
            </tbody>
        </table>
            <div class="flex my-10">
            <form wire:submit.prevent="validasiStore" class="w-full">
                <div class="mb-5 gap-5 align-middle">
                    <label for="statustappingbox" class="inline-block align-middle text-gray-700 text-sm font-bold mb-2">Apakah data terdapat di Tapping Box?</label>
                    <select class="w-32 border-none rounded-md p-2 font-bold" name="statustappingbox" wire:model="statustappingbox">
                        <option value="1">Ada</option>
                        <option value="0">Tidak</option>
                    </select>
                    @error('statustappingbox') <span class="text-red-600">{{ $message }}</span> @enderror
                    <input class="w-full border-gray-200 rounded-md p-2" type="text" wire:model="tappingboxid" placeholder="ID Taping BOX">
                    @error('tappingboxid') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="mb-5">
                    <textarea class="w-full border-gray-200 rounded-md p-5" name="keterangan" wire:model="keterangan" placeholder="Keterangan Jika Ditolak"></textarea>
                    @error('keterangan') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end gap-3">
                    <button wire:click="tolakValidasi" class="btn text-white bg-red-600">Ditolak</button>
                    <button type="submit" class="btn text-white bg-green-600">Diterima</button>
                </div>
            </form>

            </div>
        </div>
        <div class="img-wrap md:w-1/2 relative">
                <h1  class="py-5 font-bold text-center">Gambar Bill</h1>
                <div class="overflow-scroll p-5 max-h-96" id="scrollable">
                    <img id="draggableImg" style="transform: scale({{ $imgzoom / 100 }}); transform-origin:top left;" class="" src="{{ asset('storage/photos/'.$reg->bill_img) }}" alt="Bill Image for {{ $reg->id }}">
                </div>
                <div class="w-full p-2 shadow-md align-middle">    
                    <label for="imgzoom" class="block text-gray-700 text-sm font-bold mb-1 mt-5">Perbesar Gambar {{$imgzoom}} %</label>
                    <input class="w-full" wire:model.live="imgzoom" type="range" min="50" max="300" step="10" name="imgzoom" id="imgzoom">
                </div>
        </div>

    </div>
        @empty
        <table>
            <tbody>
                <tr>
                    <td colspan="3" class="px-4 py-2 text-start">Data tidak ditemukan</td>
                </tr>
            </tbody>
        </table>
     @endforelse
     
</div>


</div>
<script>
    const img = document.getElementById('draggableImg');
    const scrollable = document.getElementById('scrollable');
    const imgZoomInput = document.getElementById('imgzoom');

    let isDragging = false;
    let startX, startY, scrollLeft, scrollTop;

    // Event listener untuk dragging gambar
    img.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX - img.offsetLeft;
        startY = e.pageY - img.offsetTop;
        scrollLeft = scrollable.scrollLeft;
        scrollTop = scrollable.scrollTop;
    });

    window.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - img.offsetLeft;
        const y = e.pageY - img.offsetTop;
        const walkX = x - startX;
        const walkY = y - startY;
        scrollable.scrollLeft = scrollLeft - walkX;
        scrollable.scrollTop = scrollTop - walkY;
    });

    window.addEventListener('mouseup', () => {
        isDragging = false;
    });

    // Event listener untuk zoom dengan scroll
    scrollable.addEventListener('wheel', (e) => {
        e.preventDefault();

        // Ambil nilai saat ini dari input range
        let currentZoom = parseInt(imgZoomInput.value, 10);

        // Update nilai zoom berdasarkan arah scroll
        if (e.deltaY < 0) {
            currentZoom = Math.min(currentZoom + 10, 300); // Zoom in
        } else {
            currentZoom = Math.max(currentZoom - 10, 50);  // Zoom out
        }

        // Perbarui nilai input range
        imgZoomInput.value = currentZoom;

        // Trigger perubahan Livewire jika diperlukan
        imgZoomInput.dispatchEvent(new Event('input'));
        
        // Update transform scale dari gambar
        img.style.transform = `scale(${currentZoom / 100})`;
    });
</script>
