<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Kecamatan;

class PengaduanController extends Controller
{
    // Menampilkan halaman pengaduan + form + riwayat
    public function index()
    {
        $riwayat = Pengaduan::with(['kecamatan', 'bendungan'])->orderBy('created_at', 'desc')->get();
        $kecamatans = Kecamatan::with('bendungans')->get();
        return view('pengaduan.index', compact('riwayat', 'kecamatans'));
    }

    // Simpan pengaduan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'bendungan_id' => 'required|exists:bendungans,id',
            'no_hp' => 'required',
            'pesan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename =  time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/foto_pengaduan'), $filename);
            $fotoPath = 'uploads/foto_pengaduan/' . $filename;
        } else {
            $fotoPath = null;
        }

        // Simpan ke database
        Pengaduan::create([
            'nama' => $request->nama,
            'kecamatan_id' => $request->kecamatan_id,
            'bendungan_id' => $request->bendungan_id,
            'no_hp' => $request->no_hp,
            'pesan' => $request->pesan,
            'foto' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hapus foto jika ada
        if ($pengaduan->foto && file_exists(public_path($pengaduan->foto))) {
            unlink(public_path($pengaduan->foto));
        }

        $pengaduan->delete();

        return redirect()->back()->with('success', 'Pengaduan berhasil dihapus.');
    }

    // Halaman admin lihat semua pengaduan
    public function indexAdmin()
    {
        $pengaduan = Pengaduan::with(['kecamatan', 'bendungan'])->latest()->get();
        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    // Admin beri respon ke pengaduan
    public function beriRespon(Request $request, $id)
    {
        $request->validate([
            'respon' => 'required|string'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update([
            'status' => 'Sudah Ditanggapi',
            'respon' => $request->respon
        ]);

        return redirect()->route('admin.pengaduan.index')->with('success', 'Respon berhasil dikirim!');
    }

    // Versi respon alternatif
    public function respon(Request $request, $id)
    {
        $data = Pengaduan::findOrFail($id);
        $data->respon = $request->respon;
        $data->status = 'Sudah Ditanggapi';
        $data->save();

        return back()->with('success', 'Respon berhasil dikirim.');
    }

    // Hapus respon
    public function hapusRespon($id)
    {
        $data = Pengaduan::findOrFail($id);
        $data->respon = null;
        $data->status = 'Belum Ditanggapi';
        $data->save();

        return back()->with('success', 'Respon berhasil dihapus.');
    }
}
