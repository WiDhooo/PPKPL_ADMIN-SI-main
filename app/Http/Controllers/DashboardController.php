<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SantriRejected;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke beranda instead of back to prevent redirect loop
            return redirect()->route('beranda');
        }

        $totalPendaftar = Pendaftaran::count();
        $diterimaCount = Pendaftaran::where('status', 'accepted')->count();
        $menungguCount = Pendaftaran::where('status', 'pending')->count();
        $ditolakCount = Pendaftaran::where('status', 'rejected')->count();

        $query = Pendaftaran::query();

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_santri', 'like', '%' . $search . '%');
        }

        // Status filter
        if ($request->has('filterStatus') && $request->filterStatus != '') {
            $statusMap = [
                'Diterima' => 'accepted',
                'Menunggu' => 'pending',
                'Ditolak' => 'rejected',
            ];
            $status = $statusMap[$request->filterStatus] ?? null;
            if ($status) {
                $query->where('status', $status);
            }
        }

        // Age filter
        if ($request->has('filterUsia') && $request->filterUsia != '') {
            $ageRange = $request->filterUsia;
            $query->where(function ($q) use ($ageRange) {
                if ($ageRange === '11-12') {
                    $q->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 11 AND 12');
                } elseif ($ageRange === '13-14') {
                    $q->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 14');
                } elseif ($ageRange === '15+') {
                    $q->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 15');
                }
            });
        }

        // Sorting
        if ($request->has('sortBy')) {
            switch ($request->sortBy) {
                case 'nama_asc':
                    $query->orderBy('nama_santri', 'asc');
                    break;
                case 'nama_desc':
                    $query->orderBy('nama_santri', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'terbaru':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $pendaftaran = $query->paginate(5)->withQueryString();

        $pendaftaran->getCollection()->transform(function ($item) {
            $tanggalLahir = Carbon::parse($item->tanggal_lahir);
            $usia = $tanggalLahir->age; // Calculate age from tanggal_lahir

            // Transform file paths to full URLs
            $aktaKelahiranUrl = $item->akta_kelahiran ? url('storage/akta_kelahiran/' . $item->akta_kelahiran) : null;
            $kartuKeluargaUrl = $item->kartu_keluarga ? url('storage/kartu_keluarga/' . $item->kartu_keluarga) : null;


            return [
                'id' => $item->id,
                'nik' => $item->nik,
                'nama_santri' => $item->nama_santri,
                'tempat_lahir' => $item->tempat_lahir,
                'tanggal_lahir' => $item->tanggal_lahir,
                'jenis_kelamin' => $item->jenis_kelamin === 'L' ? 'Laki-laki' : ($item->jenis_kelamin === 'P' ? 'Perempuan' : $item->jenis_kelamin),
                'usia' => $usia,
                'no_hp' => $item->no_hp,
                'alamat' => $item->alamat,
                'akta_kelahiran' => $aktaKelahiranUrl,
                'kartu_keluarga' => $kartuKeluargaUrl,
                'created_at' => $item->created_at,
                'status' => $item->status === 'pending' ? 'Menunggu' : ($item->status === 'accepted' ? 'Diterima' : ($item->status === "rejected" ? "Ditolak" : $item->status)),
            ];
        });

        $notifications = $user->unreadNotifications()->get();

        return view('ADMIN-SI.dashboard', compact('pendaftaran', 'totalPendaftar', 'diterimaCount', 'menungguCount', 'ditolakCount', 'notifications'));
    }

    public function reject($id)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pendaftaran = Pendaftaran::find($id);
        if (!$pendaftaran) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $pendaftaran->status = 'rejected';
        $pendaftaran->save();

        // Send rejection email
        if ($pendaftaran->user && $pendaftaran->user->email) {
            Mail::to($pendaftaran->user->email)->send(new SantriRejected($pendaftaran));
        }

        return response()->json(['message' => 'Status updated to rejected']);
    }

    public function approve($id)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pendaftaran = Pendaftaran::find($id);
        if (!$pendaftaran) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $pendaftaran->status = 'accepted';
        $pendaftaran->save();

        // Send approval email with payment link
        if ($pendaftaran->user && $pendaftaran->user->email) {
            \Illuminate\Support\Facades\Mail::to($pendaftaran->user->email)->send(new \App\Mail\SantriApproved($pendaftaran));
        }

        return response()->json(['message' => 'Status updated to accepted']);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pendaftaran = Pendaftaran::find($id);
        if (!$pendaftaran) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $pendaftaran->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }
}
