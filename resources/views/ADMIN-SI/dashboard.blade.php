@extends('layouts.app')

@section('content')
<style>
  @keyframes scaleIn {
    0% { transform: scale(0.9); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
  }

  .animate-scaleIn {
    animation: scaleIn 0.3s ease-out forwards;
  }

  .typewriter {
    white-space: nowrap;
    overflow: hidden;
    border-right: 2px solid #1e40af; /* Tailwind's blue-800 */
    width: 0;
    animation: typing 2s steps(10, end) forwards, blink-caret 0.7s step-end infinite;
  }

  @keyframes typing {
    from { width: 0 }
    to { width: 7ch } /* "Memuat..." = 7 characters */
  }

  @keyframes blink-caret {
    from, to { border-color: transparent }
    50% { border-color: #1e40af; }
  }
</style>

<div id="mainContent" class="p-6 bg-[#F8F9FD]">
    <!-- Wrapper -->
    <div class="flex flex-col mb-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h1 class="text-2xl font-bold text-[#2B3674]">Dashboard</h1>
            <div class="flex items-center gap-3 w-full md:w-auto">

                <!-- Search Bar -->
                <form method="GET" action="{{ url('/admin/dashboard') }}" class="relative flex-1 md:flex-none w-full md:w-64">
                    <input type="text" name="search" id="searchQuery" placeholder="Cari Santri Baru..."
                        value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2 text-gray-500 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                          fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M17 10a7 7 0 1 0-7 7 7 7 0 0 0 7-7z" /></svg>
                </form>

                <!-- Notifikasi -->
                 @php
    $notificationsArray = [];
    foreach ($notifications as $notification) {
        $notificationsArray[] = [
            'id' => $notification->id ?? $notification->getKey(),
            'message' => $notification->data['message'] ?? '',
            'created_at' => $notification->created_at->toDateTimeString(),
        ];
    }
@endphp
<div x-data="{ showModal: false, notifications: window.initialNotifications || [] }" class="relative">
    <!-- Tombol ikon notifikasi -->
    <button @click="showModal = true" class="text-gray-600 focus:outline-none relative">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.002 2.002 0 0018 14V10a6 6 0 00-12 0v4c0 .795-.316 1.513-.832 2.005L3 17h5" />
        </svg>
        <!-- Badge jumlah notifikasi -->
        <span x-show="notifications.length > 0"
            class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full px-1">
            <span x-text="notifications.length"></span>
        </span>
    </button>
   

    <!-- Modal Popup -->
    <div x-show="showModal" x-transition
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 px-4">
        <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg max-h-[80vh] space-y-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Notifikasi</h3>
                <button @click="showModal = false" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-x-auto max-h-80 overflow-y-auto">
                <!-- Jika tidak ada notifikasi -->
                <template x-if="notifications.length === 0">
                    <p class="text-center text-gray-500">Tidak ada notifikasi baru.</p>
                </template>
                <!-- Jika ada notifikasi -->
                <template x-if="notifications.length > 0">
                    <table class="min-w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">Pesan</th>
                                <th class="px-4 py-2">Waktu</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="notification in notifications" :key="notification.id">
                                <tr class="hover:bg-gray-50 border-b">
                                    <td class="px-4 py-2" x-text="notification.message"></td>
                                    <td class="px-4 py-2 text-xs"
                                        x-text="new Date(notification.created_at).toLocaleString()"></td>
                                    <td class="px-4 py-2 text-right">
                                      <button @click.stop="markAsRead(notification.id)"
                                          class="text-gray-600 border border-gray-300 rounded-lg p-1 hover:border-green-500 hover:text-green-500 transition"
                                          aria-label="Mark as read" title="Sudah Dibaca">
                                          <!-- Icon centang -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                          </svg>
                                      </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </template>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end px-6 py-4 border-t">
                <button @click="showModal = false"
                    class="bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600">Tutup</button>
            </div>
        </div>
    </div>
</div>


            <!-- Profile -->
            <!-- <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-medium">
                HF
            </div> -->
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
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pendaftar -->
        <div class="bg-white p-6 rounded-xl flex items-center gap-4">
            <div class="bg-emerald-100 p-4 rounded-full">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-500">Total Pendaftar</p>
                <h3 class="text-2xl font-bold">{{ $totalPendaftar }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl flex items-center gap-5">
          <div class="bg-green-100 p-3 rounded-full flex items-center justify-center">
            <svg 
              class="w-7 h-7 text-green-600" 
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24" 
              stroke-width="2" 
              stroke-linecap="round" 
              stroke-linejoin="round"
              >
              <path d="M9 12l2 2 4-4" />
              <circle cx="12" cy="12" r="9" />
            </svg>
          </div>
          <div>
            <p class="text-gray-500 text-sm">Diterima</p>
            <h3 class="text-2xl font-bold">{{ $diterimaCount }}</h3>
          </div>
        </div>


        <!-- Menunggu -->
        <div class="bg-white p-6 rounded-xl flex items-center gap-4">
            <div class="bg-yellow-100 p-4 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-500">Menunggu</p>
                <h3 class="text-2xl font-bold">{{ $menungguCount }}</h3>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-white p-6 rounded-xl flex items-center gap-4">
            <div class="bg-red-100 p-4 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-500">Ditolak</p>
                <h3 class="text-2xl font-bold">{{ $ditolakCount }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter & Sorting Section -->
    <form method="GET" action="{{ url('/admin/dashboard') }}" class="bg-white p-6 rounded-md mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Filter Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pendaftaran</label>
                <select id="filterStatus" name="filterStatus" onchange="this.form.submit()" class="w-full border rounded-lg px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="Diterima" {{ request('filterStatus') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Menunggu" {{ request('filterStatus') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Ditolak" {{ request('filterStatus') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Filter Usia -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Usia</label>
                <select id="filterUsia" name="filterUsia" onchange="this.form.submit()" class="w-full border rounded-lg px-3 py-2">
                    <option value="">Semua Usia</option>
                    <option value="4-6" {{ request('filterUsia') == '4-6' ? 'selected' : '' }}>4-6 tahun</option>
                    <option value="7-12" {{ request('filterUsia') == '7-12' ? 'selected' : '' }}>7-12 tahun</option>
                    <option value="13-15" {{ request('filterUsia') == '13-15' ? 'selected' : '' }}>13-15 tahun</option>
                </select>
            </div>

            <!-- Sorting -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                <select id="sortBy" name="sortBy" onchange="this.form.submit()" class="w-full border rounded-lg px-3 py-2">
                    <option value="terbaru" {{ request('sortBy') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="terlama" {{ request('sortBy') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                    <option value="nama_asc" {{ request('sortBy') == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="nama_desc" {{ request('sortBy') == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                </select>
            </div>

        </div>
    </form>

    <div class="mt-4 w-full">
    <div class="w-full px-4">
        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-full bg-white shadow-md text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-center text-gray-600">No</th>
                        <th class="px-4 py-2 text-center text-gray-600">NIK</th>
                        <th class="px-4 py-2 text-center text-gray-600">Nama Santri</th>
                        <th class="px-4 py-2 text-center text-gray-600">Jenis Kelamin</th>
                        <th class="px-4 py-2 text-center text-gray-600">Usia</th>
                        <th class="px-4 py-2 text-center text-gray-600">Tanggal</th>
                        <th class="px-4 py-2 text-center text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-gray-600">Aksi</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach ($pendaftaran as $index => $item)
                        <tr>
                        <td class="px-6 py-4 text-center whitespace">{{ ($pendaftaran->currentPage() - 1) * $pendaftaran->perPage() + $index + 1 }}</td>
                        <td class="px-2 py-1 text-center whitespace">{{ $item['nik'] }}</td>
                        <td class="px-4 py-2 text-center whitespace">{{ $item['nama_santri'] }}</td>
                        <td class="px-4 py-2 text-center whitespace">{{ $item['jenis_kelamin'] === 'L' ? 'Laki-laki' : ($item['jenis_kelamin'] === 'P' ? 'Perempuan' : $item['jenis_kelamin']) }}</td>
                        <td class="px-4 py-2 text-center whitespace">{{ \Carbon\Carbon::parse($item['tanggal_lahir'])->age }}</td>
                        <td class="px-4 py-2 text-center whitespace">{{ \Carbon\Carbon::parse($item['created_at'])->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                        <td class="px-4 py-2 text-center whitespace">{{ $item['status'] === 'pending' ? 'Menunggu' : ($item['status'] === 'accepted' ? 'Diterima' : ($item['status'] === 'rejected' ? 'Ditolak' : $item['status'])) }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex flex-wrap justify-center gap-2">
                                    @if ($item['status'] !== 'Ditolak' && $item['status'] !== 'Diterima')
                                    <button onclick="showApprove({{ $index }})" class="bg-emerald-500 text-white px-3 py-1 rounded text-sm hover:bg-emerald-600 transition">Diterima</button>
                                    <button onclick="showDitolak({{ $index }})" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">Ditolak</button>
                                    @endif
                                    <button onclick="showDetail({{ $index }})" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition">Detail</button>
                                    <button onclick="deleteSiswa({{ $index }})" class="bg-red-700 text-white px-3 py-1 rounded text-sm hover:bg-red-800 transition">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex justify-center items-center space-x-2">
            <a href="{{ $pendaftaran->url(1) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100"><<</a>
            @if ($pendaftaran->onFirstPage())
                <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed"><</span>
            @else
                <a href="{{ $pendaftaran->previousPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100"><</a>
            @endif

            @php
                $lastPage = $pendaftaran->lastPage();
                $currentPage = $pendaftaran->currentPage();

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
                <a href="{{ $pendaftaran->url(1) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">1</a>
                <span class="px-3 py-1">...</span>
            @endif

            @foreach ($pages as $page)
                @if ($page == $pendaftaran->currentPage())
                    <span class="px-3 py-1 rounded border border-blue-500 bg-blue-100 font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $pendaftaran->url($page) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
                @endif
            @endforeach

            @if ($showLast)
                <span class="px-3 py-1">...</span>
                <a href="{{ $pendaftaran->url($lastPage) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">{{ $lastPage }}</a>
            @endif

            @if ($pendaftaran->hasMorePages())
                <a href="{{ $pendaftaran->nextPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">></a>
            @else
                <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">></span>
            @endif
            <a href="{{ $pendaftaran->url($pendaftaran->lastPage()) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">>></a>
        </div>
    </div>

<!-- Modal Detail -->
<div id="modalDetail" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 px-4">
  <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-8 animate-scaleIn overflow-y-auto max-h-[80vh] space-y-6">
    <h2 class="text-2xl font-bold text-center text-emerald-600 mb-4">Detail Santri</h2>
    <div>
      <label class="block font-medium text-gray-700 mb-1">Nama Santri</label>
      <div id="detailNama" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
    </div>
    <div>
      <label class="block font-medium text-gray-700 mb-1">NIK</label>
      <div id="detailNik" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800"></div>
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

<!-- Modal Diterima -->
<div id="modalApprove" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 px-4">
  <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 animate-scaleIn">
    <h2 class="text-xl font-semibold text-center text-green-600 mb-4">Konfirmasi Diterima</h2>
    <input type="hidden" id="approveIndex">
    <p class="text-center text-gray-700 mb-6">Setujui status Santri <strong id="approveNama"></strong> menjadi <strong>Diterima</strong>?</p>
    <div class="flex gap-3 justify-center">
      <button id="approveConfirmBtn" onclick="confirmApprove()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">Ya, Setujui</button>
      <button id="approveCancelBtn" onclick="closeApprove()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
      <button id="approveLoadingBtn" class="bg-gray-400 text-white px-4 py-2 rounded-md hidden cursor-not-allowed" disabled>Memuat...</button>
    </div>
  </div>
</div>

  <!-- Modal Hapus -->
  <div id="modalHapus" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 px-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 animate-scaleIn text-center">
      <h2 class="text-2xl font-bold text-red-600 mb-2">Konfirmasi Hapus</h2>
      <p class="text-gray-700 mb-4" id="hapusNama"></p>
      <input type="hidden" id="deleteIndex" />
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <button onclick="confirmDelete()" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">Ya, Hapus</button>
        <button onclick="closeHapus()" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded-lg">Batal</button>
      </div>
    </div>
</div>

<!-- Modal Ditolak -->
<div id="modalDitolak" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 px-4">
  <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 animate-scaleIn">
    <h2 class="text-xl font-semibold text-center text-red-600 mb-4">Konfirmasi Tolak</h2>
    <input type="hidden" id="ditolakIndex">
    <p class="text-center text-gray-700 mb-6">Tolak status Santri <strong id="ditolakNama"></strong>?</p>
    <div class="flex gap-3 justify-center">
      <button id="rejectConfirmBtn" onclick="confirmDitolak()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">Ya, Tolak</button>
      <button id="rejectCancelBtn" onclick="closeDitolak()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
      <button id="rejectLoadingBtn" class="bg-gray-400 text-white px-4 py-2 rounded-md hidden cursor-not-allowed" disabled>Memuat...</button>
    </div>
</div>

<script>
  let pendaftaran = @json($pendaftaran->items());

  window.initialNotifications = @json($notificationsArray);

  function showDetail(index) {
    const item = pendaftaran[index];
    document.getElementById('detailNik').textContent = item.nik || '';
    document.getElementById('detailNama').textContent = item.nama_santri;
    document.getElementById('detailJenisKelamin').textContent = item.jenis_kelamin;
    document.getElementById('detailUsia').textContent = new Date().getFullYear() - new Date(item.tanggal_lahir).getFullYear();
    document.getElementById('detailTempatLahir').textContent = item.tempat_lahir || '';
    document.getElementById('detailTanggalLahir').textContent = new Date(item.tanggal_lahir).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    document.getElementById('detailNoHp').textContent = item.no_hp || '';
    document.getElementById('detailAlamat').textContent = item.alamat || '';

    // Akta Kelahiran
    const aktaLink = document.getElementById('aktaLink');
    const aktaIframe = document.getElementById('detailAktaKelahiran');
    if (item.akta_kelahiran) {
      let aktaUrl = item.akta_kelahiran;
      aktaLink.href = aktaUrl;
      aktaIframe.src = aktaUrl;
      aktaIframe.style.display = 'block';
    } else {
      aktaLink.href = '#';
      aktaIframe.src = '';
      aktaIframe.style.display = 'none';
    }

    // Kartu Keluarga
    const kkLink = document.getElementById('kkLink');
    const kkIframe = document.getElementById('detailKartuKeluarga');
    if (item.kartu_keluarga) {
      let kkUrl = item.kartu_keluarga;
      if (!kkUrl.startsWith('http') && !kkUrl.startsWith('/')) {
        kkUrl = '/' + kkUrl;
      }
      kkLink.href = kkUrl;
      kkIframe.src = kkUrl;
      kkIframe.style.display = 'block';
    } else {
      kkLink.href = '#';
      kkIframe.src = '';
      kkIframe.style.display = 'none';
    }

    document.getElementById('modalDetail').classList.remove('hidden');
  }

  function closeDetail() {
    document.getElementById('modalDetail').classList.add('hidden');
  }

  function showApprove(index) {
    const item = pendaftaran[index];
    document.getElementById('approveIndex').value = index;
    document.getElementById('approveNama').textContent = item.nama_santri;
    document.getElementById('modalApprove').classList.remove('hidden');
  }

  function closeApprove() {
    document.getElementById('modalApprove').classList.add('hidden');
  }

  function confirmApprove() {
    const index = document.getElementById('approveIndex').value;
    const item = pendaftaran[index];

    const confirmBtn = document.getElementById('approveConfirmBtn');
    const cancelBtn = document.getElementById('approveCancelBtn');
    const loadingBtn = document.getElementById('approveLoadingBtn');

    confirmBtn.classList.add('hidden');
    cancelBtn.classList.add('hidden');
    loadingBtn.classList.remove('hidden');

    fetch(`/admin/pendaftaran/${item.id}/approve`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            window.location.reload();
        } else {
            confirmBtn.classList.remove('hidden');
            cancelBtn.classList.remove('hidden');
            loadingBtn.classList.add('hidden');
            alert('Gagal menyetujui pendaftaran.');
        }
    }).catch(() => {
        confirmBtn.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
        loadingBtn.classList.add('hidden');

        alert('Terjadi kesalahan saat menghubungi server.');
    });
}


  function showDitolak(index) {
    const item = pendaftaran[index];
    document.getElementById('ditolakIndex').value = index;
    document.getElementById('ditolakNama').textContent = item.nama_santri;
    document.getElementById('modalDitolak').classList.remove('hidden');
  }

  function closeDitolak() {
    document.getElementById('modalDitolak').classList.add('hidden');
  }

  function confirmDitolak() {
    const index = document.getElementById('ditolakIndex').value;
    const item = pendaftaran[index];

    const confirmBtn = document.getElementById('rejectConfirmBtn');
    const cancelBtn = document.getElementById('rejectCancelBtn');
    const loadingBtn = document.getElementById('rejectLoadingBtn');

    confirmBtn.classList.add('hidden');
    cancelBtn.classList.add('hidden');
    loadingBtn.classList.remove('hidden');

    fetch(`/admin/pendaftaran/${item.id}/reject`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      }
    }).then(response => {
      if (response.ok) {
        window.location.reload();
      } else {
        confirmBtn.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
        loadingBtn.classList.add('hidden');
        alert('Gagal menolak pendaftaran.');
      }
    }).catch(() => {
      confirmBtn.classList.remove('hidden');
      cancelBtn.classList.remove('hidden');
      loadingBtn.classList.add('hidden');

      alert('Terjadi kesalahan saat menghubungi server.');
    });
  }

  function deleteSiswa(index) {
    const item = pendaftaran[index];
    document.getElementById('hapusNama').textContent = item.nama_santri;
    document.getElementById('modalHapus').classList.remove('hidden');
    document.getElementById('deleteIndex').value = index;
  }

  function closeHapus() {
    document.getElementById('modalHapus').classList.add('hidden');
  }

  function confirmDelete() {
    const index = document.getElementById('deleteIndex').value;
    const item = pendaftaran[index];
    fetch(`/admin/pendaftaran/${item.id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      }
    }).then(response => {
      if (response.ok) {
        window.location.reload();
      } else {
        alert('Gagal menghapus pendaftaran.');
      }
    }).catch(() => {
      alert('Terjadi kesalahan saat menghubungi server.');
    });
  }

  function markAsRead(notificationId) {
    fetch('/admin/notifications/' + notificationId + '/read', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      }
    }).then(function(response) {
      if (response.ok) {
        window.location.href = '{{ route("dashboard") }}';
      } else {
        alert('Gagal menandai notifikasi sebagai sudah dibaca.');
      }
    }).catch(function(error) {
      alert('Terjadi kesalahan saat menghubungi server.');
      console.error(error);
    });
  }
</script>




@endsection

