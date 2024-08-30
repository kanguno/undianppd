<div class="p-10">
    <x-loading/>
    @if($notification)
    <x-notif/>
    @endif
    @if($modalinfo)
    
        <div x-data="{ modalopen: @entangle('modalopen'), notificationType: @entangle('notificationType') }"
             x-show="modalopen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 flex p-5 items-center justify-center z-50">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative bg-white text-center  rounded-2xl shadow-lg p-4 max-w-md mx-auto"
                 role="alert"
                 aria-live="assertive">
                 
                <button @click="modalopen = false" class="absolute top-2 right-2 text-gray-900" aria-label="Close notification">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @if($modalinfo=='formupload')
                
                <form wire:submit.prevent="importData" enctype="multipart/form-data">
                        <div class="grid p-3 justify-items-center">  
                            <div class="grid justify-center text-center bg-gray-300 p-3 rounded-lg">
                                <label for="uploadexcel" class=" text-2xl mx-auto mb-2 hover:cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                                </svg>
                                </label>
                                <p>{{ $fileexcel ? $fileexcel->getClientOriginalName() : 'Klik Icon Untuk Upload File' }}</p>
                                <input id="uploadexcel" type="file" wire:model.live="fileexcel" class="hidden">
                            </div>  
                        <button type="submit" class="mt-10 px-3 py-2 w-fit rounded-md bg-blue-600 text-white">Import</button>
                    </div>
                </form>
                @else
                <p class="p-2 my-2 mx-5">{!!$modalinfo!!}</p>
                
                <div class="flex gap-3 w-full justify-end">

                    <button wire:click="deleteData({{$modalid}})"
                    :class="{
                        'bg-[#43a047]': notificationType === 'success',
                        'bg-[#d81b60]': notificationType === 'error',
                        'bg-blue-600': notificationType === 'info'
                        }"
                        class="px-3 py-2 rounded-lg text-white"
                        >Lanjutkan</button>
                    <button class="px-3 py-2 rounded-lg bg-gray-600 text-white" @click="modalopen = false" aria-label="Close notification">Batal</button>
                    
                </div>
                @endif
            </div>
        </div>
    @endif
    <div class="mb-10 mx-auto md:w-full rounded-md shadow-md bg-white {{ $hidden }}">
        <form wire:submit.prevent="{{$wiresubmit}}" class=" grid p-6 justify-arround">
            <h2 class="mb-10 text-lg font-semibold text-center">Tambah Data Merchant</h2>
            <div class="mb-4 grid md:flex md:flex-wrap md:gap-3 justify-center w-full">
                <!-- <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK</label> -->
                <input id="namamerchant" wire:model.defer="namamerchant" type="text" placeholder="Masukkan Nama Merchant"
                class="shadow mb-3 bg-[#e5e7eb] text-md appearance-none border-none rounded p-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline w-full">
                @error('namamerchant') <br><p class="text-red-600 mb-4">{{ $message }}</p> @enderror

                <!-- <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK</label> -->
                <input id="deviceid" wire:model.defer="deviceid" type="text" placeholder="Masukkan Device ID"
                class="shadow mb-3 bg-[#e5e7eb] text-md appearance-none border-none rounded p-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline w-full">
                @error('deviceid') <br><p class="text-red-600 mb-4">{{ $message }}</p> @enderror

                <input id="nopd" wire:model.defer="nopd" type="text" placeholder="Masukkan NOPD"
                class="shadow mb-3 bg-[#e5e7eb] text-md appearance-none border-none rounded p-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline w-full">
                @error('nopd') <br><p class="text-red-600 mb-4">{{ $message }}</p> @enderror
                
                <input id="almmerchant" wire:model.defer="almmerchant" type="text" placeholder="Masukkan Alamat Merchant"
                class="shadow mb-3 bg-[#e5e7eb] text-md appearance-none border-none rounded p-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline w-full"><br>
                @error('almmerchant') <br><p class="text-red-600 mb-4">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="justify-self-end bg-[#00bcd5] hover:bg-[#1a73e8] text-white font-bold py-2 px-10 rounded-xl">
                Submit
            </button>
        </form>
    </div>

    <table class="my-5 mx-auto w-full rounded-md shadow-md bg-white {{$tablehidden}}">
        <thead>
            <tr>
            <div class="w-full mt-10 py-5 px-3 flex justify-end align-middle gap-3  bg-white shadow-md rounded-md">
                        <div class=" block justify-between min-w-fit gap-3 my-auto">
                                <label for="koldata">Sort By</label>
                                <select wire:model.live="koldata" name="koldata" id="koldata" class=" w-fit hover:cursor-pointer border-none">
                                    <option value="merchants.id">id</option>
                                    <option value="merchants.nm_merchant">Nama Merchant</option>
                                    <option value="merchants.device_id">Device ID</option>
                                    <option value="merchants.nopd">NOPD</option>
                                </select>
                            </div>

                            <div class=" block justify-between min-w-fit gap-3 my-auto">
                            <label for="jmldata">Ditampilkan :</label>
                            <select wire:model.live="jmldata" name="jmldata" id="jmldata" class=" w-12 hover:cursor-pointer border-none">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            </div>    
                            
                            <input class="border-b-2 border-r-2 rounded-md" type="text" id="keyword" placeholder="Cari Data" wire:model.live.debounce.500="keyword">
    

                        <div>
                            <button wire:click.prevent="tambahData" class="bg-[#1a73e8] w-fit px-4 py-2 text-white justify-self-end rounded-lg shadow-md">Tambah Data</button>
                            <button wire:click="modalImport()" class="bg-gray-700 w-fit px-4 py-2 text-white justify-self-end rounded-lg shadow-md">Import Data</button>
                            <button wire:click="exportData()" class="bg-[#43a047] w-fit px-4 py-2 text-white justify-self-end rounded-lg shadow-md">Export Data</button>
                        </div>

                    </div>
            </tr>
            <tr>
                <th class="border-b-2 px-4 py-2">ID</th>
                <th class="border-b-2 px-4 py-2">Nama Merchant</th>
                <th class="border-b-2 px-4 py-2">Device ID</th>
                <th class="border-b-2 px-4 py-2">NOPD</th>
                <th class="border-b-2 px-4 py-2">Alamat Merchant</th>
                <th class="border-b-2 px-4 py-2">Options</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datamerchants as $index => $merchant)
                        <tr>
                            <td class="border-b-2 px-4 py-2 text-center">{{ $merchant->id}}</td>
                            <td class="border-b-2 px-4 py-2 text-center">{{ $merchant->nm_merchant }}</td>
                            <td class="border-b-2 px-4 py-2 text-center">{{ $merchant->device_id}}</td>
                            <td class="border-b-2 px-4 py-2 text-center">{{ $merchant->nopd}}</td>
                            <td class="border-b-2 px-4 py-2 text-center">{{ $merchant->alm_merchant }}</td>
                            <td class="border-b-2 px-4 py-2 text-center">
                                <button wire:click="editData({{ $merchant->id }})" class="btn py-1 px-2 bg-[#ef5350] text-white rounded-md" >Edit</button>
                                <button wire:click="modalDelete('{{ $merchant->id }}', '{{ $merchant->nm_merchant }}')" class="btn py-1 px-2 bg-[#d81b60] text-white rounded-md">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border-none px-4 py-5 text-center">Belum ada data</td>
                        </tr>
                    @endforelse
        </tbody>
    </table>
     <!-- Paginasi -->
     <div class="mt-4">
    {{ $datamerchants->links() }}
    </div>
</div>
