@extends('layouts.front')

@section('content')
    <!--hero section-->
    <div class=" shadow-2x">
            <div class="hero-section pt-36 rounded-b-2xl shadow-lg grid md:flex lg:px-10 mb-52 bg-gradient-to-tr from-[#9a41d7] to-[#400060]">
                <div class="relative w-full md:my-40 px-10  lg:mt-10 md:self-end sm:w-full animate-bounce">
                  <img class="w-72 mx-auto" src="{{ asset('storage/image/isometrik.png') }}" alt="logorabbani-khitan" data-aos="fade-up" data-aos-anchor-placement="top-center">
                </div>    

                <div class="w-full mt-20 px-4 text-center">
                    <h1 class="uppercase font-bold text-4xl text-white">
                        <span class="text-">HALO MASYARAKAT TUBAN</span>
                    </h1>
                    <span class="text-white">KAMU BERKESEMPATAN UNTUK MEMENANGKAN 1 UNIT MOTOR DAN PULUHAN HADIAH ISTIMEWA LAINNYA</span>
                    <div class="mt-10 ">
                        <a href="/inputdata" class="rounded text-center p-2 bg-[#ce6113] text-white font-semibold hover:opacity-90 shadow-md">
                            DAFTAR SEKARANG
                        </a>
                    </div>
                </div>
                

                
            </div>
        </div>

    <!--hero section-->

@endsection
