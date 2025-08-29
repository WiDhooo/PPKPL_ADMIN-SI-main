<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ubah Kata Sandi</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
  <div class="bg-white shadow-md rounded-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-4xl">

    <!-- Kiri: Form -->
    <div class="p-8 md:w-1/2 w-full">
      <h2 class="text-2xl font-bold mb-4 text-center">Masukan Sandi Baru</h2>

      <form>
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="password">Sandi Baru</label>
          <div class="flex items-center border rounded-lg px-3 py-2 bg-white shadow-inner">
            <i class="fas fa-lock text-gray-400 mr-2"></i>
            <input id="password" type="password" placeholder="Masukkan kata sandi baru Anda"
              class="w-full outline-none text-gray-700 bg-transparent" />
          </div>
        </div>

        <div class="mb-6">
          <label class="block text-gray-700 mb-2" for="password_confirmation">Konfirmasi Sandi Baru</label>
          <div class="flex items-center border rounded-lg px-3 py-2 bg-white shadow-inner">
            <i class="fas fa-lock text-gray-400 mr-2"></i>
            <input id="password_confirmation" type="password" placeholder="Masukkan konfirmasi kata sandi Anda"
              class="w-full outline-none text-gray-700 bg-transparent" />
          </div>
        </div>

        <button type="submit"
          class="w-full bg-emerald-500 text-white py-2 rounded-lg hover:bg-emerald-600 transition mb-3">
          Perbarui Kata Sandi
        </button>
      </form>
    </div>

    <!-- Kanan: Gambar (hanya tampil di md ke atas) -->
    <div class="hidden md:block md:w-1/2">
      <img src="{{ asset('img/kegiatan/al-quran.jpg') }}" alt="Reset Password Image"
           class="w-full h-full object-cover">
    </div>

  </div>
</body>
</html>
