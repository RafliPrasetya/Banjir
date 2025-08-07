<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bendungan;
use App\Models\Kecamatan;

class BendunganController extends Controller
{
    public function index()
    {
        $bendungans = Bendungan::with('kecamatan')->get();
        $kecamatans = Kecamatan::all();
        $edit_id = session('edit_id');

        return view('admin.bendungan.index', compact('bendungans', 'kecamatans', 'edit_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kecamatan_id' => 'required|exists:kecamatans,id',
        ]);

        Bendungan::create($request->only('nama', 'kecamatan_id'));

        return redirect()->route('admin.bendungan.index')->with('success', 'Bendungan berhasil ditambahkan.');
    }

    public function editMode($id)
    {
        session()->flash('edit_id', $id);
        return redirect()->route('admin.bendungan.index');
    }

    public function update(Request $request, $id)
    {
        $bendungan = Bendungan::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'kecamatan_id' => 'required|exists:kecamatans,id',
        ]);

        $bendungan->update($request->only('nama', 'kecamatan_id'));

        return redirect()->route('admin.bendungan.index')->with('success', 'Bendungan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bendungan = Bendungan::findOrFail($id);
        $bendungan->delete();

        return redirect()->route('admin.bendungan.index')->with('success', 'Bendungan berhasil dihapus.');
    }
}
