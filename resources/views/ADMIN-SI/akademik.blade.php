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

  .guru-card {
    max-width: 420px;
    width: 100%;
    padding: 2rem;
    border-radius: 1.25rem;
    background-color: white;
    box-shadow: 0 8px 10px rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow: hidden;
  }

  .guru-card h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2B3674;
    margin-bottom: 0.5rem;
  }

  .guru-card p {
    color: #4B5563;
    margin-bottom: 0.25rem;
  }
</style>

<div x-data="guruApp()" class="p-6 bg-[#F8F9FD] w-full min-h-screen flex flex-col">
  <!-- Header -->
  <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
    <h1 class="text-2xl font-bold text-[#2B3674]">Guru</h1>
    <div class="flex items-center gap-4">
      <div class="relative w-full max-w-xs">
        <input type="text" placeholder="Mencari guru..." x-model="searchQuery" @input="fetchGurus" class="w-full pl-10 pr-4 py-2 text-gray-500 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
          fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35M17 10a7 7 0 1 0-7 7 7 7 0 0 0 7-7z" />
        </svg>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
<div class="mb-6 flex justify-end gap-3 px-6">
  <a href="{{ route('pengajar.cetak.pdf') }}" target="_blank"
    class="bg-red-500 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:bg-red-600">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M12 4v16m-8 0h8" />
    </svg>
    Cetak PDF
  </a>

  <button @click="openModal('tambah')" class="bg-emerald-500 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:bg-emerald-600">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Tambah Guru
  </button>
