@extends('layouts.berandaly')

<section id="hero">
        <!-- Sumber: https://unsplash.com/ -->
        <div class="bg-cover bg-center h-screen relative" style="background-image: url('img/photo-01.png');">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-10">
                <h1 class="text-white text-2xl lg:text-5xl font-poppins font-bold mb-1"
                    style="text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.5);">
                    Selamat Datang di TPQ Nurul Iman
                </h1>
                <h1 class="text-white text-xl font-poppins mt-3 mb-6 drop-shadow-2xl"
                    style="text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.5);">
                    Membimbing Generasi Qur’ani, Berilmu dan Berakhlak Mulia
                </h1>
            </div>
        </div>
    </section>


    <div class="mt-20 px-4 sm:px-6 md:px-8 lg:px-48">
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Gambar -->
        <img class="w-full md:w-60 aspect-square rounded-md" src="img/ustendang.png" alt="">

        <!-- Teks Sambutan -->
        <div class="flex flex-col bg-green-600 p-8 rounded-lg shadow-md gap-4 w-full">
            <h1 class="text-2xl font-semibold text-white">Sambutan Kepala TPQ Nurul Iman</h1>
            <p class="text-white text-justify text-lg">
                Puji syukur kehadirat Allah SWT yang telah melimpahkan rahmat dan hidayah-Nya, sehingga kita semua masih diberi kesempatan untuk terus berkontribusi dalam mendidik generasi penerus bangsa. 
                Selamat datang di website resmi TPQ Nurul Iman. Website ini kami hadirkan sebagai media informasi, komunikasi, dan silaturahmi antara pihak TPQ, orang tua, dan masyarakat. TPQ Nurul Iman hadir sebagai lembaga pendidikan yang tidak hanya mengajarkan huruf-huruf hijaiyah dan bacaan Al-Qur’an, tetapi juga menanamkan nilai-nilai kebaikan, kejujuran, kepedulian, serta kecintaan terhadap ibadah dan akhlak Islami sejak usia dini. 
                Melalui website ini, kami berharap masyarakat dapat mengenal lebih dekat visi, misi, serta program-program unggulan yang kami jalankan di TPQ Nurul Iman.
            </p>
        </div>
    </div>
</div>



    <div class="container mx-auto mt-16 mb-20">
        <h1 class="text-3xl font-bold text-center mb-4 text-gray-800">Dokumentasi Kegiatan</h1>
        <div class="flex flex-wrap justify-center gap-6">


            <div class="container mx-auto ">
                <h1 class="text-lg text-center mb-10 text-gray-600">Dokumentasi berbagai kegiatan dan program
                    unggulan yang telah kami selenggarakan.</h1>
                <div class="flex flex-wrap justify-center gap-10">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                        <!-- Card 1 -->
                        <div class="border border-gray-300 shadow-md rounded-lg overflow-hidden w-full min-h-[360px] flex flex-col transition-shadow hover:shadow-lg">
                            <img src="img/foto2.png" alt="Gambar 1" class="w-full h-2/3 object-cover">
                            <div class="p-4 flex flex-col flex-1 gap-2">
                                <h2 class="text-xl font-semibold text-gray-800 text-center mt-3">Kegiatan Manasik Haji</h2>
                                <p class="text-lg text-gray-600 mt-2 flex-grow text-center">
                                    Dalam rangka mengisi kegiatan Ramadhan, anak-anak TPA Nurul Iman mengikuti Manasik Haji untuk mengenal lebih dekat makna perjalanan spiritual menuju Baitullah. 
                                </p>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="border border-gray-300 shadow-md rounded-lg overflow-hidden w-full min-h-[360px] flex flex-col transition-shadow hover:shadow-lg">
                            <img src="img/foto3.png" alt="Gambar 2" class="w-full h-2/3 object-cover">
                            <div class="p-4 flex flex-col flex-1 gap-2">
                                <h2 class="text-xl font-semibold text-gray-800 text-center mt-3">Kegiatan Manasik Haji</h2>
                                <p class="text-lg text-gray-600 mt-2 flex-grow text-center">
                                    Dalam rangka mengisi kegiatan Ramadhan, anak-anak TPA Nurul Iman mengikuti Manasik Haji untuk mengenal lebih dekat makna perjalanan spiritual menuju Baitullah. 
                                </p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="border border-gray-300 shadow-md rounded-lg overflow-hidden w-full min-h-[360px] flex flex-col transition-shadow hover:shadow-lg">
                            <img src="img/foto1.png" alt="Gambar 3" class="w-full h-2/3 object-cover">
                            <div class="p-4 flex flex-col flex-1 gap-2">
                                <h2 class="text-xl font-semibold text-gray-800 text-center mt-3">Kegiatan Manasik Haji</h2>
                                <p class="text-lg text-gray-600 mt-2 flex-grow text-center">
                                    Dalam rangka mengisi kegiatan Ramadhan, anak-anak TPA Nurul Iman mengikuti Manasik Haji untuk mengenal lebih dekat makna perjalanan spiritual menuju Baitullah. 
                                </p>
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