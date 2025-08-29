@extends('layouts.berandaly')

   <!-- Tentang Kami -->
<div class="px-4 sm:px-6 md:px-8 lg:px-24 xl:px-48 py-10">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Tentang Kami</h1>
        <p class="text-lg text-gray-600 text-justify leading-relaxed">
            TPQ Nurul Iman (Taman Pendidikan Al-Qur'an Nurul Iman) adalah lembaga pendidikan non-formal yang berfokus
            pada pendidikan Al-Qur'an dan nilai-nilai keislaman. Lembaga ini didirikan pada tahun 1990 di bawah naungan
            Yayasan Wakaf Nurul Iman Pondok Bambu, dengan tujuan utama untuk memberikan pendidikan agama Islam yang
            berkualitas kepada anak-anak sejak usia dini. Pada awal pendiriannya, TPQ ini beroperasi di lingkungan
            masjid dengan jumlah santri lebih dari 200 orang. Hal ini menunjukkan antusiasme masyarakat terhadap
            pendidikan agama, terutama karena pada saat itu masih sedikit TPQ yang tersedia di Jakarta.
        </p>
        <p class="text-lg text-gray-600 text-justify leading-relaxed mt-4">
            Seiring berjalannya waktu, TPQ Nurul Iman terus berkembang, baik dari segi jumlah santri, tenaga pendidik,
            maupun metode pembelajaran yang diterapkan. Saat ini, lembaga ini menawarkan program pendidikan yang
            mencakup berbagai aspek keislaman, di antaranya Aqidah Akhlak, Fiqih, serta Al-Qur'an Hadits. Dalam upaya
            memberikan pengalaman belajar yang efektif dan menyenangkan, TPQ Nurul Iman menggunakan metode Wafa dalam
            pembelajaran Al-Qur'an. Metode ini didesain dengan pendekatan otak kanan, yang memungkinkan anak-anak untuk
            belajar membaca dan menghafal Al-Qur’an dengan lebih cepat, menyenangkan, serta sesuai dengan perkembangan
            kognitif mereka.
        </p>
        <p class="text-lg text-gray-600 text-justify leading-relaxed mt-4">
            Selain fokus pada pembelajaran agama, TPQ Nurul Iman juga menanamkan nilai-nilai akhlakul karimah dan
            pembiasaan ibadah dalam kehidupan sehari-hari santri. Para santri didorong untuk menerapkan ilmu yang mereka
            pelajari dalam kehidupan nyata, seperti membiasakan diri membaca Al-Qur’an, melaksanakan shalat tepat waktu,
            serta berperilaku sopan terhadap sesama. Para ustadz dan ustadzah yang mengajar di TPQ ini adalah tenaga
            pendidik yang berpengalaman dan memiliki kompetensi dalam bidangnya, sehingga pembelajaran berlangsung
            dengan baik dan terarah.
        </p>
        <p class="text-lg text-gray-600 text-justify leading-relaxed mt-4">
            Dengan fasilitas yang terus dikembangkan, tenaga pendidik yang kompeten, serta metode pembelajaran yang
            inovatif, TPQ Nurul Iman berkomitmen untuk mencetak generasi Qur’ani yang tidak hanya cerdas secara
            akademik, tetapi juga memiliki akhlak mulia. Sebagai lembaga pendidikan yang telah berdiri lebih dari tiga
            dekade, TPQ Nurul Iman terus berusaha memberikan kontribusi terbaik dalam dunia pendidikan Islam, membimbing
            anak-anak agar tumbuh menjadi individu yang beriman, bertakwa, dan berkarakter islami yang kuat.
        </p>
    </div>
</div>


    <!-- Filosofi dan Misi Kami -->
    <div class="container mx-auto py-15 max-w-5xl px-6 mb-20">
        <div class="relative bg-gradient-to-r from-green-700 to-green-500 rounded-2xl shadow-sm p-10 border border-green-300
                transform transition-all duration-300 hover:scale-105 hover:shadow-md">

            <div class="relative z-10">
                <!-- Judul -->
                <h2 class="text-lg font-bold text-white text-center drop-shadow-lg">
                    TPQ Nurul Iman
                </h2>
                <h3 class="text-lg font-semibold text-white text-center mt-2 drop-shadow-lg">
                    Siap Mencetak Generasi Qur'ani, Cerdas, dan Berakhlakul Karimah
                </h3>

                <!-- Filosofi -->
                <p class="text-white mt-6 text-lg leading-relaxed text-justify">
                    Kami berkomitmen untuk memberikan pendidikan berbasis nilai-nilai Islam yang holistik, guna mencetak
                    generasi yang
                    beriman, berilmu, dan berakhlak mulia. Melalui metode pembelajaran yang menyeluruh, kami tidak hanya
                    menanamkan ilmu,
                    tetapi juga membentuk karakter islami yang kuat dalam setiap peserta didik.
                </p>

                <!-- Misi -->
                <div class="mt-6">
                    <p class="text-lg font-semibold text-white text-center mb-2">Misi Kami:</p>
                    <ul class="text-white text-lg leading-relaxed list-disc list-outside ">
                        <li>Membimbing anak-anak dalam membaca, menghafal, dan mengamalkan Al-Qur'an hingga khatam.</li>
                        <li>Menanamkan akhlak mulia dan nilai-nilai Islam dalam kehidupan sehari-hari.</li>
                        <li>Mengembangkan kecerdasan dan keterampilan agar menjadi pribadi yang mandiri dan berdaya.
                        </li>
                        <li>Menciptakan lingkungan belajar yang islami, nyaman, dan kondusif bagi tumbuh kembang anak.
                        </li>
                    </ul>
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