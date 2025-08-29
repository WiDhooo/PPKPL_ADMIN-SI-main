@extends('layouts.app')

@section('content')
<div class="p-6 bg-[#F8F9FD] w-full">
    <!-- Header Section dengan notifikasi dan profil -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-[#2B3674]">Panduan</h1>

    <!-- Konten Panduan -->
    <div class="bg-white rounded-xl p-6 mt-6">
        <h2 class="text-2xl font-semibold mb-6">Cara menggunakan Aplikasi</h2>
        <div class="space-y-4" x-data="{ active: null }">

            <!-- FAQ Item 1 -->
            <div class="border rounded-lg">
                <button class="w-full px-4 py-3 flex justify-between items-center"
                        @click="active = active === 1 ? null : 1">
                    <span class="font-medium">Bagaimana cara mendaftarkan santri baru?</span>
                    <svg class="w-5 h-5 transform transition-transform"
                         :class="{ 'rotate-180': active === 1 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-4 py-3 border-t" x-show="active === 1" x-collapse>
                    <p class="text-gray-600">
                        1. Klik menu "Pendaftaran" di sidebar<br>
                        2. Pilih "Tambah Santri Baru"<br>
                        3. Isi formulir dengan data lengkap<br>
                        4. Upload dokumen yang diperlukan<br>
                        5. Klik "Simpan" untuk menyelesaikan pendaftaran
                    </p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="border rounded-lg">
                <button class="w-full px-4 py-3 flex justify-between items-center"
                        @click="active = active === 2 ? null : 2">
                    <span class="font-medium">Bagaimana cara melakukan pembayaran SPP?</span>
                    <svg class="w-5 h-5 transform transition-transform"
                         :class="{ 'rotate-180': active === 2 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-4 py-3 border-t" x-show="active === 2" x-collapse>
                    <p class="text-gray-600">
                     
                    </p>
                </div>
            </div>
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
// Add Alpine.js for FAQ accordion functionality
document.addEventListener('alpine:init', () => {
    Alpine.data('accordion', () => ({
        active: null
    }))
})
</script>
@endsection
