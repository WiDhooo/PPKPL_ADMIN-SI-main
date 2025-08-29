<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Models\User;
use App\Http\Controllers\SantriController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PembayaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', function () {
    return redirect()->route('beranda');
});
Route::view('/beranda', 'beranda')->name('beranda');
Route::get('/galeri', [GaleriController::class, 'webGaleri'])->name('galeri');
Route::view('/informasi_pendaftaran', 'informasi_pendaftaran1')->name('informasi_pendaftaran');
Route::view('/kontak', 'kontak')->name('kontak');
Route::view('/pembayaran', 'pembayaran')->name('pembayaran');
Route::get('/pengajar', [GuruController::class, 'webPengajar'])->name('pengajar');
Route::view('/program', 'program')->name('program');
Route::view('/tentang', 'tentang')->name('tentang');

//login
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticating']);
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');

    // Halaman form input email
    Route::get('/password/reset', function () {
        return view('auth.passwords.email');
    })->name('password.request');

    // Kirim link reset via email
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

    // Tampilkan form reset password (token dari email)
    Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

    // Proses reset password
    Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');

    Route::get('/resend-email', [AuthController::class, 'showResendEmailForm'])->name('resend.email.form');
    Route::post('/resend-email', [AuthController::class, 'handleResendEmail'])->name('resend.email.submit');

    Route::get('/email/verify', function (){ 
        return view('layouts.verify-email');
    })->middleware('auth')->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/login');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::get('/login-admin', [AuthController::class, 'login_admin'])->name('login-admin');
    Route::post('/login-admin', [AuthController::class, 'authenticating_admin'])->name('login-admin.post');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pendaftaran', function () {
        $user = Auth::user();
        if (!$user || $user->isUser() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        return view('pendaftaran');
    })->name('pendaftaran');

    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.post');
    // Route::post('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');

    Route::get('/pendaftaran/success', function () {
        return view('pendaftaran_success');
    })->name('pendaftaran.success');

    Route::get('/pembayaran', function () {
        $user = auth()->user();
        if (!$user || $user->isUser() === false) {
            abort(403, 'Unauthorized');
        }
        return view('pembayaran');
    })->name('pembayaran');

    Route::post('/pembayaran', [AuthController::class, 'postPembayaran'])->name('pembayaran.post');
});



Route::prefix('admin')->middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/akademik', [GuruController::class, 'webIndex'])->name('akademik');
    Route::get('/guru/create', [GuruController::class, 'webCreate'])->name('guru.create');
    Route::post('/guru', [GuruController::class, 'webStore'])->name('guru.store');
    Route::get('/guru/{guru}', [GuruController::class, 'webShow'])->name('guru.show');
    Route::get('/guru/{guru}/edit', [GuruController::class, 'webEdit'])->name('guru.edit');
    Route::put('/guru/{guru}', [GuruController::class, 'webUpdate'])->name('guru.update');
    Route::delete('/guru/{guru}', [GuruController::class, 'webDestroy'])->name('guru.destroy');
    Route::get('/fotokegiatan', [GaleriController::class, 'fotokegiatan'])->name('fotokegiatan');
    Route::get('/galeri/create', [GaleriController::class, 'webCreate'])->name('galeri.create');
    Route::post('/galeri', [GaleriController::class, 'webStore'])->name('galeri.store');
    Route::get('/galeri/{galeri}', [GaleriController::class, 'webShow'])->name('galeri.show');
    Route::get('/galeri/{galeri}/edit', [GaleriController::class, 'webEdit'])->name('galeri.edit');
    Route::put('/galeri/{galeri}', [GaleriController::class, 'webUpdate'])->name('galeri.update');
    Route::delete('/galeri/{galeri}', [GaleriController::class, 'webDestroy'])->name('galeri.destroy');

    Route::get('/aduan', function () {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        return view('ADMIN-SI.aduan');
    })->name('aduan');

    Route::get('/panduan', function () {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        return view('ADMIN-SI.panduan');
    })->name('panduan');

    Route::get('/search', function () {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        return view('search');
    })->name('search');

    Route::get('/spp', function () {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        return view('ADMIN-SI.spp');
    })->name('spp');

    Route::get('/kelas', function () {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        $kelas = \App\Models\Kelas::all();
        return view('ADMIN-SI.kelas', compact('kelas'));
    })->name('kelas');

    Route::get('/santri', [SantriController::class, 'index'])->name('santri');
    Route::post('/santri', [SantriController::class, 'store'])->name('santri.store');
    Route::put('/santri/{id}', [SantriController::class, 'update'])->name('santri.update');
    Route::post('/santri/{id}', [SantriController::class, 'update'])->name('santri.update.post');
    Route::delete('/santri/{id}', [SantriController::class, 'destroy'])->name('santri.destroy');

    Route::get('/kelas/{id}', [KelasController::class, 'detail'])->name('kelas.detail');

    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');

    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');

    Route::delete('/kelas/{kelasId}/hapus-semua-santri', [KelasController::class, 'removeAllSantriFromKelas'])->name('kelas.hapusSemuaSantri');

    Route::post('/kelas/{kelasId}/hapus-santri/{santriId}', [KelasController::class, 'removeSantriFromKelas'])->name('kelas.hapusSantri');

    Route::post('/kelas/{id}/tambah-santri', [KelasController::class, 'updateSantriKelas'])->name('kelas.tambahSantri');

    Route::get('/profil', function () {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        return view('ADMIN-SI.profil');
    })->name('profil');

    Route::post('/pendaftaran/{id}/reject', [DashboardController::class, 'reject'])->name('dashboard.pendaftaran.reject');
    Route::post('/pendaftaran/{id}/approve', [DashboardController::class, 'approve'])->name('dashboard.pendaftaran.approve');
    Route::delete('/pendaftaran/{id}', [DashboardController::class, 'destroy'])->name('dashboard.pendaftaran.destroy');

    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

});

Route::middleware(['web'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

//Pembayaran 
Route::get('/bayar/{id}', [PembayaranController::class, 'formBayar']);
Route::post('/bayar/process', [PembayaranController::class, 'processBayar']);

//incase kalau bayar berhasil
Route::get('/pembayaran/sukses', function () {
    return view('pembayaran.sukses');
});

//Cetak PDF
Route::get('/pengajar/cetak-pdf', [App\Http\Controllers\GuruController::class, 'cetakPDF'])->name('pengajar.cetak.pdf');

Route::get('/dokumen/pdf/{filename}', function ($filename) {
    $path = storage_path('app/pdf/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});


