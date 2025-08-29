@extends('layouts.berandaly')

    <div class="container mx-auto py-10 px-6 mb-10">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Informasi Pendaftaran</h1>
        <p class="text-lg text-center mb-10 text-gray-600">Staf pengajar TPQ Nurul Iman siap mendampingi anak Anda dalam
            meraih kecintaan terhadap Al-Qur'an dan tumbuh menjadi generasi Qur'ani.</p>

        <div class="flex flex-wrap justify-center gap-8">
            <!-- Card Prosedur Pendaftaran -->
            <div class="flex flex-wrap gap-6 justify-center">
                <div class="flex flex-wrap gap-6 justify-center">
                    <!-- Card 1: Syarat Pendaftaran -->
                    <div
                        class="card bg-white shadow-lg rounded-lg overflow-hidden w-full md:w-5/12 transform transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-300 p-6">
                        <h2 class="text-xl font-bold text-center mb-6 text-gray-800">Syarat Pendaftaran</h2>
                        <ul class="list-disc list-inside text-lg text-gray-600 space-y-2">
                            <li>Mengisi Formulir Pendaftaran Santri</li>
                            <li>Mengupload Fotokopi kartu keluarga (KK).</li>
                            <li>Mengupload Fotokopi Akte Kelahiran </li>
                            <li>Mengisi Formulir Pendaftaran Wali Santri</li>
                            <li>Melakukan Pembayaran</li>
                
                        </ul>
                    </div>

                  <!-- Card 2: Prosedur Pendaftaran Ngaji -->
<div
    class="card bg-white shadow-lg rounded-lg overflow-hidden w-full md:w-5/12 transform transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-300 p-6">
    <h2 class="text-xl font-bold text-center mb-6 text-gray-800">Prosedur Pendaftaran Ngaji</h2>

    <div class="relative">
        <!-- Garis vertikal -->
        <div class="absolute left-3 top-0 h-full w-1 bg-green-500"></div>

        <!-- Langkah 1 -->
        <div class="relative flex items-start mb-6">
            <div
                class="absolute left-0 w-6 h-6 bg-green-500 text-white flex items-center justify-center text-xs font-bold rounded-full">
                1</div>
            <div class="ml-12">
                <h3 class="text-lg font-bold text-gray-600">Mengisi Formulir Pendaftaran Daring</h3>
                <p class="text-lg text-gray-600">Peserta mengisi data diri melalui formulir online yang disediakan.</p>
            </div>
        </div>

        <!-- Langkah 2 -->
        <div class="relative flex items-start mb-6">
            <div
                class="absolute left-0 w-6 h-6 bg-green-500 text-white flex items-center justify-center text-xs font-bold rounded-full">
                2</div>
            <div class="ml-12">
                <h3 class="text-lg font-bold text-gray-600">Menerima Bukti Pendaftaran di Email</h3>
                <p class="text-lg text-gray-600">Setelah mendaftar, peserta akan menerima email konfirmasi berupa file PDF.</p>
            </div>
        </div>

        <!-- Langkah 3 -->
        <div class="relative flex items-start">
            <div
                class="absolute left-0 w-6 h-6 bg-green-500 text-white flex items-center justify-center text-xs font-bold rounded-full">
                3</div>
            <div class="ml-12">
                <h3 class="text-lg font-bold text-gray-600">Menunggu Informasi Jadwal Masuk</h3>
                <p class="text-lg text-gray-600">Peserta akan dihubungi oleh pihak pengelola terkait jadwal mulai kegiatan ngaji.</p>
            </div>
        </div>
    </div>
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