</div>


  <!-- Guru Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-4">
    <template x-for="(guru, index) in filteredGurus()" :key="guru.id">
      <div class="guru-card animate-scaleIn" x-show="guru">
        <!-- Gambar -->
        <div class="w-full flex justify-center mb-4">
          <img :src="guru.gambar ? gambarBaseUrl + guru.gambar : defaultImageUrl" alt="guru Picture"
            class="w-24 h-24 rounded-full object-cover border-4 border-emerald-500" />
        </div>

        <!-- Nama -->
        <div class="mt-4 flex gap-3 justify-center">
          <h3 class="text-left" x-text="guru.nama"></h3>
        </div>

        <!-- Konten align left -->
        <div class="w-full text-left px-2">
          <p><strong>NIP:</strong> <span x-text="guru.nip"></span></p>
          <p><strong>Jabatan:</strong> <span x-text="guru.jabatan"></span></p>
          <p><strong>Pengalaman:</strong> <span x-text="guru.pengalaman"></span> tahun</p>
          <p><strong>Pendidikan:</strong> <span x-text="guru.pendidikan_terakhir"></span></p>
          <p><strong>Mata Pelajaran:</strong> <span x-text="guru.mata_pelajaran"></span></p>
        </div>

        <!-- Tombol di tengah -->
        <div class="mt-4 flex gap-3 justify-center">
          <button @click="openModal('edit', guru)" class="px-5 py-2 bg-yellow-400 text-white rounded-md text-sm">Edit</button>
          <button @click="openDeleteModal(guru)" class="px-5 py-2 bg-red-500 text-white rounded-md text-sm">Delete</button>
        </div>
      </div>
    </template>
  </div>

  <!-- Modal -->
  <div x-show="showModal" x-transition.opacity class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md animate-scaleIn max-h-[80vh] overflow-y-auto">
      <h2 class="text-xl font-bold mb-4 text-gray-700" x-text="modalTitle"></h2>

      <form @submit.prevent="submitForm" enctype="multipart/form-data" x-ref="modalForm" novalidate>
        <template x-if="form.id">
          <input type="hidden" name="_method" value="PUT" />
        </template>
        <input type="hidden" name="id" x-model="form.id" />

        <!-- Nama -->
        <label class="block text-sm font-medium">Nama</label>
        <input type="text" name="nama" x-model="form.nama" :class="{'mb-4': !errors.nama, 'mb-1': errors.nama}" class="border p-2 w-full rounded-lg" />
        <template x-if="errors.nama"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.nama"></div></template>

        <!-- NIP -->
        <label class="block text-sm font-medium">NIP</label>
        <input type="text" name="nip" x-model="form.nip" :class="{'mb-4': !errors.nip, 'mb-1': errors.nip}" class="border p-2 w-full rounded-lg" />
        <template x-if="errors.nip"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.nip"></div></template>

        <!-- Jabatan -->
        <label class="block text-sm font-medium">Jabatan</label>
        <input type="text" name="jabatan" x-model="form.jabatan" :class="{'mb-4': !errors.jabatan, 'mb-1': errors.jabatan}" class="border p-2 w-full rounded-lg" />
        <template x-if="errors.jabatan"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.jabatan"></div></template>

        <!-- Pengalaman -->
        <label class="block text-sm font-medium">Pengalaman (tahun)</label>
        <input type="number" name="pengalaman" x-model="form.pengalaman" min="0" step="1" @input="sanitizePengalamanInput()" :class="{'mb-4': !errors.pengalaman, 'mb-1': errors.pengalaman}" class="border p-2 w-full rounded-lg" />
        <template x-if="errors.pengalaman"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.pengalaman"></div></template>

        <!-- Pendidikan Terakhir -->
        <label class="block text-sm font-medium">Pendidikan Terakhir</label>
        <input type="text" name="pendidikan_terakhir" x-model="form.pendidikan_terakhir" :class="{'mb-4': !errors.pendidikan_terakhir, 'mb-1': errors.pendidikan_terakhir}" class="border p-2 w-full rounded-lg" />
        <template x-if="errors.pendidikan_terakhir"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.pendidikan_terakhir"></div></template>

        <!-- Mata Pelajaran -->
        <label class="block text-sm font-medium">Mata Pelajaran</label>
        <input type="text" name="mata_pelajaran" x-model="form.mata_pelajaran" :class="{'mb-4': !errors.mata_pelajaran, 'mb-1': errors.mata_pelajaran}" class="border p-2 w-full rounded-lg" />
        <template x-if="errors.mata_pelajaran"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.mata_pelajaran"></div></template>

        <!-- Gambar -->
        <label class="block text-sm font-medium">Gambar</label>
        <input type="file" name="gambar" accept="image/*" @change="handleFileUpload" class="border p-2 w-full mb-0.5 rounded-lg" />
        <template x-if="errors.gambar"><div class="text-red-500 text-sm mt-0.5 mb-4" x-text="errors.gambar"></div></template>

        <template x-if="form.gambarPreview">
          <img :src="form.gambarPreview" class="max-w-full max-h-48 object-contain rounded-lg shadow-md mt-2 mx-auto block" />
        </template>

        <div class="flex justify-end gap-2 mt-4">
          <button type="button" @click="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg" x-text="form.id ? 'Update' : 'Save'"></button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm animate-scaleIn text-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-red-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Apakah kamu yakin?</h3>
      <p class="text-sm text-gray-600 mb-4">Tindakan ini akan menghapus data guru secara permanen.</p>

      <div class="flex justify-center gap-3 mt-4">
        <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</button>
        <button @click="deleteGuru()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
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
  const gambarBaseUrl = '{{ asset('gambar') }}/';
  const defaultImageUrl = '{{ asset('img/dashboard/teacher.png') }}';

  setTimeout(() => {
        const popup = document.getElementById('popup-error');
        if (popup) {
            popup.style.opacity = '0';
            setTimeout(() => popup.remove(), 500);
        }
    }, 3000);

  function guruApp() {
    return {
      showModal: false,
      showDeleteModal: false,
      modalTitle: '',
      form: {
        id: null,
        nama: '',
        nip: '',
        jabatan: '',
        pengalaman: '',
        pendidikan_terakhir: '',
        mata_pelajaran: '',
        gambar: null,
        gambarPreview: null,
      },
      errors: {},
      searchQuery: '',
      gurus: [],

      init() {
        this.fetchGurus();
      },

      fetchGurus() {
        fetch(`/api/guru?q=${encodeURIComponent(this.searchQuery)}`)
          .then(response => response.json())
          .then(data => {
            this.gurus = data;
          });
      },

      filteredGurus() {
        if (!this.searchQuery) {
          return this.gurus;
        }
        return this.gurus.filter(guru => guru.nama.toLowerCase().includes(this.searchQuery.toLowerCase()));
      },

      openModal(type, guru = null) {
        this.errors = {};
        this.modalTitle = type === 'tambah' ? 'Tambah Guru' : 'Edit Guru';
        if (type === 'edit' && guru) {
          this.form = {
            id: guru.id,
            nama: guru.nama,
            nip: guru.nip,
            jabatan: guru.jabatan,
            pengalaman: guru.pengalaman,
            pendidikan_terakhir: guru.pendidikan_terakhir,
            mata_pelajaran: guru.mata_pelajaran,
            gambar: null,
            gambarPreview: guru.gambar ? gambarBaseUrl + guru.gambar : null,
          };
        } else {
          this.form = {
            id: null,
            nama: '',
            nip: '',
            jabatan: '',
            pengalaman: '',
            pendidikan_terakhir: '',
            mata_pelajaran: '',
            gambar: null,
            gambarPreview: null,
          };
        }
        this.showModal = true;
      },

      closeModal() {
        this.showModal = false;
        this.errors = {};
        this.form = {
          id: null,
          nama: '',
          nip: '',
          jabatan: '',
          pengalaman: '',
          pendidikan_terakhir: '',
          mata_pelajaran: '',
          gambar: null,
          gambarPreview: null,
        };
        if (this.$refs.modalForm) {
          const fileInput = this.$refs.modalForm.querySelector('input[type="file"]');
          if (fileInput) {
            fileInput.value = '';
          }
        }
      },

      handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = e => {
            this.form.gambarPreview = e.target.result;
          };
          reader.readAsDataURL(file);
          this.form.gambar = file;
        }
      },

      submitForm() {
        this.errors = {};
        const formData = new FormData(this.$refs.modalForm);
        let url = '/api/guru';
        let method = 'POST';

        if (this.form.id) {
          url = `/api/guru/${this.form.id}`;
          method = 'POST';
          formData.append('_method', 'PUT');
        }

        fetch(url, {
          method: method,
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          body: formData,
        })
          .then(async response => {
            if (!response.ok) {
              const errorData = await response.json();
              this.errors = errorData.errors || {};
              throw new Error('Validation failed');
            }
            return response.json();
          })
          .then(() => {
            this.closeModal();
            this.fetchGurus();
          })
          .catch(error => {
            console.error(error);
          });
      },

      openDeleteModal(guru) {
        this.guruToDelete = guru;
        this.showDeleteModal = true;
      },

      deleteGuru() {
        if (!this.guruToDelete || !this.guruToDelete.id) return;

        fetch(`/api/guru/${this.guruToDelete.id}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
        })
          .then(response => response.json())
          .then(() => {
            this.showDeleteModal = false;
            this.fetchGurus();
          })
          .catch(error => {
            console.error(error);
          });
      },

      sanitizePengalamanInput() {
        if (this.form.pengalaman !== null && this.form.pengalaman !== '') {
          let val = this.form.pengalaman.toString();
          val = val.replace(/[^0-9]/g, '');
          val = val.replace(/^0+(?=\d)/, '');
          this.form.pengalaman = val === '' ? '' : Number(val);
        }
      }
    }
  }
</script>
@endsection
