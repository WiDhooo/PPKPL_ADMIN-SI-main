@extends('layouts.app')

@section('content')
<div x-data="{ showTambah: false }" class="p-6 bg-[#F8F9FD] min-h-screen">

    <!-- Title and Search -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#2B3674]">{{ $kelas->kelas }}</h1>
        <form method="GET" action="{{ route('kelas.detail', ['id' => $kelas->id]) }}" class="relative w-64">
            <input type="text" name="search" id="searchSantri" placeholder="Cari Nama Santri..." class="w-full pl-10 pr-4 py-2 text-gray-500 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('search') }}">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-4.35-4.35M17 10a7 7 0 1 0-7 7 7 7 0 0 0 7-7z" />
            </svg>
        </form>
    </div>

    <!-- Total Santri Card -->
    <div class="bg-white p-6 rounded-xl flex items-center gap-4 shadow-md mb-6 max-w-xs">
        <div class="bg-emerald-100 p-4 rounded-full">
            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500">Total Santri</p>
            <h3 id="totalSantriCount" class="text-2xl font-bold">{{ $totalSantriInClass }}</h3>
        </div>
    </div>

    <form method="GET" action="{{ route('kelas.detail', ['id' => $kelas->id]) }}" class="flex justify-between mb-6">
        <!-- Filter & Sorting Controls -->
        <div class="bg-white p-2 rounded-xl flex items-center shadow gap-6 max-w-md">
            <select name="jenis_kelamin" id="filterJenisKelamin" class="border rounded-lg px-4 py-3 text-base" onchange="this.form.submit()">
                <option value="" {{ request('jenis_kelamin') == '' ? 'selected' : '' }}>Semua Jenis Kelamin</option>
                <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <select name="sort_by" id="sortBy" class="border rounded-lg px-4 py-3 text-base" onchange="this.form.submit()">
                <option value="terbaru" {{ request('sort_by') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort_by') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                <option value="nama_asc" {{ request('sort_by') == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                <option value="nama_desc" {{ request('sort_by') == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
            </select>
        </div>

        <!-- Add and Delete Buttons -->
        <div class="flex items-center gap-4">
            <form method="POST" action="{{ route('kelas.hapusSemuaSantri', ['kelasId' => $kelas->id]) }}" onsubmit="return confirm('Yakin ingin menghapus semua santri dari kelas ini?');">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 whitespace-nowrap">Hapus Semua</button>
            </form>
            <button type="button" @click="showTambah = true" class="bg-emerald-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-emerald-600 whitespace-nowrap">
                Tambah
            </button>
        </div>
    </form>

    <!-- Modal Add Santri -->
    <div x-show="showTambah" x-transition class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-sm px-4 overflow-auto">
        <div @click.away="showTambah = false" class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-8 animate-scaleIn overflow-y-auto max-h-[80vh] space-y-6">
            <h3 class="text-2xl font-semibold text-center mb-4">Tambah Santri ke Kelas</h3>
            <form method="POST" action="{{ route('kelas.tambahSantri', ['id' => $kelas->id]) }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto border p-4 rounded">
                    @forelse ($santriNullKelas as $santri)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="santri_ids[]" value="{{ $santri->id }}" class="form-checkbox">
                        <span>{{ $santri->nama_santri }} (NIK: {{ $santri->nik }})</span>
                    </label>
                    @empty
                    <p class="whitespace-nowrap">Tidak ada santri yang belum memiliki kelas.</p>
                    @endforelse
                </div>
                <div class="mt-4 flex justify-between">
                    @if($santriNullKelas->isNotEmpty())
                        <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600">Konfirmasi</button>
                    @endif
                    <button type="button" @click="showTambah = false" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Santri Table -->
    <div class="bg-white rounded-md overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left border-collapse" id="santriTable">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">No</th>
                    <th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">NIS</th>
                    <th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">Nama Santri</th>
                    <th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">Umur</th>
                    <th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">Jenis Kelamin</th>
                    <th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($santris as $index => $santri)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-center">{{ $santris->firstItem() + $index }}</td>
                    <td class="px-6 py-4 text-center">{{ $santri->nis }}</td>
                    <td class="px-6 py-4 text-center">{{ $santri->nama_santri }}</td>
                    <td class="px-6 py-4 text-center">{{ $santri->umur }}</td>
                    <td class="px-6 py-4 text-center">
                        @if(strtolower($santri->jenis_kelamin) == 'l')
                            Laki-laki
                        @elseif(strtolower($santri->jenis_kelamin) == 'p')
                            Perempuan
                        @else
                            {{ $santri->jenis_kelamin }}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form method="POST" action="{{ route('kelas.hapusSantri', ['kelasId' => $kelas->id, 'santriId' => $santri->id]) }}" onsubmit="return confirm('Yakin ingin menghapus santri ini dari kelas?');">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6 flex justify-center items-center space-x-2">
            <a href="{{ $santris->url(1) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100"><<</a>
            @if ($santris->onFirstPage())
                <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed"><</span>
            @else
                <a href="{{ $santris->previousPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100"><</a>
            @endif

            @php
                $lastPage = $santris->lastPage();
                $currentPage = $santris->currentPage();

                if ($lastPage <= 5) {
                    $pages = range(1, $lastPage);
                    $showFirst = false;
                    $showLast = false;
                } else {
                    if ($currentPage <= 3) {
                        $pages = range(1, 4);
                        $showFirst = false;
                        $showLast = true;
                    } elseif ($currentPage >= $lastPage - 2) {
                        $pages = range($lastPage - 3, $lastPage);
                        $showFirst = true;
                        $showLast = false;
                    } else {
                        $pages = range($currentPage - 1, $currentPage + 1);
                        $showFirst = true;
                        $showLast = true;
                    }
                }
            @endphp

            @if ($showFirst)
                <a href="{{ $santris->url(1) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">1</a>
                <span class="px-3 py-1">...</span>
            @endif

            @foreach ($pages as $page)
                @if ($page == $santris->currentPage())
                    <span class="px-3 py-1 rounded border border-blue-500 bg-blue-100 font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $santris->url($page) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
                @endif
            @endforeach

            @if ($showLast)
                <span class="px-3 py-1">...</span>
                <a href="{{ $santris->url($lastPage) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">{{ $lastPage }}</a>
            @endif

            @if ($santris->hasMorePages())
                <a href="{{ $santris->nextPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">></a>
            @else
                <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">></span>
            @endif
            <a href="{{ $santris->url($santris->lastPage()) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">>></a>
        </div>

</div>

<script>
    // Client-side filtering removed as server-side filtering is implemented
</script>
@endsection
