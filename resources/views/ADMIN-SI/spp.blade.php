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
</style>

<div class="p-6 bg-[#F8F9FD]" x-data="sppApp()">

    <!-- Header with Profile and Search -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-[#2B3674]">SPP List</h1>
        <div class="flex gap-4">

            <!-- Search Bar -->
            <form action="#" method="GET" class="relative">
            <input type="text" x-model="query" placeholder="Cari Pembayaran SPP..." class="w-full pl-10 pr-4 py-2 text-gray-500 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>

            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-medium">
                    HF
                </div>
            <!-- Profile Section -->
            <div class="flex items-center gap-4">
            </div>
        </div>
    </div>

    <!-- SPP List Table -->
    <div class="bg-white rounded-md overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nama Santri</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status Pembayaran</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tanggal Pembayaran</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            <template x-for="(spp, index) in filteredSppList" :key="spp.id">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500 text-center" x-text="index + 1"></td>
                        <td class="px-6 py-4 text-center" x-text="spp.nama"></td>
                        <td class="px-6 py-4 text-center">
                            <span :class="spp.status === 'Lunas' ? 'px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800' : 'px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800'" x-text="spp.status"></span>
                        </td>
                        <td class="px-6 py-4 text-center" x-text="spp.tanggal"></td>
                        <td class="px-6 py-4 text-center" x-text="spp.jumlah"></td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button @click="openModal('detail', spp)" class="flex-1 px-3 py-1 bg-emerald-500 text-white rounded-md text-sm">Detail</button>
                                <button @click="openModal('edit', spp)" class="flex-1 px-3 py-1 bg-yellow-400 text-white rounded-md text-sm">Edit</button>
                                <button @click="openModal('hapus', spp)" class="flex-1 px-3 py-1 bg-red-500 text-white rounded-md text-sm">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
<!-- Modal Detail SPP -->
<div x-show="showDetailModal" x-transition.opacity class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center px-4">
  <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 animate-scaleIn">
    <h2 class="text-2xl font-bold text-center text-emerald-600 mb-4">Detail SPP</h2>

    <div>
      <label class="block font-medium text-gray-700 mb-1">Nama</label>
      <div class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800" x-text="selectedSpp.nama"></div>
    </div>

    <div class="mt-4">
      <label class="block font-medium text-gray-700 mb-1">Status</label>
      <div class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800" x-text="selectedSpp.status"></div>
    </div>

    <div class="mt-4">
      <label class="block font-medium text-gray-700 mb-1">Tanggal</label>
      <div class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800" x-text="selectedSpp.tanggal"></div>
    </div>

    <div class="mt-4">
      <label class="block font-medium text-gray-700 mb-1">Jumlah</label>
      <div class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-800" x-text="selectedSpp.jumlah"></div>
    </div>

    <button @click="closeModal()" class="mt-6 w-full py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg">Tutup</button>
  </div>
</div>

<!-- Modal Edit -->
<div x-show="showEditModal" x-transition.opacity class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center px-4">
  <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md animate-scaleIn">
    <h2 class="text-xl font-bold text-center text-yellow-500 mb-4">Edit SPP</h2>
    <form @submit.prevent="saveEdit()">
      <label class="block text-gray-700">Nama</label>
      <input type="text" x-model="selectedSpp.nama" class="w-full px-3 py-2 border rounded-lg mb-3">

      <label class="block text-gray-700">Status Pembayaran</label>
      <select x-model="selectedSpp.status" class="w-full px-3 py-2 border rounded-lg mb-3">
        <option value="Lunas">Lunas</option>
        <option value="Belum Lunas">Belum Lunas</option>
      </select>

      <label class="block text-gray-700">Tanggal Pembayaran</label>
      <input type="text" x-model="selectedSpp.tanggal" class="w-full px-3 py-2 border rounded-lg mb-3">

      <label class="block text-gray-700">Jumlah</label>
      <input type="text" x-model="selectedSpp.jumlah" class="w-full px-3 py-2 border rounded-lg mb-3">

      <div class="flex justify-end gap-2 mt-4">
        <button type="button" @click="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
        <button type="submit" class="bg-emerald-500 text-white px-4 py-2 rounded-lg">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center px-4">
  <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md text-center animate-scaleIn">
    <h2 class="text-xl font-bold text-red-600 mb-4">Yakin akan menghapus?</h2>
    <p><strong>Nama:</strong> <span x-text="selectedSpp.nama"></span></p>
    <div class="flex justify-center gap-2 mt-4">
      <button type="button" @click="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Tutup</button>
      <button type="button" @click="deleteSpp()" class="bg-red-500 text-white px-4 py-2 rounded-lg">Hapus</button>
    </div>
  </div>
</div>


</div>
@endsection
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
function sppApp() {
    return {
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedSpp: {},
        sppList: [
            { id: 1, nama: "Budi Santoso", status: "Lunas", tanggal: "2024-03-01", jumlah: "500.000" },
            { id: 2, nama: "Siti Aminah", status: "Belum Lunas", tanggal: "2024-03-10", jumlah: "500.000" },
            { id: 3, nama: "Andi Wijaya", status: "Lunas", tanggal: "2024-02-20", jumlah: "500.000" }
        ],
        openModal(type, spp = null) {
            this.selectedSpp = spp || {};
            this.showEditModal = type === 'edit';
            this.showDeleteModal = type === 'hapus';
            this.showDetailModal = type === 'detail';
        },
        closeModal() {
            this.showEditModal = false;
            this.showDeleteModal = false;
            this.showDetailModal = false;
        },
        saveEdit() {
            this.closeModal();
        },
        deleteSpp() {
            this.sppList = this.sppList.filter(spp => spp.id !== this.selectedSpp.id);
            this.closeModal();
        }
    };
}
function sppApp() {
    return {
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedSpp: {},
        query: '',
        sppList: [
            { id: 1, nama: "Budi Santoso", status: "Lunas", tanggal: "2024-03-01", jumlah: "500.000" },
            { id: 2, nama: "Siti Aminah", status: "Belum Lunas", tanggal: "2024-03-10", jumlah: "500.000" },
            { id: 3, nama: "Andi Wijaya", status: "Lunas", tanggal: "2024-02-20", jumlah: "500.000" }
        ],
        get filteredSppList() {
            return this.sppList.filter(spp =>
                spp.nama.toLowerCase().includes(this.query.toLowerCase())
            );
        },
        openModal(type, spp = null) {
            this.selectedSpp = spp || {};
            this.showEditModal = type === 'edit';
            this.showDeleteModal = type === 'hapus';
            this.showDetailModal = type === 'detail';
        },
        closeModal() {
            this.showEditModal = false;
            this.showDeleteModal = false;
            this.showDetailModal = false;
        },
        saveEdit() {
            this.closeModal();
        },
        deleteSpp() {
            this.sppList = this.sppList.filter(spp => spp.id !== this.selectedSpp.id);
            this.closeModal();
        }
    };
}

</script>
