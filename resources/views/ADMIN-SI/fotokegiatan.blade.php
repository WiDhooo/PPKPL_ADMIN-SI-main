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

<div x-data="fotokegiatanApp()" x-init="init()" class="p-6 bg-[#F8F9FD]">

    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-[#2B3674]">Foto Kegiatan</h1>
        <div class="flex items-center gap-4">
            <form action="{{ route('fotokegiatan') }}" method="GET" class="relative w-full max-w-xs">
                <input type="text" name="search" placeholder="Cari Kegiatan..."
                    class="w-full pl-10 pr-4 py-2 text-gray-500 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('search') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            </form>
            <div class="flex items-center gap-3">
                <!-- <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-medium">
                    HF
                </div> -->
            </div>
        </div>
    </div>

    <!-- Validation Errors -->
    <!-- Menghilangkan tampilan error validasi di atas tabel -->
    <!--
    <template x-if="Object.keys(errors).length > 0">
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                <template x-for="(message, field) in errors" :key="field">
                    <li x-text="message"></li>
                </template>
            </ul>
        </div>
    </template>
    -->

    <!-- Kategori dan Tambah Button -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
        <div class="w-full sm:w-auto">
            <form action="{{ route('fotokegiatan') }}" method="GET">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="sort" onchange="this.form.submit()" class="border rounded-lg px-3 py-2 w-full sm:w-48 text-sm">
                    <option value="">Sortir</option>
                    <option value="judul_asc" {{ request('sort') == 'judul_asc' ? 'selected' : '' }}>Judul dari A-Z</option>
                    <option value="judul_desc" {{ request('sort') == 'judul_desc' ? 'selected' : '' }}>Judul dari Z-A</option>
                    <option value="tanggal_asc" {{ request('sort') == 'tanggal_asc' ? 'selected' : '' }}>Tanggal dari yang paling lama</option>
                    <option value="tanggal_desc" {{ request('sort') == 'tanggal_desc' ? 'selected' : '' }}>Tanggal dari yang paling baru</option>
                </select>
            </form>
        </div>
        <div class="w-full sm:w-auto flex justify-end">
            <button @click="openModal('tambah')" class="bg-emerald-500 text-white px-3 py-2 rounded-lg flex items-center gap-1 shadow-md hover:bg-emerald-600 text-sm w-full sm:w-auto justify-center sm:justify-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kegiatan
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-md overflow-x-auto shadow-md">
<table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-center">No.</th>
                    <th class="px-4 py-3 text-center">Judul</th>
                    <th class="px-4 py-3 text-center">Tanggal Kegiatan</th>
                    <th class="px-4 py-3 text-center">Preview</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($galeris as $index => $galeri)
                <tr class="hover:bg-gray-50 text-center">
                    <td class="px-4 py-4 text-gray-500">{{ $galeris->firstItem() + $index }}</td>
                    <td class="px-4 py-4 break-words whitespace-normal max-w-xs">{{ $galeri->judul }}</td>
                    <td class="px-4 py-4">{{ \Carbon\Carbon::parse($galeri->tanggal)->format('d M Y') }}</td>
                    <td class="px-4 py-4">
                        @if($galeri->gambar)
                        <img src="{{ asset('gambar/' . $galeri->gambar) }}" class="h-16 w-24 object-cover rounded-lg shadow-md" alt="{{ $galeri->judul }}">
                        @else
                        <div class="h-16 w-24 bg-gray-300 rounded-lg flex items-center justify-center text-gray-500">No Image</div>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex justify-center gap-2">
                            <button @click="openModal('detail', {{ $galeri->id }})" class="px-3 py-1 bg-emerald-500 text-white rounded-md text-sm">Detail</button>
                            <button @click="openModal('edit', {{ $galeri->id }})" class="px-3 py-1 bg-yellow-400 text-white rounded-md text-sm">Edit</button>
                            <button @click="openModal('hapus', {{ $galeri->id }})" class="px-3 py-1 bg-red-500 text-white rounded-md text-sm">Hapus</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6 flex justify-center items-center space-x-2">
        <a href="{{ $galeris->url(1) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100"><<</a>
        @if ($galeris->onFirstPage())
            <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed"><</span>
        @else
            <a href="{{ $galeris->previousPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100"><</a>
        @endif

        @php
            $lastPage = $galeris->lastPage();
            $currentPage = $galeris->currentPage();

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
            <a href="{{ $galeris->url(1) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">1</a>
            <span class="px-3 py-1">...</span>
        @endif

        @foreach ($pages as $page)
            @if ($page == $galeris->currentPage())
                <span class="px-3 py-1 rounded border border-blue-500 bg-blue-100 font-semibold">{{ $page }}</span>
            @else
                <a href="{{ $galeris->url($page) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">{{ $page }}</a>
            @endif
        @endforeach

        @if ($showLast)
            <span class="px-3 py-1">...</span>
            <a href="{{ $galeris->url($lastPage) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">{{ $lastPage }}</a>
        @endif

        @if ($galeris->hasMorePages())
            <a href="{{ $galeris->nextPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">></a>
        @else
            <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">></span>
        @endif
        <a href="{{ $galeris->url($galeris->lastPage()) }}" class="px-3 py-1 rounded border border-gray-300 hover:bg-gray-100">>></a>
    </div>

    <!-- Modal -->
    <div x-show="showModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" style="display: none;">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg animate-scaleIn scale-105">
            <h2 class="text-xl font-bold mb-4 text-gray-700" x-text="modalTitle"></h2>

            <template x-if="modalType === 'detail'">
                <div class="flex flex-col items-center space-y-4 max-h-[80vh] overflow-y-auto px-4">
                    <template x-if="form.gambarPreview">
                    <img 
                        :src="form.gambarPreview" 
                        alt="Gambar Kegiatan" 
                        class="max-w-full max-h-64 object-contain rounded-lg shadow-md border border-gray-200"
                    >
                    </template>

                    <h3 class="text-center font-extrabold text-2xl text-gray-800" x-text="form.judul"></h3>

                    <p class="text-justify text-gray-700 whitespace-pre-wrap leading-relaxed" x-text="form.deskripsi"></p>

                    <button 
                    type="button" 
                    @click="closeModal()" 
                    class="mt-6 px-6 py-2 bg-emerald-500 hover:bg-emerald-600 transition-colors text-white rounded-lg font-semibold"
                    >
                    Kembali
                    </button>
                </div>
                </template>

            <form :action="formAction" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm" x-ref="formElement" x-show="modalType !== 'detail'">
                <template x-if="modalType !== 'hapus'">
                    <div>
                        <label class="block text-sm font-medium">Judul</label>
                        <input type="text" name="judul" x-model="form.judul" :class="{'mb-4': !errors.judul, 'mb-1': errors.jabatan}" class="border p-2 w-full mb-2 rounded-lg" :readonly="modalType === 'detail'">
                        <template x-if="errors.judul"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.judul"></div></template>

                        <label class="block text-sm font-medium">Deskripsi Singkat</label>
                        <textarea name="deskripsi" x-model="form.deskripsi" :class="{'mb-4': !errors.deskripsi, 'mb-1': errors.deskripsi}" class="border p-2 w-full mb-2 rounded-lg" :readonly="modalType === 'detail'"></textarea>
                        <template x-if="errors.deskripsi"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.deskripsi"></div></template>

                        <label class="block text-sm font-medium">Tanggal Kegiatan</label>
                        <input type="date" name="tanggal" x-model="form.tanggal" :class="{'mb-4': !errors.tanggal, 'mb-1': errors.tanggal}" class="border p-2 w-full mb-2 rounded-lg" :readonly="modalType === 'detail'">
                        <template x-if="errors.tanggal"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.tanggal"></div></template>

                        <label class="block text-sm font-medium">Gambar</label>
                        <input type="file" name="gambar" accept=".jpg,.jpeg,.png" @change="handleFileUpload" class="border p-2 w-full mb-2 rounded-lg" :disabled="modalType === 'detail'">

<template x-if="form.gambarPreview">
    <img :src="form.gambarPreview" class="max-w-full max-h-48 object-contain rounded-lg shadow-md mt-2 mx-auto block">
</template>
                    </div>
                </template>

                <template x-if="modalType === 'hapus'">
                    <p class="text-center text-gray-700">Apakah Anda yakin ingin menghapus kegiatan ini?</p>
                </template>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg" x-text="modalType === 'hapus' ? 'Hapus' : 'Simpan'"></button>
                </div>
            </form>
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
function fotokegiatanApp() {
    return {
        showModal: false,
        modalType: '',
        modalTitle: '',
        formAction: '',
        form: {
            id: null,
            judul: '',
            deskripsi: '',
            tanggal: '',
            gambar: null,
            gambarPreview: null,
        },
        init() {
            // Initialization if needed
        },
        openModal(type, id = null) {
            this.modalType = type;
            if (type === 'tambah') {
                this.modalTitle = 'Tambah Kegiatan';
                this.formAction = '{{ route("galeri.store") }}';
                this.form = { id: null, judul: '', deskripsi: '', tanggal: '', gambar: null, gambarPreview: null };
                this.showModal = true;
            } else if (type === 'edit' || type === 'detail') {
fetch(`/api/galeri/${id}`)
                            .then(response => response.json())
                            .then(data => {
                                this.form = {
                                    id: data.id,
                                    judul: data.judul,
                                    deskripsi: data.deskripsi,
                                    tanggal: data.tanggal,
                                    gambar: null,
                                    gambarPreview: data.gambar ? `/gambar/${data.gambar}` : null,
                                };
                                this.modalTitle = type === 'edit' ? 'Edit Kegiatan' : 'Detail Kegiatan';
                                this.formAction = type === 'edit' ? `/api/galeri/${id}` : '';
                                this.showModal = true;
                            });
            } else if (type === 'hapus') {
                this.modalTitle = 'Konfirmasi Hapus';
                this.form = { id: id };
                this.showModal = true;
            }
        },
        closeModal() {
            this.form = { id: null, judul: '', deskripsi: '', tanggal: '', gambar: null, gambarPreview: null };
            this.errors = {}; // Clear validation errors on cancel
            this.modalType = '';
            this.modalTitle = '';
            this.formAction = '';
            if (this.$refs.formElement) {
                const fileInput = this.$refs.formElement.querySelector('input[type="file"]');
                if (fileInput) {
                    fileInput.value = '';
                }
            }
            this.showModal = false;
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file harus JPG, JPEG, atau PNG.');
                    event.target.value = '';
                    this.form.gambarPreview = null;
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => {
                    this.form.gambarPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        errors: {},
        submitForm() {
            this.errors = {};
            if (this.modalType === 'hapus') {
                // Submit delete form using fetch
fetch(`/api/galeri/${this.form.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                }).then(response => response.json())
                  .then(() => {
                      window.location.reload();
                  });
            } else {
                // Submit add or edit form
                const formData = new FormData(this.$refs.formElement);
                if (this.modalType === 'edit') {
                    formData.append('_method', 'PUT');
                }
                fetch(this.formAction, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                }).then(async response => {
                    if (!response.ok) {
                        const errorData = await response.json();
                        this.errors = errorData.errors || {};
                        throw new Error('Validation failed');
                    }
                    return response.json();
                }).then(() => {
                    window.location.reload();
                }).catch(error => {
                    console.error(error);
                });
            }
        }
    }
}
</script>
@endsection
