<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::all();
        $edit_id = session('edit_id'); // ambil edit id dari session flash
        return view('admin.kecamatan.index', compact('kecamatans', 'edit_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kecamatans,nama'
        ]);

        Kecamatan::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function editMode($id)
    {
        // Simpan ID edit sementara ke session flash
        session()->flash('edit_id', $id);
        return redirect()->route('admin.kecamatan.index');
    }

    public function update(Request $request, $id)
    {
        $kecamatan = Kecamatan::findOrFail($id);

        $request->validate([
            'nama' => 'required|unique:kecamatans,nama,' . $kecamatan->id
        ]);

        $kecamatan->update(['nama' => $request->nama]);

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->delete();

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil dihapus.');
    }
}
