@extends('layouts.berandaly')

<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-10 rounded-xl shadow-lg max-w-lg text-center animate-fadeIn">
        <h1 class="text-3xl font-extrabold mb-4 text-gray-800">Pembayaran Berhasil!</h1>
        <p class="text-gray-600 mb-6 text-lg">
            Terima kasih! Tim TPQ akan menghubungi Anda dalam 1x24 jam untuk informasi selanjutnya.
        </p>
        <a href="{{ route('beranda') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
            Kembali ke Beranda
        </a>
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
