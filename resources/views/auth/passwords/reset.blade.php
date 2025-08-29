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
          <h2 class="text-2xl font-bold text-gray-800">Ganti Kata Sandi</h2>
          <p class="text-gray-600 mt-2">Masukkan kata sandi yang ingin disimpan</p>
        </div>

        <!-- Form -->
<form action="{{ route('password.update') }}" method="POST">
  @csrf
  <input type="hidden" name="token" value="{{ $token }}">
  <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

  <!-- Password -->
  <div class="mb-6">
    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Baru</label>
    <input id="password" type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400" placeholder="Masukkan kata sandi baru">
  </div>

  <!-- Password Confirmation -->
  <div class="mb-6">
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-400" placeholder="Konfirmasi kata sandi baru">
  </div>

  <button type="submit" class="w-full bg-emerald-500 text-white py-3 rounded-lg font-semibold hover:bg-emerald-600 transition">
    Ganti Password
  </button>
</form>
      </div>
    </div>

    {{-- Menampilkan error validasi --}}
    @if ($errors->any())
    <div class="alert alert-danger col-md-6 mt-3" style="max-width: 400px">
        <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    <!-- Kanan: Gambar (hanya tampil di md ke atas) -->
    <div class="w-full md:w-1/2 hidden md:block">
      <img src="{{ asset('img/kegiatan/al-quran.jpg') }}" alt="Gambar Lupa Password" class="object-cover w-full h-full">
    </div>

  </div>

</body>
</html>
