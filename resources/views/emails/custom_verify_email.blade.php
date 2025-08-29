<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0;">
  <div style="max-width: 600px; margin: 30px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; color: #333333;">
    <div style="text-align: center; margin-bottom: 20px;">
      <!-- <img src="{{ asset('img/logotpanurul.png') }}" alt="Logo" style="max-width: 150px;" /> -->
      <img src="https://drive.google.com/uc?export=view&id=1l4h2PdM8hBNUckfT6XpNwgaUtE7lNif0" alt="Logo" style="max-width: 150px;" />
    </div>
    <h1 style="color: #047857; font-size: 24px; margin-bottom: 10px;">Verifikasi Email Anda</h1>
    <p>Halo {{ $user->name }},</p>
    <p>Terima kasih telah mendaftar. Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda dan mengaktifkan akun Anda.</p>
    <p style="text-align: center;">
      <a href="{{ $url }}" style="display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: #047857; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold;">Verifikasi Email</a>
    </p>
    <p>Jika Anda tidak membuat akun ini, abaikan email ini.</p>
    <div style="margin-top: 30px; font-size: 12px; color: #999999; text-align: center;">
      &copy; {{ date('Y') }} TPQ Nurul Iman. All rights reserved.
    </div>
  </div>
</body>
</html>
