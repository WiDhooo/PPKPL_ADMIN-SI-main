@extends('layouts.app')

@section('content')
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div x-data="{ showTambah: false }" class="p-6 bg-[#F8F9FD] min-h-screen font-[Poppins]">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-[#2B3674]">Daftar Kelas</h1>
        <div class="flex gap-4">
            <input type="text" placeholder="Cari Kelas..."
                class="w-64 px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button @click="showTambah = true"
                class="bg-emerald-500 text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow-md hover:bg-emerald-600 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kelas
            </button>
        </div>
    </div>

    <!-- Grid List -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($kelas as $kelasItem)
        <div x-data="{ showEdit: false, editNamaKelas: '{{ $kelasItem->kelas }}' }"
            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col max-w-sm w-full">
            <!-- Header Kelas -->
            <div class="bg-emerald-600 p-5 flex justify-between items-center rounded-t-2xl">
                <h2 class="text-white text-3xl font-extrabold tracking-tight select-none">
                    {{ $kelasItem->kelas }}
                </h2>
            </div>

            <!-- Footer Card -->
            <div class="border-t mt-auto py-4 px-6 flex justify-between items-center bg-gray-50">
                <a href="{{ route('kelas.detail', ['id' => $kelasItem->id]) }}"
                    class="text-emerald-600 font-semibold hover:text-emerald-800 transition-colors">
                    Daftar Santri
                </a>
                <div class="flex gap-4 text-sm">
                    <span @click="showEdit = true"
                        class="cursor-pointer text-yellow-600 font-semibold hover:text-yellow-800 transition-colors select-none"
                        title="Edit Kelas">✏️ Edit</span>

                    <button
                        class="text-red-600 font-semibold hover:text-red-800 transition-colors select-none focus:outline-none focus:ring-2 focus:ring-red-500 rounded"
                        title="Hapus Kelas"
                        onclick="openHapusModal('{{ $kelasItem->id }}', '{{ addslashes($kelasItem->kelas) }}')">
                        🗑️ Hapus
                    </button>

                </div>
            </div>

            <!-- Modal Edit -->
            <div x-show="showEdit" x-transition
                class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-sm px-4">
                <div @click.away="showEdit = false"
                    class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 animate-scaleIn">
                    <h3 class="text-xl font-semibold mb-4">Edit Nama Kelas</h3>
                    <form method="POST" action="{{ route('kelas.update', ['id' => $kelasItem->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="nama_kelas" x-model="editNamaKelas"
                            class="w-full p-2 border rounded mb-4" required>
                        <div class="flex justify-end gap-2">
                            <button type="submit"
                                class="bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600">Simpan</button>
                            <button type="button" @click="showEdit = false"
                                class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal Tambah Kelas -->
    <div x-show="showTambah" x-transition
        class="fixed inset-0 z-50 flex justify-center items-center bg-black/50 backdrop-blur-sm px-4">
        <div @click.away="showTambah = false"
            class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 space-y-6 animate-scaleIn">
            <h3 class="text-2xl font-semibold text-center">Form Tambah Kelas Baru</h3>
            <form id="tambahKelasForm" class="space-y-4" enctype="multipart/form-data" onsubmit="saveTambahKelas(event)">
                <div>
                    <label class="block font-medium mb-1">Nama Kelas:</label>
                    <input type="text" class="w-full p-2 border rounded-md focus:ring focus:ring-emerald-300"
                        id="tambahNamaKelas" placeholder="Nama Kelas" required>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-emerald-500 text-white rounded-md hover:bg-emerald-600">Simpan</button>
            </form>
            <button type="button"
                class="w-full py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                @click="showTambah = false">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div id="modalHapus" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center px-4">
  <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 text-center animate-scaleIn">
    <h2 class="text-2xl font-bold text-red-600 mb-2">Konfirmasi Hapus</h2>
    <p class="text-gray-700 mb-4" id="hapusNama"></p>
    <div class="flex flex-col sm:flex-row justify-center gap-4">
      <button onclick="confirmDelete()" class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">Ya, Hapus</button>
      <button onclick="closeHapus()" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded-lg">Batal</button>
    </div>
  </div>
</div>

<!-- Form Delete Dinamis -->
<form id="formDelete" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<!-- Alert -->
@if(session('error'))
<div id="popup-error" class="popup-alert">
    {{ session('error') }}
</div>
@endif

<!-- Styles -->
<style>
    .popup-alert {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #f44336;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }
</style>

<!-- Scripts -->
<script>
    setTimeout(() => {
        const popup = document.getElementById('popup-error');
        if (popup) {
            popup.style.opacity = '0';
            setTimeout(() => popup.remove(), 500);
        }
    }, 3000);

    function saveTambahKelas(event) {
        event.preventDefault();
        const namaKelas = document.getElementById('tambahNamaKelas').value;
        if (!namaKelas) {
            alert('Nama Kelas harus diisi.');
            return;
        }

        const formData = new FormData();
        formData.append('nama_kelas', namaKelas);

        fetch('{{ route("kelas.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal menyimpan data kelas.');
            return response.json();
        })
        .then(data => {
            window.location.reload();
        })
        .catch(error => {
            console.error('Error adding kelas:', error);
        });
    }

    // Modal Hapus
    let deleteId = null;

    function openHapusModal(id, nama) {
        deleteId = id;
        document.getElementById('hapusNama').textContent = `Yakin ingin menghapus kelas ${nama}?`;
        document.getElementById('modalHapus').classList.remove('hidden');
    }

    function closeHapus() {
        deleteId = null;
        document.getElementById('modalHapus').classList.add('hidden');
    }

    function confirmDelete() {
        if (!deleteId) return;
        const form = document.getElementById('formDelete');
        form.action = `{{ url('kelas') }}/${deleteId}`;
        form.submit();
    }
</script>

@endsection
