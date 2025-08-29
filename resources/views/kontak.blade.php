@extends('layouts.berandaly')

<div class="container mx-auto py-10">
    <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Kontak</h1>
    <div class="flex flex-wrap justify-center gap-6">


        <div class="container mx-auto ">
            <h1 class="text-sm font-sm text-center mb-10 text-gray-600">Silahkan menghubungi kami untuk menyampaikan
                pertanyaan, komentar, saran maupun hal dan lainnya.</h1>
            <div class="flex flex-wrap justify-center">

                <div class="container mx-auto p-1/2">
                    <div class="flex flex-wrap gap-6 justify-center">
                        <!-- Card 1: Nomor Telepon -->
                        <div
                            class="card flex flex-col items-center justify-center bg-white shadow-sm rounded-lg overflow-hidden w-full md:w-5/12 transform transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-300 p-6">
                            <svg class="w-8" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path
                                    d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-800 mt-4 text-center">Nomor Telepon</h2>
                            <p class="text-sm text-gray-600 text-center mt-2">+62 877-1537-3102</p>
                        </div>

                        <!-- Card 2: Email -->
                        <div
                            class="card flex flex-col items-center justify-center bg-white shadow-sm rounded-lg overflow-hidden w-full md:w-5/12 transform transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-300 p-6">
                            <svg class="w-8" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path
                                    d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-800 mt-4 text-center">Email</h2>
                            <p class="text-sm text-gray-600 text-center mt-2"> tpqnurulimanpis@gmail.com</p>
                        </div>
                    </div>

                    <!-- Peta -->
                    <div class="flex px-4 sm:px-6 md:px-10 lg:px-28">
                        <div class="relative mt-12 rounded-lg overflow-hidden shadow-lg border border-gray-300 w-full">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-green-50 opacity-30 pointer-events-none"></div>
                            <iframe class="rounded-lg"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4132256137036!2d106.86518251047892!3d-6.209102160794348!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f561eb46ad57%3A0x560acf157d0d44b9!2sMushalla%20Nurul%20Iman%20-%20Pisangan%20Baru%20Utara!5e0!3m2!1sen!2sid!4v1746504996517!5m2!1sen!2sid"
                                width="100%" height="750" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                    <!-- <div class="flex px-4 sm:px-6 md:px-10 lg:px-28 mt-12">
                        <div class="relative w-full">
                            <textarea placeholder="Kirim masukan" class="bg-gray-100 p-2 w-full border border-gray-300 rounded-md h-60 resize-none text-lg"></textarea>
                            <button class="absolute bottom-2 right-2 bg-gradient-to-br from-green-600 to-green-700 text-white px-12 py-4 rounded-md text-lg">Kirim</button>
                        </div>

                    </div> -->
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