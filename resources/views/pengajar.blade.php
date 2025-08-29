@extends('layouts.berandaly')

    <div class="container mx-auto py-10">
        <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Staf Pengajar</h1>
        <div class="flex flex-wrap justify-center gap-6">


            <div class="container mx-auto ">
                <h1 class="text-lg font-lg text-center mb-10 text-gray-600">Staf pengajar TPQ Nurul Iman siap
                    mendampingi anak Anda dalam meraih kecintaan terhadap Al-Qur'an dan tumbuh menjadi generasi Qur'ani.
                </h1>
                <div class="flex flex-wrap justify-center gap-8">




                @foreach ($gurus as $index => $guru)
                    <div
                        class="card flex bg-white shadow-sm rounded-lg overflow-hidden w-full md:w-5/12 transform transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-300 {{ $index === count($gurus) - 1 && count($gurus) % 2 !== 0 ? 'flex-row-reverse' : '' }}">
                        <div class="flex-1 p-6">
                            <h2 class="text-lg font-semibold text-gray-800">Ustadzah {{ $guru->nama }}</h2>
                            <p class="text-md text-gray-600 mt-2">{{ $guru->jabatan }} di TPQ Nurul Iman</p>
                            <p class="text-md text-gray-600">Mengajar {{ $guru->mata_pelajaran }}</p>
                            <p class="text-md text-gray-600">Pengalaman Mengajar {{ $guru->pengalaman }} Tahun</p>
                            <p class="text-md text-gray-600">Pendidikan {{ $guru->pendidikan_terakhir }}</p>
                        </div>
                        <div class="w-40 h-40 m-6">
                            <img class="w-full h-full object-cover rounded-full" src="{{ asset('gambar/' . $guru->gambar) }}"
                                alt="Foto {{ $guru->nama }}">
                        </div>
                    </div>
                @endforeach

                   
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