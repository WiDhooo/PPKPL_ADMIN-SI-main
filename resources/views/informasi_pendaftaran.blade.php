@extends('layouts.berandaly')

    <div class="container mx-auto py-10 mt-10 bg-red-100 border-l-4 border-red-600 text-red-700 p-6 mb-4">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v3m0 0v3m0-3h3m-3 0h-3M4 12a8 8 0 1116 0 8 8 0 01-16 0z" />
            </svg>
            <h2 class="text-lg font-semibold">Pendaftaran Belum Dibuka</h2>
        </div>
        <p class="mt-2 text-lg">Pendaftaran untuk calon santri TPQ Nurul Iman saat ini belum dibuka. Harap tunggu
            pengumuman lebih lanjut mengenai jadwal pembukaan pendaftaran.</p>
    </div>

    <div class="flex flex-wrap justify-center gap-6">
        <!-- Additional Content, if needed -->
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