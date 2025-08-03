<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sensor;
use Illuminate\Http\Request;

class AdminController extends Controller
{


    public function dashboard(Request $request)
    {
        $kecamatan = $request->kecamatan;

        // Query dasar
        $query = Sensor::query();

        // Jika ada filter kecamatan
        if ($kecamatan) {
            $query->where('kecamatan', $kecamatan);
        }

        // Data sensor terbaru (kartu informasi)
        $sensor = $query->latest()->first();

        // Riwayat data (untuk tabel)
        $historyData = $query->latest()->take(10)->get();

        // Data chart 7 hari terakhir
        $chartData = Sensor::whereDate('tanggal', '>=', Carbon::now()->subDays(6))
            ->when($kecamatan, fn($q) => $q->where('kecamatan', $kecamatan))
            ->orderBy('tanggal')
            ->get();

        $chartLabels = $chartData->pluck('tanggal')
            ->map(fn($tgl) => Carbon::parse($tgl)->translatedFormat('d M'));

        $chartSuhu = $chartData->pluck('suhu');
        $chartKelembapan = $chartData->pluck('kelembapan');
        $chartKetinggian = $chartData->pluck('ketinggian_air');

        return view('admin.dashboard', compact(
            'sensor',
            'historyData',
            'chartLabels',
            'chartSuhu',
            'chartKelembapan',
            'chartKetinggian'
        ));
    }
}
