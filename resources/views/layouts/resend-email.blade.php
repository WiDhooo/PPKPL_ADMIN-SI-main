<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kirim Ulang Email Verifikasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 py-10">
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Kirim Ulang Email Verifikasi</h1>

    @if(session('status'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('status') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('resend.email.submit') }}" method="POST">
      @csrf
      <div class="mb-6">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email" name="email" id="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300" placeholder="Masukkan email Anda" value="{{ old('email') }}">
      </div>

      <div class="flex justify-between items-center">
        <a href="{{ route('login') }}" class="text-emerald-500 hover:text-emerald-700 font-semibold inline-flex items-center gap-2">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="bg-emerald-500 text-white py-2 px-6 rounded-lg font-semibold hover:bg-emerald-600">
          Kirim
        </button>
      </div>
    </form>
  </div>
</body>
</html>
