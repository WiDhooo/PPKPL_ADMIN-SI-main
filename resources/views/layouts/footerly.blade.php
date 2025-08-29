 <!-- Footer -->
 <footer class="bg-gradient-to-br from-green-600 to-green-700 text-white py-6">
    <div class="container mx-auto px-6 lg:px-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tentang TPQ -->
            <div>
                <h2 class="text-xl font-bold mb-4">Tentang TPQ Nurul Iman</h2>
                <p class="text-lg">
                    TPQ Nurul Iman adalah lembaga pendidikan Al-Qur'an yang bertujuan mencetak
                    generasi muda
                    berakhlakul karimah
                    dengan pendekatan islami yang menyenangkan dan edukatif.
                </p>
            </div>
            <!-- Tautan Cepat -->
            <div>
                <h2 class="text-xl font-bold mb-4">Tautan Cepat</h2>
                <ul class="text-lg space-y-2">
                    <li><a href="{{ route('beranda') }}" class="hover:underline">Beranda</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:underline">Tentang Kami</a></li>
                    <li><a href="{{ route('program') }}" class="hover:underline">Program Belajar</a></li>
                    <li><a href="{{ route('pendaftaran') }}" class="hover:underline">Pendaftaran</a></li>
                    <li><a href="{{ route('kontak') }}" class="hover:underline">Kontak</a></li>
                </ul>
            </div>
           <!-- Kontak -->
<div>
    <h2 class="text-xl font-bold mb-4">Kontak Kami</h2>
    <ul class="text-lg space-y-2">
        <li><strong>Alamat:</strong> Jl. Pisangan Baru, Jakarta Timur</li>
        <li>
            <strong>Email:</strong>
            <a href="mailto:tpqnurulimanpis@gmail.com" class="hover:underline">
                tpqnurulimanpis@gmail.com
            </a>
        </li>
        <li><strong>Telepon:</strong> +62 877-1537-3102</li>
        <li><strong>Jam Operasional:</strong> Senin - Jum'at, 08.00 - 17.00 WIB</li>
    </ul>
</div>


        <!-- Divider -->
        <div class="border-t border-gray-400 mt-6"></div>

        <!-- Footer Bottom -->
        <div class="mt-4 text-center text-lg">
            <p>&copy; 2025 TPQ Nurul Iman. Semua Hak Dilindungi.</p>
        </div>
        <div class="border-t border-gray-400 mt-6"></div>
    </div>
</footer>



</body>

</html>