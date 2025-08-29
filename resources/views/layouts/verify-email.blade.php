<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi Email</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 py-10">
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Verifikasi Email</h1>
    <p class="mb-4">Silakan periksa email Anda dan klik tautan verifikasi untuk mengaktifkan akun Anda.</p>
    <p class="mb-4">Jika Anda belum menerima email verifikasi, silakan periksa folder spam atau kirim ulang email verifikasi dari halaman profil Anda setelah masuk.</p>

    <form id="resend-verification-form" action="{{ route('resend.email.submit') }}" method="POST" style="display:none;">
      @csrf
      <input type="hidden" name="email" value="{{ auth()->user()->email }}">
    </form>

    <p class="mb-4">
      <a href="#" onclick="event.preventDefault(); document.getElementById('resend-verification-form').submit();" class="text-emerald-500 hover:underline">
        Kirim Ulang Email Verifikasi
      </a>
    </p>

    <div class="mt-4 text-center">
      <a href="/login"
         class="w-full bg-emerald-500 text-white py-3 rounded-lg font-semibold hover:bg-emerald-600 block">
        Kembali ke masuk
      </a>
    </div>
  </div>
</body>
</html>
