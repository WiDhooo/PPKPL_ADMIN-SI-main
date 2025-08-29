<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lupa Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-8">

  <div class="flex w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden">

    <!-- Kiri: Form Lupa Password -->
    <div class="w-full md:w-1/2 p-8 flex items-center justify-center">

      <div class="w-full max-w-md">
        <a href="{{ route('login') }}" class="border border-red-500 text-red-500 px-4 py-2 rounded text-center hover:bg-red-100 inline-flex items-center gap-2 mb-4">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="text-center mb-8">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500 rounded-full mb-4">
            <i class="fas fa-unlock-alt text-white fa-lg"></i>
          </div>
          <h2 class="text-2xl font-bold text-gray-800">Lupa Kata Sandi</h2>
          <p class="text-gray-600 mt-2">Masukkan email untuk ubah kata sandi</p>
        </div>

        <!-- Form -->
        <form action="{{ route('password.email') }}" method="POST">
          @csrf

          <!-- Email -->
          <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input id="email" type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400" placeholder="Masukkan email Anda">
          </div>

          <button type="submit" class="w-full bg-emerald-500 text-white py-3 rounded-lg font-semibold hover:bg-emerald-600 transition">
            Selanjutnya
          </button>
        </form>
      </div>
    </div>

    <!-- Kanan: Gambar (hanya tampil di md ke atas) -->
    <div class="w-full md:w-1/2 hidden md:block">
      <img src="{{ asset('img/kegiatan/al-quran.jpg') }}" alt="Gambar Lupa Password" class="object-cover w-full h-full">
    </div>

  </div>

</body>
</html>
