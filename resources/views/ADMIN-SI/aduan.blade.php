@extends('layouts.app')

@section('content')
<style>
  @keyframes scaleIn {
    0% { transform: scale(0.95); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
  }

  .animate-scaleIn {
    animation: scaleIn 0.3s ease-out forwards;
  }
</style>

<div x-data="{
    showDetailModal: false,
    showEditModal: false,
    showDeleteConfirm: false,
    selectedAduan: {},
    deleteIndex: null,
    aduan: [
        { pelapor: 'Budi', kategori: 'Infrastruktur', tanggal: '2025-03-10', status: 'Belum Diproses' },
        { pelapor: 'Siti', kategori: 'Lingkungan', tanggal: '2025-03-09', status: 'Diproses' },
        { pelapor: 'Andi', kategori: 'Pelayanan Publik', tanggal: '2025-03-08', status: 'Selesai' },
        { pelapor: 'Rina', kategori: 'Keamanan', tanggal: '2025-03-07', status: 'Belum Diproses' },
    ],
    searchQuery: '',
    get filteredAduan() {
        return this.aduan.filter(item => {
            return item.pelapor.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                   item.kategori.toLowerCase().includes(this.searchQuery.toLowerCase());
        });
    }
}" class="p-6 bg-[#F8F9FD]">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-[#2B3674]">Tabel Aduan</h1>

        <div class="flex items-center gap-4">
            <form action="#" method="GET" class="relative">
                <input type="text" x-model="searchQuery" placeholder="Cari Aduan..."
                    class="w-full pl-10 pr-4 py-2 text-gray-500 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>

            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-medium">
                    HF
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-md overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pelapor</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <template x-for="(data, index) in filteredAduan" :key="index">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500 text-center" x-text="index + 1"></td>
                        <td class="px-6 py-4 text-center" x-text="data.pelapor"></td>
                        <td class="px-6 py-4 text-center" x-text="data.kategori"></td>
                        <td class="px-6 py-4 text-center" x-text="data.tanggal"></td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                  :class="{
                                      'bg-yellow-100 text-yellow-800': data.status === 'Diproses',
                                      'bg-green-100 text-green-800': data.status === 'Selesai',
                                      'bg-red-100 text-red-800': data.status === 'Belum Diproses'
                                  }"
                                  x-text="data.status"></span>
                        </td>
                        <td class="px-6 py-4 border-gray-400">
                            <div class="flex gap-2">
                                <button @click="showDetailModal = true; selectedAduan = data" class="flex-1 px-3 py-1 bg-emerald-500 text-white rounded-md text-sm">Detail</button>
                                <button @click="showEditModal = true; selectedAduan = data" class="flex-1 px-3 py-1 bg-yellow-400 text-white rounded-md text-sm" style="background-color: #facc15 !important;">Edit</button>
                                <button @click="deleteIndex = index; showDeleteConfirm = true" class="flex-1 px-3 py-1 bg-red-500 text-white rounded-md text-sm">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Modal Edit -->
<div x-show="showEditModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md animate-scaleIn">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Edit Aduan</h2>

        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm text-gray-700">Nama Pelapor</label>
                <input type="text" x-model="selectedAduan.pelapor" class="w-full px-3 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="block text-sm text-gray-700">Kategori</label>
                <input type="text" x-model="selectedAduan.kategori" class="w-full px-3 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="block text-sm text-gray-700">Tanggal</label>
                <input type="date" x-model="selectedAduan.tanggal" class="w-full px-3 py-2 border rounded-lg">
            </div>

            <div class="mb-3">
                <label class="block text-sm text-gray-700">Status</label>
                <select x-model="selectedAduan.status" class="w-full px-3 py-2 border rounded-lg">
                    <option value="Belum Diproses">Belum Diproses</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="showEditModal = false" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
                <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail -->
<!-- Modal Detail -->
<div x-show="showDetailModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md animate-scaleIn">
        <h2 class="text-2xl font-semibold text-[#2B3674] mb-6">Detail Aduan</h2>

        <form class="space-y-4 text-sm">
            <div>
                <label class="block text-gray-700">Nama Pelapor</label>
                <input type="text" x-model="selectedAduan.pelapor" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-gray-700">Kategori</label>
                <input type="text" x-model="selectedAduan.kategori" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-gray-700">Tanggal</label>
                <input type="date" x-model="selectedAduan.tanggal" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-gray-700">Status</label>
                <select x-model="selectedAduan.status" disabled class="w-full px-3 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
                    <option value="Belum Diproses">Belum Diproses</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" @click="showDetailModal = false" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-400">Tutup</button>
            </div>
        </form>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div x-show="showDeleteConfirm" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md animate-scaleIn">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Konfirmasi Hapus</h2>
        <p class="mb-4 text-sm text-gray-600">Apakah Anda yakin ingin menghapus aduan ini?</p>
        <div class="flex justify-end gap-2">
            <button @click="showDeleteConfirm = false" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
            <button @click="showDeleteConfirm = false; aduan.splice(deleteIndex, 1)" class="bg-red-500 text-white px-4 py-2 rounded-lg">Hapus</button>
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
@endsection