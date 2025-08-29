<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruController extends Controller
{
    // Web methods
    public function webIndex(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        $search = $request->query('q');
        if ($search) {
            $gurus = Guru::where('nama', 'like', '%' . $search . '%')->get();
        } else {
            $gurus = Guru::all();
        }
        return view('ADMIN-SI.akademik', compact('gurus', 'search'));
    }

    public function webPengajar()
    {
        $gurus = Guru::all();
        return view('pengajar', compact('gurus'));
    }

    public function webCreate()
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        return view('guru.create');
    }

    public function webShow($id)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        $guru = Guru::findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    public function webEdit($id)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        $guru = Guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function webStore(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        $request->validate([
            'nama' => 'required|max:100',
            'nip' => 'required|max:20|unique:tblguru,nip',
            'jabatan' => 'required|max:50',
            'mata_pelajaran' => 'required',
            'pengalaman' => 'required|integer',
            'pendidikan_terakhir' => 'required|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:200000',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.max' => 'NIP maksimal 20 karakter.',
            'nip.unique' => 'NIP sudah digunakan.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.max' => 'Jabatan maksimal 50 karakter.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
            'pengalaman.required' => 'Pengalaman wajib diisi.',
            'pengalaman.integer' => 'Pengalaman harus berupa angka.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'pendidikan_terakhir.max' => 'Pendidikan terakhir maksimal 100 karakter.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $data['gambar'] = $imageName;
        }

        Guru::create($data);
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function webUpdate(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:100',
            'nip' => 'required|max:20|unique:tblguru,nip,' . $id,
            'jabatan' => 'required|max:50',
            'mata_pelajaran' => 'required',
            'pengalaman' => 'required|integer',
            'pendidikan_terakhir' => 'required|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:200000',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.max' => 'NIP maksimal 20 karakter.',
            'nip.unique' => 'NIP sudah digunakan.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.max' => 'Jabatan maksimal 50 karakter.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
            'pengalaman.required' => 'Pengalaman wajib diisi.',
            'pengalaman.integer' => 'Pengalaman harus berupa angka.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'pendidikan_terakhir.max' => 'Pendidikan terakhir maksimal 100 karakter.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $data['gambar'] = $imageName;
        }

        $guru->update($data);
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function webDestroy($id)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    // API methods
    public function index(Request $request)
    {
        $search = $request->query('q');
        if ($search) {
            $gurus = Guru::where('nama', 'like', '%' . $search . '%')->get();
        } else {
            $gurus = Guru::all();
        }
        return response()->json($gurus);
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        return response()->json($guru);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:100',
            'nip' => 'required|max:20|unique:tblguru,nip',
            'jabatan' => 'required|max:50',
            'mata_pelajaran' => 'required',
            'pengalaman' => 'required|integer',
            'pendidikan_terakhir' => 'required|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:200000',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.max' => 'NIP maksimal 20 karakter.',
            'nip.unique' => 'NIP sudah digunakan.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.max' => 'Jabatan maksimal 50 karakter.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
            'pengalaman.required' => 'Pengalaman wajib diisi.',
            'pengalaman.integer' => 'Pengalaman harus berupa angka.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'pendidikan_terakhir.max' => 'Pendidikan terakhir maksimal 100 karakter.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $validated['gambar'] = $imageName;
        }

        $guru = Guru::create($validated);
        return response()->json(['message' => 'Data guru berhasil ditambahkan.', 'guru' => $guru]);
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|max:100',
            'nip' => 'required|max:20|unique:tblguru,nip,' . $id,
            'jabatan' => 'required|max:50',
            'mata_pelajaran' => 'required',
            'pengalaman' => 'required|integer',
            'pendidikan_terakhir' => 'required|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:200000',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.max' => 'NIP maksimal 20 karakter.',
            'nip.unique' => 'NIP sudah digunakan.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.max' => 'Jabatan maksimal 50 karakter.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
            'pengalaman.required' => 'Pengalaman wajib diisi.',
            'pengalaman.integer' => 'Pengalaman harus berupa angka.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'pendidikan_terakhir.max' => 'Pendidikan terakhir maksimal 100 karakter.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $validated['gambar'] = $imageName;
        }

        $guru->update($validated);
        return response()->json(['message' => 'Data guru berhasil diperbarui.', 'guru' => $guru]);
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return response()->json(['message' => 'Data guru berhasil dihapus.']);
    }

    //Cetak PDF
    public function cetakPDF()
    {
        $guru = Guru::all();
        $pdf = Pdf::loadView('pdf.cetakpengajar', compact('guru'));
        return $pdf->stream('data-pengajar.pdf');
    }
}
