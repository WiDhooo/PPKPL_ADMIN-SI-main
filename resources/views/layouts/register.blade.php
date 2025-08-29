<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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

  <!-- Left: Form -->
  <div class="w-full md:w-1/2 p-8 opacity-0 translate-y-5 animate-fadeInUp flex items-center">
    <div class="w-full">
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-4">
          <i class="fas fa-user-plus text-emerald-500 fa-lg"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Buat Akun</h2>
        <p class="text-gray-600 mt-2">Memulai Akun Anda</p>
      </div>

      <form id="registerForm" action="{{ route('register') }}" method="POST">
        @csrf
        <!-- Full Name -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
          <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300" placeholder="Masukkan nama Anda" />
          @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300" placeholder="Masukkan email Anda" />
          @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Buat Kata Sandi</label>
          <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300" placeholder="Masukkan kata sandi Anda" />
          @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
          <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-lg border border-gray-300" placeholder="Masukkan kata sandi konfirmasi Anda" />
          @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <button id="registerSubmit" type="submit" class="w-full bg-emerald-500 text-white py-3 rounded-lg font-semibold hover:bg-emerald-600">
          Buat Akun
        </button>

        <p class="mt-6 text-center text-gray-600">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="ml-1 text-emerald-500 hover:text-emerald-700 font-semibold">Sign in</a>
        </p>
      </form>
    </div>
  </div>

  <!-- Right: Image -->
  <div class="w-full md:w-1/2 hidden md:block">
    <img src="{{ asset('img/kegiatan/al-quran.jpg') }}" alt="Sekolah" class="object-cover w-full h-96 md:h-full" />
  </div>

</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center z-50">
  <div class="flex flex-row gap-2 mr-4">
      <div class="w-4 h-4 rounded-full bg-green-700 animate-bounce"></div>
      <div class="w-4 h-4 rounded-full bg-green-700 animate-bounce" style="animation-delay: -0.3s;"></div>
      <div class="w-4 h-4 rounded-full bg-green-700 animate-bounce" style="animation-delay: -0.5s;"></div>
    </div>
  <p class="mt-4 text-white font-medium text-base animate-pulse">Memuat... Mohon tunggu</p>
</div>

<script>
  document.getElementById('registerForm').addEventListener('submit', function() {
    document.getElementById('registerSubmit').disabled = true;
    document.getElementById('loadingOverlay').classList.remove('hidden');
  });
</script>

</body>
</html>
