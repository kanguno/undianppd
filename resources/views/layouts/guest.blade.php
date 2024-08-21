<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div wire:loading class="flex items-center justify-center overlay z-50 h-screen w-screen bg-black bg-opacity-50 fixed top-0 left-0">
                <div class="absolute bg-light justify-content-center w-full h-full position-fixed opacity-100 left-0 top-0 text-center translate-middle z-10">
                    <span class="flex justify-center items-center h-full">
                        <img class=" max-w-48 h-auto animate-bounce duration-[100000]" src="{{ asset('storage/image/isometrikppdwb.png') }}" alt="">
                    </span>
                </div>
            </div>


        <div class="min-h-screen bg-gray-100">

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

        @if (session('notification'))
        @php
            $notification = session('notification');
        @endphp
        <div 
            x-data="{ 
                open: true, 
                notificationType: '{{ $notification['type'] }}' 
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
                } "
                class="relative bg-white text-center font-semibold rounded-2xl shadow-lg p-4 max-w-md mx-auto"
                role="alert"
                aria-live="assertive"
            >
                <button @click="open = false" class="absolute top-2 right-2 text-gray-900" aria-label="Tutup notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <p class="p-2 my-2 mx-5">{{ $notification['message'] }}</p>
            </div>
        </div>
    @endif
            <!-- Page Content -->
            <main class="container">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        
    </body>
    @livewireScripts
</html>
