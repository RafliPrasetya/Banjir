<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use Carbon\Carbon;

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
}
