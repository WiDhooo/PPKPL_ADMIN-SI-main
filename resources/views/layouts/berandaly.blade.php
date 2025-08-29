<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TPA Nurul Iman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 520;
        }
    </style>
</head>

<body class="pt-24">
<nav class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-4 md:px-10 py-6">
        <!-- Logo -->
        <a href="{{ route('beranda') }}" class="flex items-center space-x-3 text-xl font-bold text-gray-700">
            <img src="{{ asset('img/logotpanurul.png') }}" alt="Logo TPQ" class="h-14 w-auto">
            <span class="text-xl sm:text-xl">TPQ Nurul Iman</span>
        </a>

        <!-- Menu Desktop -->
        <ul class="hidden md:flex space-x-8 text-lg lg:text-base">
            <li><a href="{{ route('beranda') }}" class="text-gray-600 hover:text-green-500 transition text-lg">Beranda</a></li>
            <li class="relative group">
                <button onclick="toggleDropdown('profilDropdown')" class="flex items-center text-gray-600 text-lg hover:text-green-500 transition">
                    Profil <i class="ph ph-caret-down ml-1"></i>
                </button>
                <ul id="profilDropdown" class="absolute hidden bg-white shadow-md mt-2 py-2 w-40 text-lg lg:text-base">
                    <li><a href="{{ route('tentang') }}" class="block px-4 py-2 text-gray-600 hover:bg-green-100 text-lg">Tentang</a></li>
                    <li><a href="{{ route('pengajar') }}" class="block px-4 py-2 text-gray-600 hover:bg-green-100 text-lg">Guru</a></li>
                    <li><a href="{{ route('program') }}" class="block px-4 py-2 text-gray-600 hover:bg-green-100 text-lg">Program</a></li>
                </ul>
            </li>
            <li><a href="{{ route('galeri') }}" class="text-gray-600 hover:text-green-500 transition text-lg">Galeri</a></li>
            <li class="relative group">
                <button onclick="toggleDropdown('layananDropdown')" class="flex items-center text-gray-600 hover:text-green-500 transition text-lg">
                    Layanan <i class="ph ph-caret-down ml-1"></i>
                </button>
                <ul id="layananDropdown" class="absolute hidden bg-white shadow-md mt-2 py-2 w-48 text-sm lg:text-base">
                    <li><a href="{{ route('informasi_pendaftaran') }}" class="block px-4 py-2 text-gray-600 hover:bg-green-100 text-lg">Informasi Pendaftaran</a></li>
                    <li><a href="{{ route('pendaftaran') }}" class="block px-4 py-2 text-gray-600 hover:bg-green-100 text-lg">Pendaftaran Online</a></li>
                </ul>
            </li>
            <li><a href="{{ route('kontak') }}" class="text-gray-600 hover:text-green-500 transition text-lg">Kontak</a></li>
        </ul>

        <!-- Profile (Desktop Only) -->
        <div class="hidden md:block">
            @if(auth()->check() && auth()->user()->role === 'user')
            <div class="relative group">
                <button onclick="toggleDropdown('userProfileDropdown')" class="flex items-center text-gray-600 hover:text-green-500 transition text-lg">
                    <i class="ph ph-user-circle text-xl mr-2"></i> {{ auth()->user()->name }}
                    <i class="ph ph-caret-down ml-1"></i>
                </button>
                <ul id="userProfileDropdown" class="absolute right-0 hidden bg-white shadow-md mt-2 py-2 w-48 text-gray-600 text-sm lg:text-base text-lg">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-green-100">Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
            @else
            <a href="{{ route('login') }}" class="text-gray-600 border border-gray-300 rounded-lg py-2 px-4 hover:border-green-500 hover:text-green-500 transition text-lg">
                <i class="ph ph-user-circle text-xl mr-2"></i> Masuk
            </a>
            @endif
        </div>

        <!-- Burger Menu Mobile -->
        <button id="menuToggle" class="md:hidden text-gray-600 focus:outline-none text-2xl">
            ☰
        </button>
    </div>

    <!-- Menu Mobile -->
    <div id="mobileMenu" class="hidden md:hidden bg-white shadow-md py-3 px-6">
        <a href="{{ route('beranda') }}" class="block text-gray-600 hover:text-green-500 transition py-2">Beranda</a>

        <button class="w-full flex justify-between text-gray-600 hover:text-green-500 transition py-2"
            onclick="toggleDropdown('profilDropdownMobile')">
            Profil <i class="ph ph-caret-down"></i>
        </button>
        <div id="profilDropdownMobile" class="hidden pl-4">
            <a href="{{ route('tentang') }}" class="block text-gray-600 hover:bg-green-100 py-1">Tentang</a>
            <a href="{{ route('pengajar') }}" class="block text-gray-600 hover:bg-green-100 py-1">Guru</a>
            <a href="{{ route('program') }}" class="block text-gray-600 hover:bg-green-100 py-1">Program</a>
        </div>

        <a href="{{ route('galeri') }}" class="block text-gray-600 hover:text-green-500 transition py-2">Galeri</a>

        <button class="w-full flex justify-between text-gray-600 hover:text-green-500 transition py-2"
            onclick="toggleDropdown('layananDropdownMobile')">
            Layanan <i class="ph ph-caret-down"></i>
        </button>
        <div id="layananDropdownMobile" class="hidden pl-4">
            <a href="{{ route('informasi_pendaftaran') }}" class="block text-gray-600 hover:bg-green-100 py-1">Informasi Pendaftaran</a>
            <a href="{{ route('pendaftaran') }}" class="block text-gray-600 hover:bg-green-100 py-1">Pendaftaran</a>
        </div>

        <a href="{{ route('kontak') }}" class="block text-gray-600 hover:text-green-500 transition py-2">Kontak</a>

        @if(auth()->check() && auth()->user()->role === 'user')
        <div class="relative group mt-2">
            <button onclick="toggleDropdown('userMobileDropdown')"
                class="w-full flex justify-between items-center text-gray-600 border border-gray-300 rounded-lg py-2 px-4 hover:border-green-500 hover:text-green-500 transition">
                <i class="ph ph-user-circle text-xl mr-2"></i> {{ auth()->user()->name }}
                <i class="ph ph-caret-down ml-2"></i>
            </button>
            <div id="userMobileDropdown" class="hidden mt-1 bg-white border border-gray-200 rounded-md shadow-md">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-100">Keluar</button>
                </form>
            </div>
        </div>
        @else
        <a href="{{ route('login') }}" class="block text-gray-600 border border-gray-300 rounded-lg text-center mt-2 py-2 hover:border-green-500 hover:text-green-500 transition">
            <i class="ph ph-user-circle text-lg mr-2"></i> Masuk
        </a>
        @endif
    </div>
</nav>

<script>
    document.getElementById('menuToggle').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });

    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle("hidden");
    }

    document.addEventListener("click", function (event) {
        const dropdowns = ["profilDropdown", "layananDropdown", "userProfileDropdown", "userMobileDropdown"];
        dropdowns.forEach(id => {
            const el = document.getElementById(id);
            if (el && !el.contains(event.target) && !event.target.closest('.group')) {
                el.classList.add("hidden");
            }
        });
    });
</script>
</body>

</html>