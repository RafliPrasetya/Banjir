<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    public function index()
    {
        return view('pengaduan.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'asal_kecamatan' => 'required|string|max:100',
            'bendungan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'pesan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['nama', 'asal_kecamatan', 'bendungan', 'no_hp', 'pesan']);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/foto_pengaduan'), $filename);
            $data['foto'] = 'uploads/foto_pengaduan/' . $filename;
        }

        try {
            Pengaduan::create($data);
            return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        // Pengaduan::create($request->only(['nama', 'asal_kecamatan', 'no_hp', 'pesan']));    

        // return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }
}

