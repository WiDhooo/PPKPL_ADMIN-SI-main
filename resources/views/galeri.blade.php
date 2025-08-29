@extends('layouts.berandaly')

<div class="container mx-auto py-10">
    <h1 class="text-3xl font-bold text-center mb-4 text-gray-800">Dokumentasi Kegiatan</h1>
    <div class="container mx-auto">
        <h1 class="text-lg font-sm text-center mb-10 text-gray-600">
            Dokumentasi berbagai kegiatan dan program unggulan yang telah kami selenggarakan.
        </h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-items-center">
            @foreach ($galeris as $galeri)
            <div class="border border-gray-300 shadow-md rounded-lg overflow-hidden w-full min-h-2/3 flex flex-col transition-shadow hover:shadow-lg mb-4">
                <img src="{{ asset('gambar/' . $galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full h-2/3 object-cover" />
                <div class="p-4 flex flex-col flex-1">
                    <h2 class="text-xl font-semibold text-gray-800 text-center mt-3">{{ $galeri->judul }}</h2>
                    <p class="text-lg text-gray-600 mt-2 flex-grow text-center">{{ $galeri->deskripsi }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@if(session('error'))
    <div id="popup-error" class="popup-alert">
        {{ session('error') }}
    </div>
@endif

<style>
    .popup-alert {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #f44336; /* Merah untuk error */
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }
</style>

<script>
    setTimeout(() => {
        const popup = document.getElementById('popup-error');
        if (popup) {
            popup.style.opacity = '0';
            setTimeout(() => popup.remove(), 500);
        }
    }, 3000);
</script>

@extends('layouts.footerly')

