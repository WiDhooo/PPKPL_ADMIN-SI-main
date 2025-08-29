@extends('layouts.berandaly')

<div class="w-3/4 mb-[100px] mx-auto drop-shadow">
    <a href="">
        <img src="{{ asset('img/bannerpendaftaran1.png') }}" alt="">
    </a>

    <div class="flex flex-col p-10 bg-white">
        <div class="text-2xl font-bold text-center mb-4 text-gray-800">Pendaftaran Santri Baru TPQ Nurul Iman</div>
        <div class="flex flex-wrap justify-center gap-6">
            <div class="container mx-auto">
                <h1 class="text-sm font-sm text-center mb-10 text-gray-600">Tingkatkan Iman dan Ilmu Anak Anda di TPQ Nurul Iman - Daftar Sekarang dan Tumbuhkan Generasi Cinta Al-Qur'an.</h1>
                <div class="flex flex-wrap justify-center gap-8">

                    <div class="flex flex-col items-center border-2 p-5">
                        <div class="text-2xl font-bold text-center mb-8 text-gray-800">Formulir Pendaftaran Online</div>
                        <form action="{{ route('pendaftaran.post') }}" method="POST" class="flex flex-col items-center" enctype="multipart/form-data">
                            @csrf

                            <!-- DATA SANTRI -->
                            <div class="w-full mb-7">
                                <label class="block text-sm font-medium mb-4">A. DATA SANTRI</label>
                                <input type="text" name="nama_santri" placeholder="Nama Calon Santri" class="w-full px-4 bg-gray-100 text-sm py-3 shadow" required>
                            </div>
                            <div class="w-full mb-7">
                                <input type="text" name="nik" placeholder="NIK" class="w-full px-4 bg-gray-100 text-sm py-3 shadow" required maxlength="16" pattern="\d{16}" title="NIK harus 16 digit angka">
                            </div>

                            <div class="w-full mb-7 text-sm font-sm">
                                <div class="block text-gray-600 font-medium mb-2">Jenis Kelamin</div>
                                <input type="radio" name="jenis_kelamin" id="jk1" value="L" required>
                                <label for="jk1">Laki-laki</label>
                                <input type="radio" name="jenis_kelamin" id="jk2" value="P" required>
                                <label for="jk2">Perempuan</label>
                            </div>

                            <div class="w-full mb-7">
                                <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" class="w-full px-4 bg-gray-100 text-sm py-3 shadow" required>
                            </div>

                            <div class="w-full mb-7">
                                <label for="tanggal_lahir" class="block text-gray-600 font-medium mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full px-4 bg-gray-100 text-sm py-3 shadow" required>
                            </div>

                            <div class="w-full mb-7">
                                <label for="akta_kelahiran" class="block text-gray-600 font-medium mb-2">Upload Akta Kelahiran:</label>
                                <input type="file" id="akta_kelahiran" name="akta_kelahiran" accept="application/pdf" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-green-500">
                            </div>

                            <div class="w-full mb-7">
                                <label for="kartu_keluarga" class="block text-gray-600 font-medium mb-2">Upload Kartu Keluarga:</label>
                                <input type="file" id="kartu_keluarga" name="kartu_keluarga" accept="application/pdf" required class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-green-500">
                            </div>

                            <!-- DATA ORANG TUA -->
                            <div class="w-full mb-7">
                                <label class="block text-sm font-medium mt-10 mb-4">B. DATA ORANG TUA</label>
                                <input type="text" name="nama_orang_tua" placeholder="Nama Orang Tua" class="w-full px-4 bg-gray-100 text-sm py-3 shadow" required>
                            </div>

                            <div class="w-full mb-7">
                                <input type="text" name="no_hp" placeholder="No Handphone Orang Tua" class="w-full px-4 bg-gray-100 text-sm py-3 shadow" required>
                            </div>

                            <div class="w-full mb-7">
                                <textarea name="alamat" placeholder="Alamat" class="w-full px-4 bg-gray-100 text-sm py-3 shadow" required></textarea>
                            </div>

                            <div class="mb-3 text-sm font-sm text-center">
                                <p>Terima kasih telah mengisi formulir! Setelah ini, selesaikan pendaftaran melalui halaman pembayaran yang aman dan mudah.</p>
                            </div>

                            <div class="w-full">
                                <button type="submit" class="bg-gradient-to-r from-green-700 to-green-500 text-white text-sm font-medium px-4 py-3 w-full rounded-lg mt-10 shadow-md">
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>
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

@if($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
    .popup-alert {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #f44336;
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

    window.addEventListener('DOMContentLoaded', () => {
        const tanggalInput = document.getElementById('tanggal_lahir');
        const today = new Date();

        const maxAge = 5;
        const minAge = 12;

        const maxDate = new Date(today.getFullYear() - maxAge, today.getMonth(), today.getDate());
        const minDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());

        const formatDate = (date) => {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        };

        tanggalInput.min = formatDate(minDate);
        tanggalInput.max = formatDate(maxDate);
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        const akta = document.querySelector('input[name="akta_kelahiran"]').files[0];
        const kk = document.querySelector('input[name="kartu_keluarga"]').files[0];

        const isPdf = (file) => file && file.type === 'application/pdf';

        if (!isPdf(akta) || !isPdf(kk)) {
            e.preventDefault();
            alert("Akta Kelahiran dan Kartu Keluarga harus berupa file PDF.");
        }
    });
</script>

@extends('layouts.footerly')
