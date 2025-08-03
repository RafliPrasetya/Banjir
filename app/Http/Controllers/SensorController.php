<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use Carbon\Carbon;

class SensorController extends Controller
{
    /**
     * Ambil data sensor terbaru.
     */
    public function getLatest()
    {
        $sensor = Sensor::latest()->first();

        if (!$sensor) {
            return response()->json(['message' => 'Data sensor tidak ditemukan'], 404);
        }

        return response()->json([
            'tanggal' => Carbon::parse($sensor->tanggal)->toDateString(),
            'suhu' => $sensor->suhu,
            'kelembapan' => $sensor->kelembapan,
            'ketinggian_air' => $sensor->ketinggian_air
        ]);
    }

    /**
     * Simpan data sensor baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan' => 'required|numeric',
            'ketinggian_air' => 'required|numeric',
            'tanggal' => 'nullable|date',
        ]);

        $validated['tanggal'] = $validated['tanggal'] ?? now();

        $sensor = Sensor::create($validated);

        return response()->json([
            'message' => 'Data sensor berhasil disimpan',
            'data' => $sensor
        ], 200);
    }

    /**
     * Ambil 10 data sensor terakhir untuk riwayat tabel.
     */
    public function getSensorHistory()
    {
        $history = Sensor::latest('tanggal')
            ->limit(10)
            ->get(['tanggal', 'suhu', 'kelembapan', 'ketinggian_air']);

        // Format tanggal menjadi ISO agar aman diparse JS
        $formatted = $history->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->tanggal)->toIso8601String(),
                'suhu' => $item->suhu,
                'kelembapan' => $item->kelembapan,
                'ketinggian_air' => $item->ketinggian_air,
            ];
        });

        return response()->json($formatted);
    }
    /**
     * Ambil data untuk grafik sensor 7 hari terakhir.
     */
    public function getChartData()
    {
        $data = Sensor::where('tanggal', '>=', now()->subDays(6))
            ->orderBy('tanggal')
            ->get();

        return response()->json([
            'labels' => $data->pluck('tanggal')->map(
                fn($tgl) =>
                Carbon::parse($tgl)->translatedFormat('d M')
            ),
            'suhu' => $data->pluck('suhu'),
            'kelembapan' => $data->pluck('kelembapan'),
            'ketinggian' => $data->pluck('ketinggian_air'),
        ]);
    }
}
