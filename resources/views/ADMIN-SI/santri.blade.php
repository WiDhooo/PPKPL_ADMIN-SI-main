@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div x-data="santriApp()" x-init="init()" class="p-6 bg-[#F8F9FD] min-h-screen">

    <!-- Title and Search -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#2B3674]">Santri</h1>
        <form method="GET" action="{{ url('/admin/santri') }}" class="relative w-64">
            <input type="text" name="search" id="searchNama" placeholder="Cari Nama Santri..." class="w-full pl-10 pr-4 py-2 text-gray-500 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('search') }}" onkeydown="if(event.key === 'Enter'){ this.form.submit(); }" />
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
            <h3 id="totalSantriCount" class="text-2xl font-bold">{{ $totalSantriAll }}</h3>
        </div>
    </div>

    <!-- Filter & Sorting Controls and Tambah Santri Button -->
    <form method="GET" action="{{ url('/admin/santri') }}" class="flex justify-between mb-6">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <div class="bg-white p-2 rounded-xl flex items-center shadow gap-6 max-w-md">
            <select name="jenis_kelamin" id="filterJenisKelamin" class="border rounded-lg px-3 py-2 text-base" onchange="this.form.submit()">
                <option value="" {{ request('jenis_kelamin') == '' ? 'selected' : '' }}>Semua Jenis Kelamin</option>
                <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <select name="sort_by" id="sortBy" class="border rounded-lg px-3 py-2 text-base" onchange="this.form.submit()">
                <option value="terbaru" {{ request('sort_by') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort_by') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                <option value="nama_asc" {{ request('sort_by') == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                <option value="nama_desc" {{ request('sort_by') == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
            </select>
        </div>

        {{-- <button type="button" @click="showTambah = true" class="bg-emerald-500 text-white px-4 py-3 text-lg rounded-lg shadow-md hover:bg-emerald-600 whitespace-nowrap">
            Tambah Santri Baru
        </button> --}}

        <button type="button" @click="showTambah = true" class="bg-emerald-500 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:bg-emerald-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Santri Baru
        </button>
    </form>
 

    <!-- Tabel Santri -->
    <div class="mt-4 w-full">
    <div class="w-full px-4">
    <div class="bg-white rounded-md overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left border-collapse" id="santriTable">
            <thead class="bg-gray-200">
                <tr>
<th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">No</th>
<th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">NIK</th>
<th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">Nama Santri</th>
<th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">Usia</th>
<th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">Jenis Kelamin</th>
<th class="px-6 py-3 text-center text-gray-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($santris as $index => $santri)
                <tr class="border-b hover:bg-gray-50" data-index="{{ $index }}" data-tanggal="{{ $santri->tanggal_lahir }}">
                    <td class="px-6 py-3 text-center whitespace-nowrap">{{ $santris->firstItem() + $index }}</td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">{{ $santri->nik ?? ($santri->pendaftaran ? $santri->pendaftaran->nik : '') }}</td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">{{ $santri->nama_santri }}</td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">
                        @php
                            $birthDate = \Carbon\Carbon::parse($santri->tanggal_lahir);
                            $age = $birthDate->age;
                        @endphp
                        {{ $age }} tahun
                    </td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">
                        {{ $santri->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}
                    </td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">
                        <div class="flex flex-col md:flex-row gap-2 justify-center">
                            <button type="button" onclick="showDetail({{ $index }})" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Detail</button>
                            <button type="button" onclick="showEdit({{ $index }})" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">Edit</button>
                            <button type="button" onclick="deleteSantri({{ $santri->id }})" class="bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>

    <!-- Modal Tambah -->
    <div x-show="showTambah" x-transition class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-sm px-4 overflow-auto">
        <div @click.away="showTambah = false" class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-8 animate-scaleIn overflow-y-auto max-h-[80vh] space-y-6">
            <h3 class="text-2xl font-semibold text-center mb-4">Form Tambah Santri Baru</h3>
            <form id="tambahSiswaForm" class="space-y-4" enctype="multipart/form-data" @submit.prevent="saveTambahSiswa">
                <div>
                    <label class="block font-medium mb-1">Nama Santri:</label>
                    <input type="text" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="tambahNama" name="nama_santri" placeholder="Nama Santri" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">NIK:</label>
                    <input type="text" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="tambahNik" name="nik" placeholder="Masukkan NIK" required maxlength="16" pattern="\d{16}" title="NIK harus 16 digit angka">
                </div>
                <div>
                    <label class="block font-medium mb-1">Jenis Kelamin:</label>
                    <div class="flex gap-4">
                        <label><input type="radio" name="jenis_kelamin" value="L" required> Laki-laki</label>
                        <label><input type="radio" name="jenis_kelamin" value="P" required> Perempuan</label>
                    </div>
                </div>
                <div>
                    <label class="block font-medium mb-1">Tempat Lahir:</label>
                    <input type="text" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="tambahTempatLahir" name="tempat_lahir" placeholder="Tempat Lahir" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Lahir:</label>
                    <input type="date" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="tambahTanggalLahir" name="tanggal_lahir" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Upload Akta Kelahiran (PDF):</label>
                    <input type="file" class="w-full border rounded-md focus:ring focus:ring-emerald-300" id="tambahAktaKelahiran" name="akta_kelahiran" accept="application/pdf" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Upload Kartu Keluarga (PDF):</label>
                    <input type="file" class="w-full border rounded-md focus:ring focus:ring-emerald-300" id="tambahKartuKeluarga" name="kartu_keluarga" accept="application/pdf" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Nama Orang Tua:</label>
                    <input type="text" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="tambahNamaOrangTua" name="nama_orang_tua" placeholder="Nama Orang Tua" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">No HP:</label>
                    <input type="text" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="tambahNoHp" name="no_hp" placeholder="No Handphone" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Alamat:</label>
                    <textarea class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="tambahAlamat" name="alamat" placeholder="Alamat" required></textarea>
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-emerald-500 text-white rounded-md hover:bg-emerald-600">Simpan</button>
            </form>
            <button class="w-full py-2 bg-red-500 text-white rounded-md hover:bg-red-600" @click="showTambah = false">Tutup</button>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-sm px-4 overflow-auto" onclick="window.closeEdit()">
        <div onclick="event.stopPropagation()" class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-8 animate-scaleIn overflow-y-auto max-h-[80vh] space-y-6">
            <h3 class="text-2xl font-semibold text-center mb-4">Form Edit Santri</h3>
                <form id="editSiswaForm" class="space-y-4" enctype="multipart/form-data" onsubmit="event.preventDefault(); window.submitEditSiswa(event);">
                <input type="hidden" id="editId" name="id">
                <div>
                    <label class="block font-medium mb-1">Nama Santri:</label>
                    <input type="text" name="nama_santri" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="editNama" placeholder="Nama Santri" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">NIK:</label>
                    <input type="text" name="nik" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="editNik" placeholder="Masukkan NIK" required maxlength="16" pattern="\d{16}" title="NIK harus 16 digit angka">
                </div>
                <div>
                    <label class="block font-medium mb-1">Jenis Kelamin:</label>
                    <div class="flex gap-4">
                        <label><input type="radio" name="jenis_kelamin" value="L" required> Laki-laki</label>
                        <label><input type="radio" name="jenis_kelamin" value="P" required> Perempuan</label>
                    </div>
                </div>
                <div>
                    <label class="block font-medium mb-1">Tempat Lahir:</label>
                    <input type="text" name="tempat_lahir" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="editTempatLahir" placeholder="Tempat Lahir" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="editTanggalLahir" required>
                </div>
                <div class="mb-8">
                    <label class="block font-medium mb-1">Upload Akta Kelahiran (PDF):</label>
                    <input type="file" name="akta_kelahiran" class="w-full border rounded-md focus:ring focus:ring-emerald-300 mb-4" id="editAktaKelahiran" accept="application/pdf">
                    <label class="block font-medium mb-1">Akta Kelahiran Saat Ini</label>
                    <div id="currentEditAktaKelahiran" class="w-full border rounded bg-gray-100 p-4 text-gray-800 h-60 overflow-auto">
                        <iframe id="iframeEditAktaKelahiran" class="w-full h-full" frameborder="0"></iframe>
                        <a id="linkEditAktaKelahiran" href="#" target="_blank" class="text-blue-600 underline mt-2 block">Lihat Akta Kelahiran</a>
                    </div>
                </div>
                <div class="mb-8">
                    <label class="block font-medium mb-1">Upload Kartu Keluarga (PDF):</label>
                    <input type="file" name="kartu_keluarga" class="w-full border rounded-md focus:ring focus:ring-emerald-300 mb-4" id="editKartuKeluarga" accept="application/pdf">
                    <label class="block font-medium mb-1">Kartu Keluarga Saat Ini</label>
                    <div id="currentEditKartuKeluarga" class="w-full border rounded bg-gray-100 p-4 text-gray-800 h-60 overflow-auto">
                        <a id="linkEditKartuKeluarga" href="#" target="_blank" class="text-blue-600 underline mt-2 block">Lihat Kartu Keluarga</a>
                    </div>
                </div>
                <div>
                    <label class="block font-medium mb-1">Nama Orang Tua:</label>
                    <input type="text" name="nama_orang_tua" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="editNamaOrangTua" placeholder="Nama Orang Tua" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">No HP:</label>
                    <input type="text" name="no_hp" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="editNoHp" placeholder="No Handphone" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Alamat:</label>
                    <textarea name="alamat" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300" id="editAlamat" placeholder="Alamat" required></textarea>
                </div>
                <button type="submit" class="w-full py-2 px-4 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Simpan Perubahan</button>
            </form>
            <button class="w-full py-2 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="window.closeEdit()">Tutup</button>
        </div>
    </div>

    

    <!-- Pagination Links -->
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

<!-- Modal Detail Santri -->
<div id="modalDetail" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 px-4">
  <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-8 animate-scaleIn overflow-y-auto max-h-[80vh] space-y-6">
    <h2 class="text-2xl font-bold text-center text-emerald-600 mb-4">Detail Santri</h2>
    <div>
<label class="block font-medium text-gray-700 mb-1">NIK</label>
<div id="detailNik" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">Nama Santri</label>
      <div id="detailNama" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">Jenis Kelamin</label>
      <div id="detailJenisKelamin" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">Usia</label>
      <div id="detailUsia" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">Nama Orang Tua</label>
      <div id="detailNamaOrangTua" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">Tempat Lahir</label>
      <div id="detailTempatLahir" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">Tanggal Lahir</label>
      <div id="detailTanggalLahir" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">No HP</label>
      <div id="detailNoHp" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">Alamat</label>
      <div id="detailAlamat" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium mb-1">Akta Kelahiran</label>
      <div id="aktaPreviewContainer" class="w-full border rounded bg-gray-100 p-2 text-gray-800 flex flex-col" style="height: 60vh;">
        <iframe id="detailAktaKelahiran" class="w-full flex-grow" style="display: none;" frameborder="0"></iframe>
        <a id="aktaLink" href="#" target="_blank" class="text-blue-600 underline mt-2">Lihat Akta Kelahiran</a>
      </div>
    </div>
    <div>
      <label class="block font-medium mb-1">Kartu Keluarga</label>
      <div id="kkPreviewContainer" class="w-full border rounded bg-gray-100 p-2 text-gray-800 flex flex-col" style="height: 60vh;">
        <iframe id="detailKartuKeluarga" class="w-full flex-grow" style="display: none;" frameborder="0"></iframe>
        <a id="kkLink" href="#" target="_blank" class="text-blue-600 underline mt-2">Lihat Kartu Keluarga</a>
      </div>
    </div>
    <button onclick="closeDetail()" class="mt-6 w-full py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg">Tutup</button>
  </div>
</div>

<script>
    function santriApp() {
        return {
            showTambah: false,
            showEdit: false,
            init() {
                console.log('Alpine.js initialized with showEdit:', this.showEdit);
            },
        }
    }

    let santris = {!! json_encode($santris) !!};

    function showDetail(index) {
        const item = santris.data[index];
        document.getElementById('detailNik').textContent = item.nik ?? (item.pendaftaran ? item.pendaftaran.nik : '');
        document.getElementById('detailNama').textContent = item.nama_santri;
        document.getElementById('detailJenisKelamin').textContent = item.jenis_kelamin === 'L' ? 'Laki-laki' : (item.jenis_kelamin === 'P' ? 'Perempuan' : item.jenis_kelamin);
        document.getElementById('detailUsia').textContent = Math.floor((new Date() - new Date(item.tanggal_lahir)) / (365.25 * 24 * 60 * 60 * 1000)) + ' tahun';
        document.getElementById('detailNamaOrangTua').textContent = item.nama_orang_tua;
        document.getElementById('detailTempatLahir').textContent = item.tempat_lahir || '';
        document.getElementById('detailTanggalLahir').textContent = item.tanggal_lahir;
        document.getElementById('detailNoHp').textContent = item.no_hp || '';
        document.getElementById('detailAlamat').textContent = item.alamat || '';

        // Akta Kelahiran
        const aktaIframe = document.getElementById('detailAktaKelahiran');
        const aktaContainer = document.getElementById('aktaPreviewContainer');
        aktaContainer.innerHTML = '';
        if (item.akta_kelahiran) {
          let aktaUrl = '/gambar/akta_kelahiran/' + item.akta_kelahiran;
          if (aktaIframe) {
            aktaIframe.style.display = 'block';
          }
          const aktaEmbed = document.createElement('embed');
          aktaEmbed.src = aktaUrl;
          aktaEmbed.type = 'application/pdf';
          aktaEmbed.style.width = '100%';
          aktaEmbed.style.height = '60vh';
          aktaContainer.appendChild(aktaEmbed);
          const aktaLinkElement = document.createElement('a');
          aktaLinkElement.href = aktaUrl;
          aktaLinkElement.textContent = 'Lihat Akta Kelahiran';
          aktaLinkElement.target = '_blank';
          aktaLinkElement.className = 'text-blue-600 underline mt-2 block';
          aktaContainer.appendChild(aktaLinkElement);
        } else {
          if (aktaIframe) {
            aktaIframe.src = '';
            aktaIframe.style.display = 'none';
          }
        }

        // Kartu Keluarga
        const kkIframe = document.getElementById('detailKartuKeluarga');
        const kkContainer = document.getElementById('kkPreviewContainer');
        kkContainer.innerHTML = '';
        if (item.kartu_keluarga) {
          let kkUrl = '/gambar/kartu_keluarga/' + item.kartu_keluarga;
          if (kkIframe) {
            kkIframe.style.display = 'block';
          }
          const kkEmbed = document.createElement('embed');
          kkEmbed.src = kkUrl;
          kkEmbed.type = 'application/pdf';
          kkEmbed.style.width = '100%';
          kkEmbed.style.height = '60vh';
          kkContainer.appendChild(kkEmbed);
          const kkLinkElement = document.createElement('a');
          kkLinkElement.href = kkUrl;
          kkLinkElement.textContent = 'Lihat Kartu Keluarga';
          kkLinkElement.target = '_blank';
          kkLinkElement.className = 'text-blue-600 underline mt-2 block';
          kkContainer.appendChild(kkLinkElement);
        } else {
          if (kkIframe) {
            kkIframe.src = '';
            kkIframe.style.display = 'none';
          }
        }

        document.getElementById('modalDetail').classList.remove('hidden');
    }

    window.showEdit = function(index) {
        const item = santris.data[index];
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.classList.remove('hidden');
            const modalContent = editModal.querySelector('div');
            if (modalContent) {
                modalContent.scrollTop = 0;
            }
        }
        document.getElementById('editId').value = item.id;
        document.getElementById('editNama').value = item.nama_santri;
        document.getElementById('editNik').value = item.nik ?? (item.pendaftaran ? item.pendaftaran.nik : '');
        const editForm = document.getElementById('editSiswaForm');
        if (item.jenis_kelamin === 'P') {
            setTimeout(() => {
                const radioP = editForm.querySelector('input[name="jenis_kelamin"][value="P"]');
                if (radioP) {
                    radioP.checked = true;
                    console.log('Radio P checked:', radioP.checked);
                }
            }, 100);
        } else if (item.jenis_kelamin === 'L') {
            setTimeout(() => {
                const radioL = editForm.querySelector('input[name="jenis_kelamin"][value="L"]');
                if (radioL) {
                    radioL.checked = true;
                    console.log('Radio L checked:', radioL.checked);
                }
            }, 100);
        }
        document.getElementById('editTempatLahir').value = item.tempat_lahir || '';
        document.getElementById('editTanggalLahir').value = item.tanggal_lahir;


        // Clear and recreate Akta Kelahiran preview container
        const aktaContainer = document.getElementById('currentEditAktaKelahiran');
        aktaContainer.innerHTML = '';
        if (item.akta_kelahiran) {
            const aktaUrl = '/gambar/akta_kelahiran/' + item.akta_kelahiran;
            const aktaEmbed = document.createElement('embed');
            aktaEmbed.src = aktaUrl;
            aktaEmbed.type = 'application/pdf';
            aktaEmbed.style.width = '100%';
            aktaEmbed.style.height = '60vh';
            aktaContainer.appendChild(aktaEmbed);
            const aktaLinkElement = document.createElement('a');
            aktaLinkElement.href = aktaUrl;
            aktaLinkElement.textContent = 'Lihat Akta Kelahiran';
            aktaLinkElement.target = '_blank';
            aktaLinkElement.className = 'text-blue-600 underline mt-2 block';
            aktaContainer.appendChild(aktaLinkElement);
        }

        // Clear and recreate Kartu Keluarga preview container
        const kkContainer = document.getElementById('currentEditKartuKeluarga');
        kkContainer.innerHTML = '';
        if (item.kartu_keluarga) {
            const kkUrl = '/gambar/kartu_keluarga/' + item.kartu_keluarga;
            const kkEmbed = document.createElement('embed');
            kkEmbed.src = kkUrl;
            kkEmbed.type = 'application/pdf';
            kkEmbed.style.width = '100%';
            kkEmbed.style.height = '60vh';
            kkContainer.appendChild(kkEmbed);
            const kkLinkElement = document.createElement('a');
            kkLinkElement.href = kkUrl;
            kkLinkElement.textContent = 'Lihat Kartu Keluarga';
            kkLinkElement.target = '_blank';
            kkLinkElement.className = 'text-blue-600 underline mt-2 block';
            kkContainer.appendChild(kkLinkElement);
        }

        document.getElementById('editNamaOrangTua').value = item.nama_orang_tua;
        document.getElementById('editNoHp').value = item.no_hp || '';
        document.getElementById('editAlamat').value = item.alamat || '';

        window.dispatchEvent(new CustomEvent('open-edit-modal'));
    };

    window.closeEdit = function() {
        console.log('closeEdit called');
        const editModal = document.getElementById('editModal');
        if (editModal) {
            const modalContent = editModal.querySelector('div');
            if (modalContent) {
                modalContent.scrollTop = 0;
            }
            editModal.classList.add('hidden');
            console.log('closeEdit: hidden class added to editModal');
        }
    };

    window.submitEditSiswa = async function(event) {
        event.preventDefault();
        const id = document.getElementById('editId').value;
        const formData = new FormData(document.getElementById('editSiswaForm'));

        // Remove empty file inputs to avoid validation errors
        const aktaFile = document.getElementById('editAktaKelahiran').files[0];
        if (!aktaFile) {
            formData.delete('akta_kelahiran');
        }
        const kartuFile = document.getElementById('editKartuKeluarga').files[0];
        if (!kartuFile) {
            formData.delete('kartu_keluarga');
        }

        // Explicitly append required fields to ensure they are included
        formData.set('nama_santri', document.getElementById('editNama').value);
        const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]:checked');
        if (jenisKelamin) {
            console.log('Selected jenis_kelamin:', jenisKelamin.value);
            if (jenisKelamin.value === 'P') {
                formData.set('jenis_kelamin', 'P');
            } else if (jenisKelamin.value === 'L') {
                formData.set('jenis_kelamin', 'L');
            } else {
                formData.set('jenis_kelamin', jenisKelamin.value);
            }
        }
        formData.set('tempat_lahir', document.getElementById('editTempatLahir').value);
        formData.set('tanggal_lahir', document.getElementById('editTanggalLahir').value);
        formData.set('nama_orang_tua', document.getElementById('editNamaOrangTua').value);
        formData.set('no_hp', document.getElementById('editNoHp').value);
        formData.set('alamat', document.getElementById('editAlamat').value);

        // Debug: log formData entries
        for (let pair of formData.entries()) {
            console.log(pair[0]+ ': ' + pair[1]);
        }

        try {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            formData.set('_method', 'PUT'); // Add _method field to spoof PUT

            const response = await fetch(`/admin/santri/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    //'Accept': 'application/json' // Removed Accept header to avoid issues with multipart/form-data
                },
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json();
                if (errorData.errors) {
                    let errorMessages = '';
                    for (const key in errorData.errors) {
                        if (errorData.errors.hasOwnProperty(key)) {
                            errorMessages += errorData.errors[key].join(', ') + '\\n';
                        }
                    }
                    alert('Validation Errors:\\n' + errorMessages);
                } else {
                    alert('Error: ' + (errorData.message || 'Failed to update santri'));
                }
                return;
            }

            const result = await response.json();
            alert(result.message || 'Santri berhasil diperbarui');

            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.classList.add('hidden');
            }

            location.reload();

        } catch (error) {
            alert('Error: ' + error.message);
        }
    };

    async function saveTambahSiswa() {
        const form = document.getElementById('tambahSiswaForm');
        const formData = new FormData(form);

        // Debug: log formData entries
        for (let pair of formData.entries()) {
            console.log(pair[0]+ ': ' + pair[1]);
        }

        try {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            const response = await fetch('/admin/santri', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json();
                if (errorData.errors) {
                    let errorMessages = '';
                    for (const key in errorData.errors) {
                        if (errorData.errors.hasOwnProperty(key)) {
                            errorMessages += errorData.errors[key].join(', ') + '\\n';
                        }
                    }
                    alert('Validation Errors:\\n' + errorMessages);
                } else {
                    alert('Error: ' + (errorData.message || 'Failed to add santri'));
                }
                return;
            }

            const result = await response.json();
            alert(result.message || 'Santri berhasil ditambahkan');

            const alpineComponent = document.querySelector('div[x-data]');
            if (alpineComponent && alpineComponent.__x) {
                alpineComponent.__x.$data.showTambah = false;
            }

            form.reset();

            location.reload();

        } catch (error) {
            alert('Error: ' + error.message);
        }
    }

    async function deleteSantri(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus santri ini?')) {
            return;
        }

        try {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            const response = await fetch('/admin/santri/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                const errorData = await response.json();
                alert('Error: ' + (errorData.message || 'Failed to delete santri'));
                return;
            }

            const result = await response.json();
            alert(result.message || 'Santri berhasil dihapus');

            location.reload();

        } catch (error) {
            alert('Error: ' + error.message);
        }
    }

    function closeDetail() {
        const modalDetail = document.getElementById('modalDetail');
        if (modalDetail) {
            const modalContent = modalDetail.querySelector('div');
            if (modalContent) {
                modalContent.scrollTop = 0;
            }
            modalDetail.classList.add('hidden');
        }
        document.getElementById('detailNis').textContent = '';
        document.getElementById('detailNama').textContent = '';
        document.getElementById('detailJenisKelamin').textContent = '';
        document.getElementById('detailUsia').textContent = '';
        document.getElementById('detailNamaOrangTua').textContent = '';
        document.getElementById('detailTempatLahir').textContent = '';
        document.getElementById('detailTanggalLahir').textContent = '';
        document.getElementById('detailNoHp').textContent = '';
        document.getElementById('detailAlamat').textContent = '';
    }
</script>

@endsection
