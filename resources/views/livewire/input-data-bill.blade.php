<div class="container-wrap align-middle p-5 ">
    {{-- The Master doesn't talk, he acts. --}}
    <div class="p-5 bg-white max-w-md mx-auto rounded-lg shadow-lg">
        <h1 class="text-center text-gray-700 text-xl font-bold mb-4">Data Wajib Pajak dan Data Transaksi</h1>

        <!-- Form to Check NIK -->
        <div wire:loading class="overlay z-50 h-screen w-screen opacity-50 top-0 left-0 bg-black" style="position:fixed !important">
                    <div class="animate-bounce fixed top-1/2 left-1/2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    </div>
        </div>

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



        <form wire:submit.prevent="ceknik" class="{{$display}}">
            <!-- Form Group -->
            <div class="mb-4">
                <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK</label>
                <input id="nik" wire:model="nik" type="text" placeholder="Masukkan NIK (Nomor Induk Kependudukan) Anda" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <button type="submit" class="bg-yellow-500  hover:bg-blue-600 text-center block py-2 px-4 rounded">Cek Data</button>
        </form>
        
        
        @if ($showmessage && $pesan)
        <div class="mt-4">
            @if ($isFound)
                <div class="mb-4 bg-green-100 text-green-800 p-4 rounded-md">
                    {{ $pesan }} <br>
                </div>
                <button class="ml-4 bg-blue-500 text-white px-2 py-1 rounded-md
                hover:bg-blue-600" wire:click="tambahreg">Lanjutkan</button>
            @else
                <div class="mb-4 bg-red-100 text-red-800 p-4 rounded-md">
                    {{ $pesan }} <br>
                </div>
                <button class="ml-4 bg-yellow-500 text-white px-2 py-1 rounded-md
                hover:bg-blue-600" wire:click="regbaru">Isi Data Baru</button>
            @endif
        </div>
    @endif

        <!-- Conditionally Rendered Form -->
        @if ($formstatus === 1)
        <form wire:submit.prevent="regSave">
            <div class="mb-4">
                <!-- NIK Displayed as Read-Only -->
                <div class="mb-4">
                    <label for="nik-display" class="block text-gray-700 text-sm font-bold mb-2">NIK</label>
                    <input id="nik-display" type="text" value="{{ $nik }}" readonly 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                    <input id="nama" type="text" placeholder="Masukkan Nama Anda" wire:model="nama" {{$readonly}}
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nama') <p class="error text-red-600 mb-4">{{ $message }}</p> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                    <input id="alamat" type="text" placeholder="Masukkan Alamat Anda" wire:model="alamat" {{$readonly}} 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('alamat') <p class="error text-red-600 mb-4">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="nohp" class="block text-gray-700 text-sm font-bold mb-2">No HP (WA)</label>
                    <input id="nohp" type="text" placeholder="Masukkan No Handphone (WA) Anda" wire:model="nohp" {{$readonly}}
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('nohp') <p class="error text-red-600 mb-4">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input id="email" type="email" placeholder="Masukkan Alamat Email Anda" wire:model="email" {{$readonly}}
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('email') <p class="error text-red-600 mb-4">{{ $message }}</p> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="merchant" class="block text-gray-700 text-sm font-bold mb-2">Merchant</label>
                    <select id="merchant" wire:model="merchant" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @if($merchants)
                    <option>Pilih Merchants</option>
                    @foreach($merchants as $merch)
                        <option value="{{ $merch->id }}">{{ $merch->nm_merchant }}</option> <!-- Adjust based on your Merchant model attributes -->
                    @endforeach
                    @endif
                    </select>
                </div>
                @error('merchant') <p class="error text-red-600 mb-4">{{ $message }}</p> @enderror
                
                
                <div class="mb-4">
                   <label for="tglbill" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Transaksi</label>
                    <input wire:model="tglbill" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    type="date"
                    id="tglbill"
                    name="tglbill"
                    min="2024-08-17"
                    max="2024-10-30" />
                </div> 
                @error('tglbill') <p class="error text-red-600 mb-4">{{ $message }}</p> @enderror 
                <div class="mb-4">
                   <label for="jambill" class="block text-gray-700 text-sm font-bold mb-2">Jam Transaksi</label>
                    <input wire:model="jambill" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    type="time"
                    step="2"
                    id="jambill"
                    name="jambill"
                    min="00:00:00"
                    max="24:59:59" />
                </div> 
                @error('jambill') <p class="error text-red-600 mb-4">{{ $message }}</p> @enderror
                <div class="mb-4">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    type="file" wire:model="photo">                    
                </div>
                @error('photo') <p class="error text-red-600 mb-4">{{ $message }}</p> @enderror                
                
        </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
        </form>
        @endif
    </div>
</div>
