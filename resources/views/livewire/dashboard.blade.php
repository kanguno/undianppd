<div class="p-10">
    <h1 class="font-bold text-2xl text-center">Data Undian Pajak Daerah Tahun 2024</h1>

<x-loading/>

    <div class="grid md:flex w-8/12 mx-auto p-5 my-10 justify-between">
        <div wire:click="regDatas(0)" class="flex mb-5 p-3 rounded-md shadow-lg hover:cursor-pointer">
            <div class="icon rounded-md bg-blue-600 text-white p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg> 
            </div>
            <div class="grid">
                <p class="flex px-5 font-md text-center align-middle">
                    Semua Data
                </p>
                <p class="flex px-5 font-bold text-center align-middle">
                    {{$dataregs->semua}}
                </p>
            </div>
        </div>
        
        <div wire:click="regDatas(1)" class="flex mb-5 p-3 rounded-md shadow-lg hover:cursor-pointer">
            <div class="icon rounded-md bg-yellow-500 text-white p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <div class="grid">
                <p class="flex px-5 font-md text-center align-middle">
                    Permohonan
                </p>
                <p class="flex px-5 font-bold text-center align-middle">
                {{$dataregs->permohonan}}
                </p>
            </div>
        </div>

        <div wire:click="regDatas(3)" class="flex mb-5 p-3 rounded-md shadow-lg hover:cursor-pointer">
            <div class="icon rounded-md bg-green-700 text-white p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                </svg>
            </div>
            <div class="grid">
                <p class="flex px-5 font-md text-center align-middle">
                    Diterima
                </p>
                <p class="flex px-5 font-bold text-center align-middle">
                {{$dataregs->diterima}}
                </p>
            </div>
        </div>

        <div wire:click="regDatas(4)" class="flex mb-5 p-3 rounded-md shadow-lg hover:cursor-pointer">
            <div class="icon rounded-md bg-red-600 text-white p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="grid">
                <p class="flex px-5 font-md text-center align-middle">
                    Ditolak
                </p>
                <p class="flex px-5 font-bold text-center align-middle">
                {{$dataregs->ditolak}}
                </p>
            </div>
        </div>

    </div>
</div>
