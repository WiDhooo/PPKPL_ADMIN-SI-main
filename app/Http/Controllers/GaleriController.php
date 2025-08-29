<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GaleriController extends Controller
{
    // Web methods
    public function webIndex(Request $request)
    {
        $search = $request->query('q');
        if ($search) {
            $galeris = Galeri::where('judul', 'like', '%' . $search . '%')->get();
        } else {
            $galeris = Galeri::all();
        }
        return view('ADMIN-SI.akademik', compact('galeris', 'search'));
    }

    public function webGaleri()
    {
        $galeris = Galeri::select('gambar', 'judul', 'deskripsi')->get();
        return view('galeri', compact('galeris'));
    }

    public function webCreate()
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        return view('galeri.create');
    }

    public function webShow($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('galeri.show', compact('galeri'));
    }

    public function webEdit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('galeri.edit', compact('galeri'));
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
            'judul' => 'required|string|max:30',
            'deskripsi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'judul.max' => 'Judul maksimal 30 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $data['gambar'] = $imageName;
        }

        Galeri::create($data);
        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil ditambahkan.');
    }

    public function webUpdate(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:30',
            'deskripsi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'judul.max' => 'Judul maksimal 30 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $data['gambar'] = $imageName;
        }

        $galeri->update($data);
        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil diperbarui.');
    }

    public function webDestroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil dihapus.');
    }

    // API methods
    public function index(Request $request)
    {
        $search = $request->query('q');
        if ($search) {
            $galeris = Galeri::where('judul', 'like', '%' . $search . '%')->get();
        } else {
            $galeris = Galeri::all();
        }

        return response()->json($galeris);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:30',
            'deskripsi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'judul.max' => 'Judul maksimal 30 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
        ]);

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $validated['gambar'] = $imageName;
        }

        Galeri::create($validated);

        return response()->json(['message' => 'Galeri created successfully.']);
    }

    public function show(Galeri $galeri)
    {
        return response()->json($galeri);
    }

    public function update(Request $request, Galeri $galeri)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:30',
            'deskripsi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'judul.max' => 'Judul maksimal 30 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
        ]);

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $imageName);
            $validated['gambar'] = $imageName;
        }

        $galeri->update($validated);

        return response()->json(['message' => 'Galeri updated successfully.']);
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();

        return response()->json(['message' => 'Galeri deleted successfully.']);
    }

    // Custom method fotokegiatan remains unchanged
    public function fotokegiatan(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin() === false) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini.');

            // Redirect ke halaman sebelumnya
            return redirect()->back();
        }
        $sort = $request->query('sort');
        $search = $request->query('search');

        $query = Galeri::query();

        if ($search) {
            $query->where('judul', 'like', '%' . $search . '%');
        }

        if ($sort === 'judul_asc') {
            $query->orderBy('judul', 'asc');
        } elseif ($sort === 'judul_desc') {
            $query->orderBy('judul', 'desc');
        } elseif ($sort === 'tanggal_asc') {
            $query->orderBy('tanggal', 'asc');
        } elseif ($sort === 'tanggal_desc') {
            $query->orderBy('tanggal', 'desc');
        }

        $galeris = $query->paginate(5);

        return view('ADMIN-SI.fotokegiatan', compact('galeris'));
    }
}
