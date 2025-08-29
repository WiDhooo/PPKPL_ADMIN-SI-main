@extends('layouts.berandaly')

    <div class="w-11/12 md:w-3/4 mx-auto my-10">
        <a href="#">
            <img src="{{ asset('/img/bannerpendaftaran1.png') }}" alt="Banner Pendaftaran" class="w-full rounded-lg shadow-md">
        </a>

        <div class="mt-8 bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h1 class="text-2xl font-semibold text-center text-green-700 mb-4">Pembayaran Sukses</h1>
            <p class="text-center text-gray-700 text-sm mb-6">
                Apabila Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan ragu untuk menghubungi 
                kami melalui halaman kontak resmi.
            </p>

            <div class="text-center">
                <a href="{{ url('/') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                    Kembali ke Beranda
                </a>
                
            </div>
        </div>
        
    </div>



@extends('layouts.footerly')
