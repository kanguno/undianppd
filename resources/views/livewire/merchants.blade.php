<div class="p-10">
    <h1 class="font-bold text-2xl text-center">Data Merchant Pajak Daerah Tuban Tahun 2024</h1>

    <x-loading/>
    <div class="my-10 mx-auto md:w-full rounded-md shadow-md bg-white">
        <form wire:submit.prevent="inputData" class=" grid p-6 justify-arround">
            <h2 class="mb-10 text-lg font-semibold text-center">Tambah Data Merchant</h2>
            <div class="mb-4 grid md:flex md:gap-3 justify-center w-full">
                <!-- <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK</label> -->
                <input id="namamerchant" wire:model.defer="namamerchant" type="text" placeholder="Masukkan Nama Merchant"
                class="shadow w-full mb-3 bg-[#e5e7eb] text-md appearance-none border-none rounded p-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline">
                <!-- <label for="nik" class="block text-gray-700 text-sm font-bold mb-2">NIK</label> -->
                <input id="deviceid" wire:model.defer="deviceid" type="text" placeholder="Masukkan Device ID"
                class="shadow mb-3 bg-[#e5e7eb] text-md appearance-none border-none rounded p-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline">
                <input id="nopd" wire:model.defer="nopd" type="text" placeholder="Masukkan NOPD"
                class="shadow mb-3 bg-[#e5e7eb] text-md appearance-none border-none rounded p-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4 grid md:flex md:gap-3 justify-center w-full">
                <input id="almmerchant" wire:model.defer="almmerchant" type="text" placeholder="Masukkan Alamat Merchant"
                class="shadow mb-3 w-full bg-[#e5e7eb] text-md appearance-none border-none rounded p-4 text-neutral-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <button type="submit" class="justify-self-center bg-[#00bcd5] hover:bg-blue-700 text-white font-bold py-2 px-10 rounded-xl">
                Submit
            </button>
        </form>
    </div>

    <table class="my-10 mx-auto min-w-full rounded-md shadow-md bg-white">
        <thead>
            <tr>
                <td class="flex float-end gap-3 p-3 justify-end">
                    <button wire:click="exportData()" class="bg-blue-700 w-fit px-4 py-2 text-white justify-self-end mt-3 rounded-lg shadow-lg">Tambah Data</button>
                    <button wire:click="exportData()" class="bg-green-700 w-fit px-4 py-2 text-white justify-self-end mt-3 rounded-lg shadow-lg">Export Data</button>
                </td>
            </tr>
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Nama Merchant</th>
                <th class="border px-4 py-2">Device ID</th>
                <th class="border px-4 py-2">NOPD</th>
                <th class="border px-4 py-2">Alamat Merchant</th>
                <th class="border px-4 py-2">Options</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datamerchants as $index => $merchant)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $merchant->id}}</td>
                            <td class="border px-4 py-2 text-center">{{ $merchant->nm_merchant }}</td>
                            <td class="border px-4 py-2 text-center">merchant->device_id</td>
                            <td class="border px-4 py-2 text-center">merchant->nopd</td>
                            <td class="border px-4 py-2 text-center">{{ $merchant->alm_merchant }}</td>
                            <td class="border px-4 py-2 text-center">
                                <button wire:click="ValidasiData({{$merchant->id}})" class="btn py-1 px-2 bg-yellow-600 text-white rounded-md" >Edit</button>
                                <button wire:click="ValidasiData({{$merchant->id}})" class="btn py-1 px-2 bg-red-600 text-white rounded-md" >Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border px-4 py-2 text-center">No data available</td>
                        </tr>
                    @endforelse
        </tbody>
    </table>
     <!-- Paginasi -->
     <div class="mt-4">
    {{ $datamerchants->links() }}
    </div>
    {{-- The Master doesn't talk, he acts. --}}
</div>
