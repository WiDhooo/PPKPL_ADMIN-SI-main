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
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold text-[#2B3674]">Daftar Murid Kelas A</h1>
    <input type="text" placeholder="Cari Murid..."
        class="w-64 px-4 py-2 rounded-full border focus:outline-none focus:ring-2 focus:ring-emerald-500">
</div>

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-emerald-500 text-white uppercase text-sm">
                <th class="py-3 px-5 text-left">#</th>
                <th class="py-3 px-5 text-left">Nama</th>
                <th class="py-3 px-5 text-left">NIS</th>
                <th class="py-3 px-5 text-left">Email</th>
                <th class="py-3 px-5 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 bg-[#F8F9FD]">
            <tr class="border-b hover:bg-white">
                <td class="py-3 px-5">1</td>
                <td class="py-3 px-5">Budi Santoso</td>
                <td class="py-3 px-5">12001</td>
                <td class="py-3 px-5">budi@gmail.com</td>
                <td class="py-3 px-5 space-x-2">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                </td>
            </tr>
            <tr class="border-b hover:bg-white">
                <td class="py-3 px-5">2</td>
                <td class="py-3 px-5">Siti Aminah</td>
                <td class="py-3 px-5">12002</td>
                <td class="py-3 px-5">siti@gmail.com</td>
                <td class="py-3 px-5 space-x-2">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                </td>
            </tr>
            <tr class="border-b hover:bg-white">
                <td class="py-3 px-5">3</td>
                <td class="py-3 px-5">hakkam</td>
                <td class="py-3 px-5">12003</td>
                <td class="py-3 px-5">hakkam@gmail.com</td>
                <td class="py-3 px-5 space-x-2">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                </td>
            </tr>
            <tr class="border-b hover:bg-white">
                <td class="py-3 px-5">4</td>
                <td class="py-3 px-5">widho</td>
                <td class="py-3 px-5">12004</td>
                <td class="py-3 px-5">widho@gmail.com</td>
                <td class="py-3 px-5 space-x-2">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                </td>
            </tr>
            <!-- Tambahkan baris lain sesuai kebutuhan -->
        </tbody>

    </table>
    <!-- Modal Konfirmasi Hapus -->
<div id="modalHapus" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 px-4">
  <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 animate-scaleIn">
    <h2 class="text-xl font-semibold text-center text-red-600 mb-4">Konfirmasi Hapus</h2>
    <p class="text-center text-gray-700 mb-6">Apakah Anda yakin ingin menghapus <strong id="hapusNama"></strong>?</p>
    <div class="flex gap-3 justify-center">
      <button onclick="confirmDelete()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">Ya, Hapus</button>
      <button onclick="closeHapus()" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
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
    let deleteIndex = null;
    let murid = [
        { nama: "Budi Santoso", nik: "12001", email: "budi@gmail.com" },
        { nama: "Siti Aminah", nik: "12002", email: "siti@gmail.com" },
        { nama: "hakkam", nik: "12003", email: "hakkam@gmail.com" },
        { nama: "widho", nik: "12004", email: "widho@gmail.com" }
    ];

    function showDelete(i) {
        deleteIndex = i;
        document.getElementById("hapusNama").innerText = murid[i].nama;
        document.getElementById("modalHapus").classList.remove("hidden");
    }

    function closeHapus() {
        document.getElementById("modalHapus").classList.add("hidden");
        deleteIndex = null;
    }

    function confirmDelete() {
        if (deleteIndex !== null) {
            murid.splice(deleteIndex, 1);
            renderTable(); // render ulang isi tabel
            closeHapus();
        }
    }

    function renderTable() {
        const tbody = document.querySelector("tbody");
        tbody.innerHTML = "";
        murid.forEach((m, i) => {
            tbody.innerHTML += `
                <tr class="border-b hover:bg-white">
                    <td class="py-3 px-5">${i + 1}</td>
                    <td class="py-3 px-5">${m.nama}</td>
                    <td class="py-3 px-5">${m.nis}</td>
                    <td class="py-3 px-5">${m.email}</td>
                    <td class="py-3 px-5 space-x-2">
                        <button onclick="showDelete(${i})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                    </td>
                </tr>
            `;
        });
    }

    document.addEventListener("DOMContentLoaded", renderTable);
</script>
@endsection
