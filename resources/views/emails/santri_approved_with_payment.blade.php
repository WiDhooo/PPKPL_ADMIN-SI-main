<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Pendaftaran Diterima</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:Arial, sans-serif;">
  <table width="100%" cellspacing="0" cellpadding="0" style="padding: 20px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; padding:40px; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
          <!-- Header -->
          <tr>
            <td align="center" style="padding-bottom: 20px;">
              <img src="https://drive.google.com/uc?export=view&id=1l4h2PdM8hBNUckfT6XpNwgaUtE7lNif0" alt="Verify" width="150" height="150" style="margin-bottom: 16px;" />
              <h2 style="font-size:24px; color:#111827; margin:0;">TPQ Yayasan Nurul Iman</h2>
            </td>
          </tr>

          <!-- Body Content -->
          <tr>
            <td style="color:#374151; font-size:16px; line-height:1.5; padding: 10px 0;">
              <h2>Assalamualaikum, {{ $pendaftaran->nama_santri }}!</h2>
              <p>Terima kasih telah mendaftar.</p>
              <p>Selamat, pendaftaran Anda telah <strong>DITERIMA</strong>.</p>
              <p>Silakan klik tombol di bawah ini untuk melanjutkan ke halaman pembayaran:</p>
            </td>
          </tr>

          <!-- Button -->
          <tr>
            <td align="center" style="padding: 20px 0;">
              <a href="{{ url('/bayar/' . $pendaftaran->id) }}"
                 style="background-color:#50c878; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-weight:600; display:inline-block;">
                Ke Halaman Pembayaran
              </a>
            </td>
          </tr>

          <!-- Footer Note -->
          <tr>
            <td style="color:#6b7280; font-size:14px; padding-top: 10px; text-align: center;">
              <p>Jika Anda tidak merasa melakukan pendaftaran, abaikan email ini.</p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding-top: 30px; color:#9ca3af; font-size:12px; text-align:center;">
              © 2025 Yayasan TPQ Nurul Iman. Semua hak dilindungi.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
