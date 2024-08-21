<!-- resources/views/livewire/input-data-bill.blade.php -->
<div class="container-wrap align-middle p-5">
    <div class="p-5 bg-white max-w-md mx-auto md:mt-5 place-items-center rounded-lg shadow-lg">
        <h1 class="text-center text-gray-700 text-xl font-bold mb-4">Massukkan Data Anda</h1>

        <!-- Notification Handling -->
        <x-loading/>

        @if ($notification)
        <div x-data="{ open: @entangle('open'), notificationType: @entangle('notificationType') }"
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 flex p-5 items-center justify-center z-50">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div :class="{
                'text-green-500': notificationType === 'success',
                'text-red-500': notificationType === 'error',
                'text-blue-500': notificationType === 'info'
            }"
                 class="relative bg-white text-center font-semibold rounded-2xl shadow-lg p-4 max-w-md mx-auto"
                 role="alert"
                 aria-live="assertive">
                <button @click="open = false" class="absolute top-2 right-2 text-gray-900" aria-label="Close notification">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <p class="p-2 my-2 mx-5">{{ $notification }}</p>
            </div>
        </div>
        @endif

        <!-- NIK Check Form -->
        <form wire:submit.prevent="ceknik" class="{{ $display }} grid">
            <div class="mb-4">
                <!-- <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK</label> -->
                <input id="nik" wire:model.defer="nik" type="text" placeholder="Masukkan NIK (Nomor Induk Kependudukan) Anda"
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" class="justify-self-center bg-[#00bcd5] hover:bg-blue-700 text-white font-bold py-2 px-10 rounded-xl">
                Submit
            </button>
        </form>

        <!-- Display Messages -->
        @if ($showmessage && $pesan)
        <div class="mt-4">
            @if ($isFound)
            <div class="mb-4 bg-green-100 text-green-800 p-4 rounded-md">
                {{ $pesan }}
                <br>Apakah anda akan menggunakan data ini?
            </div>
            <div class="flex gap-4 justify-end my-5">
                <button onclick="window.location.reload();" class="bg-slate-500 hover:bg-gray-700 text-white py-2 px-4 rounded-lg">
                    Kembali</button>
                <button class="ml-4 bg-[#00bcd5] hover:bg-blue-700 text-white px-4 py-2 rounded-lg" wire:click="regbaru">
                    Lanjutkan</button>
            </div>
            @else
            <div class="mb-4 grid bg-red-100 text-red-800 p-4 rounded-lg">
                {{ $pesan }}
                <br>Apakah anda akan mengisi data baru?
                <div class="flex gap-4 justify-end my-5">
                    <button onclick="window.location.reload();" class="bg-slate-500 hover:bg-gray-700 text-white py-2 px-4 rounded-lg">
                        Kembali</button>
                    <button class="ml-4 bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-blue-600" wire:click="regbaru">
                        Isi Data Baru</button>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Additional Data Form -->
        @if ($formstatus === 1)
        <form wire:submit.prevent="regSave" class="grid">
            <div class="mb-4">
                <label for="nik-display" class="block text-gray-700 text-sm font-bold mb-2">NIK</label>
                <input id="nik-display" type="text" value="{{ $nik }}" readonly
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                <input id="nama" type="text" placeholder="Masukkan Nama Anda" wire:model.defer="nama" {{ $readonly }}
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('nama') <p class="text-red-600 mb-4">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                <input id="alamat" type="text" placeholder="Masukkan Alamat Anda" wire:model.defer="alamat" {{ $readonly }}
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('alamat') <p class="text-red-600 mb-4">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="nohp" class="block text-gray-700 text-sm font-bold mb-2">No HP (WA)</label>
                <input id="nohp" type="text" placeholder="Masukkan No Handphone (WA) Anda" wire:model.defer="nohp" {{ $readonly }}
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('nohp') <p class="text-red-600 mb-4">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input id="email" type="email" placeholder="Masukkan Alamat Email Anda" wire:model.defer="email" {{ $readonly }}
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('email') <p class="text-red-600 mb-4">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="merchant" class="block text-gray-700 text-sm font-bold mb-2">Merchant</label>
                <select id="merchant" wire:model.defer="merchant"
                 class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full p-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @if($merchants)
                    <option value="">Pilih Merchants</option>
                    @foreach($merchants as $merch)
                        <option value="{{ $merch->id }}">{{ $merch->nm_merchant }}</option>
                    @endforeach
                    @endif
                </select>
                @error('merchant') <p class="text-red-600 mb-4">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="tglbill" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Transaksi</label>
                <input wire:model.defer="tglbill" type="date" id="tglbill" name="tglbill"
                       min="2024-08-17" max="2024-10-30"
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('tglbill') <p class="text-red-600 mb-4">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="jambill" class="block text-gray-700 text-sm font-bold mb-2">Jam Transaksi</label>
                <input wire:model.defer="jambill" type="time" id="jambill" name="jambill"
                       min="00:00:00" max="24:59:59" step="2"
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('jambill') <p class="text-red-600 mb-4">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Photo</label>
                <input type="file" id="photo" wire:model="photo" accept="image/*"
                       class="shadow bg-[#e5e7eb] text-md appearance-none border-none rounded w-full py-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('photo') <p class="text-red-600 mb-4">{{ $message }}</p> @enderror
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="mt-2 w-full h-auto">
                @endif
            </div>

            <button type="submit" class="justify-self-center bg-[#00bcd5] hover:bg-blue-700 text-white font-bold py-2 px-10 rounded-xl">
                Save
            </button>
        </form>
        @endif
    </div>
</div>
