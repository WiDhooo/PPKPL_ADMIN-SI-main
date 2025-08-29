<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with('pendaftaran');

        // Search by nama_santri
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_santri', 'like', '%' . $search . '%');
        }

        // Filter by jenis_kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Sorting
        if ($request->has('sort_by')) {
            switch ($request->sort_by) {
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

        $santris = $query->paginate(5);
        $totalSantri = $santris->total();

        // Get total count of all santri regardless of filters
        $totalSantriAll = Santri::count();

        // Get approved pendaftaran for dropdown
        $approvedPendaftaran = \App\Models\Pendaftaran::where('status', 'approved')->get();

        if ($request->ajax()) {
            return response()->json([
                'santris' => $santris,
                'totalSantri' => $totalSantri,
                'totalSantriAll' => $totalSantriAll,
                'approvedPendaftaran' => $approvedPendaftaran,
            ]);
        }

        return view('ADMIN-SI.santri', compact('santris', 'totalSantri', 'totalSantriAll', 'approvedPendaftaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pendaftaran_id' => 'nullable|exists:tblpendaftaran,id',
            'nik' => 'required|string|max:16',
            'nama_santri' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:1',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nama_orang_tua' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'akta_kelahiran' => 'required|file|mimes:pdf|max:2048',
            'kartu_keluarga' => 'required|file|mimes:pdf|max:2048',
        ]);

        $pendaftaran = null;
        if (!empty($validated['pendaftaran_id'])) {
            $pendaftaran = \App\Models\Pendaftaran::where('id', $validated['pendaftaran_id'])
                ->where('status', 'approved')
                ->first();

            if (!$pendaftaran) {
                return response()->json(['message' => 'Pendaftaran tidak ditemukan atau belum disetujui'], 404);
            }
        }

        $aktaKelahiranFileName = null;
        if ($request->hasFile('akta_kelahiran')) {
            $aktaKelahiranFile = $request->file('akta_kelahiran');
            $aktaKelahiranFileName = time() . '_akta.' . $aktaKelahiranFile->getClientOriginalExtension();
            $aktaKelahiranFile->move(public_path('gambar/akta_kelahiran'), $aktaKelahiranFileName);
        }

        $kartuKeluargaFileName = null;
        if ($request->hasFile('kartu_keluarga')) {
            $kartuKeluargaFile = $request->file('kartu_keluarga');
            $kartuKeluargaFileName = time() . '_kk.' . $kartuKeluargaFile->getClientOriginalExtension();
            $kartuKeluargaFile->move(public_path('gambar/kartu_keluarga'), $kartuKeluargaFileName);
        }

        $santri = new Santri();
        if ($pendaftaran) {
            $santri->pendaftaran_id = $pendaftaran->id;
            $santri->nik = $pendaftaran->nik;
        } else {
            $santri->nik = $validated['nik'] ?? null;
        }
        $santri->nama_santri = $validated['nama_santri'];
        $santri->jenis_kelamin = $validated['jenis_kelamin'];
        $santri->tempat_lahir = $validated['tempat_lahir'];
        $santri->tanggal_lahir = $validated['tanggal_lahir'];
        $santri->nama_orang_tua = $validated['nama_orang_tua'];
        $santri->no_hp = $validated['no_hp'];
        $santri->alamat = $validated['alamat'];
        $santri->akta_kelahiran = $aktaKelahiranFileName;
        $santri->kartu_keluarga = $kartuKeluargaFileName;
        $santri->save();

        return response()->json(['message' => 'Santri berhasil ditambahkan'], 201);
    }

    public function edit($id)
    {
        $santri = Santri::find($id);
        if (!$santri) {
            return response()->json(['message' => 'Santri tidak ditemukan'], 404);
        }
        return response()->json($santri);
    }

    public function update(Request $request, $id)
    {
        \Log::info('SantriController@update called with id: ' . $id);
        $santri = Santri::find($id);
        if (!$santri) {
            \Log::warning('Santri not found with id: ' . $id);
            return response()->json(['message' => 'Santri tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'pendaftaran_id' => 'nullable|exists:tblpendaftaran,id',
            'nik' => 'nullable|string|max:16',
            'nama_santri' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:1',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nama_orang_tua' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'akta_kelahiran' => 'nullable|file|mimes:pdf|max:2048',
            'kartu_keluarga' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $pendaftaran = null;
        if (!empty($validated['pendaftaran_id'])) {
            $pendaftaran = \App\Models\Pendaftaran::where('id', $validated['pendaftaran_id'])
                ->where('status', 'approved')
                ->first();

            if (!$pendaftaran) {
                return response()->json(['message' => 'Pendaftaran tidak ditemukan atau belum disetujui'], 404);
            }
        }

        if ($request->hasFile('akta_kelahiran')) {
            $aktaKelahiranFile = $request->file('akta_kelahiran');
            $aktaKelahiranFileName = time() . '_akta.' . $aktaKelahiranFile->getClientOriginalExtension();
            $aktaKelahiranFile->move(public_path('gambar/akta_kelahiran'), $aktaKelahiranFileName);
            $santri->akta_kelahiran = $aktaKelahiranFileName;
        }

        if ($request->hasFile('kartu_keluarga')) {
            $kartuKeluargaFile = $request->file('kartu_keluarga');
            $kartuKeluargaFileName = time() . '_kk.' . $kartuKeluargaFile->getClientOriginalExtension();
            $kartuKeluargaFile->move(public_path('gambar/kartu_keluarga'), $kartuKeluargaFileName);
            $santri->kartu_keluarga = $kartuKeluargaFileName;
        }

        if ($pendaftaran) {
            $santri->pendaftaran_id = $pendaftaran->id;
            $santri->nik = $pendaftaran->nik;
        } else {
            $santri->nik = $validated['nik'] ?? null;
            $santri->pendaftaran_id = null;
        }
        $santri->nama_santri = $validated['nama_santri'];
        $santri->jenis_kelamin = $validated['jenis_kelamin'];
        $santri->tempat_lahir = $validated['tempat_lahir'];
        $santri->tanggal_lahir = $validated['tanggal_lahir'];
        $santri->nama_orang_tua = $validated['nama_orang_tua'];
        $santri->no_hp = $validated['no_hp'];
        $santri->alamat = $validated['alamat'];
        $santri->save();

        \Log::info('Santri updated successfully: ' . $santri->id);

        return response()->json(['message' => 'Santri berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $santri = Santri::find($id);
        if (!$santri) {
            return response()->json(['message' => 'Santri tidak ditemukan'], 404);
        }

        $santri->delete();

        return response()->json(['message' => 'Santri berhasil dihapus']);
    }
}
