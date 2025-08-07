<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Kecamatan;
use App\Models\Bendungan;
use App\Models\Sensor;

class MonitoringController extends Controller
{
    public function index()
    {
        $sensor = $this->getLatestSensor();

        $history = $this->getChartHistory(7);
        $historyData = $this->getHistoryTable(10);

        return view('monitoring.index', [
            'sensor' => $sensor,
            'chartLabels' => $this->getChartLabels($history),
            'chartSuhu' => $history->pluck('suhu')->toArray(),
            'chartKelembapan' => $history->pluck('kelembapan')->toArray(),
            'chartKetinggian' => $history->pluck('ketinggian_air')->toArray(),
            'historyData' => $historyData
        ]);
    }

    /**
     * Ambil data sensor terbaru
     */
    private function getLatestSensor(): ?Sensor
    {
        return Sensor::latest('tanggal')->first();
    }

    /**
     * Ambil data untuk chart
     */
    private function getChartHistory(int $limit)
    {
        return Sensor::orderBy('tanggal', 'asc')->take($limit)->get();
    }

    /**
     * Ambil data untuk tabel history
     */
    private function getHistoryTable(int $limit)
    {
        return Sensor::orderBy('tanggal', 'desc')->take($limit)->get();
    }

    /**
     * Format label tanggal untuk chart
     */
    private function getChartLabels($history): array
    {
        return $history->pluck('tanggal')->map(function ($tanggal) {
            return Carbon::parse($tanggal)->format('Y-m-d');
        })->toArray();
    }

    public function multiLokasi(Request $request)
    {
        $kecamatanList = Kecamatan::all();
        $bendunganQuery = Bendungan::with('kecamatan', 'sensorTerbaru');

        if ($request->filled('bendungan_id')) {
            $bendunganQuery->whereIn('id', $request->bendungan_id);
        }

        $bendunganData = $bendunganQuery->get();

        return view('admin.monitoring.multi', compact('bendunganData', 'kecamatanList'));
    }

    public function fetchBendungan($id)
    {
        $bendungan = Bendungan::where('kecamatan_id', $id)->get(['id', 'nama']);
        return response()->json($bendungan);
    }
    public function getChartDetail($id)
    {
        $sensor = Sensor::where('bendungan_id', $id)
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get()
            ->reverse();

        return response()->json([
            'labels' => $sensor->pluck('tanggal')->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->format('d M H:i')),
            'ketinggian' => $sensor->pluck('ketinggian_air'),
        ]);
    }
}
