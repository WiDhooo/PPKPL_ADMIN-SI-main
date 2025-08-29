<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Mail\SantriApproved;
use App\Notifications\NewPendaftaranNotification;
use App\Models\User;

class PendaftaranController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:admin')->only('approve'); // Middleware khusus admin untuk approve
    // }

    public function showForm()
    {
        $userId = Auth::id();
        $pendaftaran = Pendaftaran::where('user_id', $userId)->latest()->first();

        if ($pendaftaran) {
            if ($pendaftaran->status_pembayaran == 'lunas') {
                return redirect()->route('pendaftaran.status');
            } elseif ($pendaftaran->status_pembayaran == 'belum') {
                return view('pendaftaran.belum_bayar', compact('pendaftaran'));
            }
        }

        return view('pendaftaran.form');
    }


    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login sebagai user untuk melakukan pendaftaran.']);
        }

        $validatedData = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:tblpendaftaran,nik',
            'nama_santri' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => ['required', 'date', function ($attribute, $value, $fail) {
                $age = Carbon::parse($value)->age;
                if ($age < 5 || $age > 12) {
                    $fail('Umur santri harus antara 5 hingga 12 tahun.');
                }
            }],
            'jenis_kelamin' => 'required|string|in:L,P',
            'alamat' => 'required|string',
            'nama_orang_tua' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email',
            'akta_kelahiran' => 'required|file|mimes:pdf|max:10240',
            'kartu_keluarga' => 'required|file|mimes:pdf|max:10240',
        ], [
            'akta_kelahiran.max' => 'Ukuran akta kelahiran tidak boleh lebih dari 10 MB.',
            'kartu_keluarga.max' => 'Ukuran kartu keluarga tidak boleh lebih dari 10 MB.',
        ]);

        // Simpan file menggunakan storage disk public
        if ($request->hasFile('akta_kelahiran')) {
            $aktaName = $request->file('akta_kelahiran')->store('akta_kelahiran', 'public');
            $validatedData['akta_kelahiran'] = $aktaName;
        }

        if ($request->hasFile('kartu_keluarga')) {
            $kkName = $request->file('kartu_keluarga')->store('kartu_keluarga', 'public');
            $validatedData['kartu_keluarga'] = $kkName;
        }

        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = 'pending';

        $pendaftaran = Pendaftaran::create($validatedData);

        // Kirim notifikasi ke admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewPendaftaranNotification($pendaftaran));
        }

        return redirect()->route('pendaftaran.success');
    }

    public function approve($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->status = 'diterima';
        $pendaftaran->save();

        if (!empty($pendaftaran->email)) {
            try {
                Mail::to($pendaftaran->email)->send(new SantriApproved($pendaftaran));
            } catch (\Exception $e) {
                // Log error jika email gagal dikirim
                \Log::error('Gagal mengirim email approval: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true]);
    }
}
