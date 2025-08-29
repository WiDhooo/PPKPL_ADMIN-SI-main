<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .animate-fadeInUp {
      animation: fadeInUp 0.8s ease-out forwards;
    }
  </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-8">

<div class="flex w-full max-w-6xl bg-white rounded-2xl shadow-xl overflow-hidden">

  <!-- Kiri: Form Login -->
  <div class="w-1/2 flex items-center justify-center p-8 animate-fadeInUp">
    <div class="w-full max-w-md">
    <a href="{{ route('login') }}" class="border border-red-500 text-red-500 px-4 py-2 rounded text-center hover:bg-red-50 inline-flex items-center gap-2">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-4">
          <i class="fas fa-sign-in-alt text-emerald-500 fa-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Yayasan Nurul Iman</h2>
        <p class="text-gray-600 mt-2">Silakan masuk untuk mengelola sistem</p>
      </div>

      <form action="{{ route('login-admin') }}" method="POST">
        @csrf

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300" placeholder="Masukkan email Anda">
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
          <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300" placeholder="Masukkan kata sandi Anda">
        </div>

        <button type="submit" class="w-full bg-emerald-500 text-white py-3 rounded-lg font-semibold hover:bg-emerald-600">
  Masuk
</button>
      </form>
    </div>
  </div>

  <!-- Kanan: Gambar -->
  <div class="w-1/2">
    <img src="{{ asset('img/kegiatan/al-quran.jpg') }}" alt="Login Image" class="object-cover w-full h-full">
  </div>

</div>

</body>
</html>