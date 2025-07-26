@extends('layouts.app')
@section('content')

<style>
    .status-info {
    padding: 20px 30px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 1.4rem;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.status-icon {
    font-size: 1.8rem;
}

.status-text {
    display: inline-block;
}

    .status-aman {
        background-color: #d4edda;
        color: #155724;
        animation: none;
    }

    .status-waspada {
        background-color: #fff3cd;
        color: #856404;
        animation: blink 1s infinite;
    }

    .status-bahaya {
        background-color: #f8d7da;
        color: #721c24;
        animation: blink-fast 0.5s infinite;
    }

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0.6; }
        100% { opacity: 1; }
    }

    @keyframes blink-fast {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }

    .card-monitor {
        min-width: 250px;
        max-width: 350px;
        flex: 1;
        width: 280px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        border-radius: 15px;
        transition: transform 0.3s ease;
        /* transition: transform 0.3s; */
    }

    .card-monitor:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        transform: translateY(-5px);
        transform: scale(1.02);
    }

    .card-monitor img {
        width: 80px;
        margin-bottom: 10px;
        object-fit: contain;
    }

    @media (max-width: 768px) {
        .card-monitor {
            max-width: 100%;
        }
    }
    #kecamatan {
    font-size: 1rem;
    padding: 8px 12px;
}

</style>
@php use Carbon\Carbon; @endphp

{{-- Dropdown Pilih Kecamatan --}}
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <label for="kecamatan" class="form-label fw-bold">Pilih Kecamatan</label>
            <select id="kecamatan" class="form-select">
                <option value="">-- Pilih Kecamatan --</option>
                <option value="Banyuwangi">Banyuwangi</option>
                <option value="Rogojampi">Rogojampi</option>
                <option value="Genteng">Genteng</option>
                <option value="Glenmore">Glenmore</option>
                <option value="Kalibaru">Kalibaru</option>
                <option value="Kabat">Kabat</option>
                <option value="Wongsorejo">Wongsorejo</option>
                <option value="Srono">Srono</option>
                <option value="Tegaldlimo">Tegaldlimo</option>
                <option value="Cluring">Cluring</option>
                <option value="Muncar">Muncar</option>
                <option value="Purwoharjo">Purwoharjo</option>
                <option value="Pesanggaran">Pesanggaran</option>
                <option value="Bangorejo">Bangorejo</option>
                <option value="Siliragung">Siliragung</option>
                <option value="Tegalsari">Tegalsari</option>
                <option value="Sempu">Sempu</option>
                <option value="Singojuruh">Singojuruh</option>
                <option value="Songgon">Songgon</option>
                <option value="Glagah">Glagah</option>
                <option value="Licin">Licin</option>
                <option value="Kalipuro">Kalipuro</option>
                <option value="Gambiran">Gambiran</option>
                <option value="Blimbingsari">Blimbingsari</option>
                <option value="Temurejo">Temurejo</option>
            </select>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4 fw-bold">Halaman Monitoring Suhu dan Ketinggian Air</h2>

    <div class="d-flex flex-wrap justify-content-center gap-4 mb-3">
        {{-- Kartu: Ketinggian Air --}}
        <div class="card card-monitor text-center p-4 shadow-sm">
            <img src="{{ asset('image/sea.png') }}" alt="Ketinggian" class="mx-auto mb-3" width="80">
            <h5 class="fw-semibold mb-1">Ketinggian Air</h5>
            <h2 id="ketinggian" class="fw-bold text-primary mb-1">{{ $sensor->ketinggian_air }} <span class="fs-5">cm</span></h2>
        <p class="tanggal text-muted small mb-0">
    {{ Carbon::parse($sensor->tanggal)->translatedFormat('d M Y') }}
</p>

        </div>

        {{-- Kartu: Suhu --}}
        <div class="card card-monitor text-center p-4 shadow-sm">
            <img src="{{ asset('image/image8.png') }}" alt="Suhu" class="mx-auto mb-3" width="80">
            <h5 class="fw-semibold mb-1">Suhu</h5>
            <h2 id="suhu" class="fw-bold text-danger mb-1">{{ $sensor->suhu }} <span class="fs-5">°C</span></h2>
          <p class="tanggal text-muted small mb-0">
    {{ Carbon::parse($sensor->tanggal)->translatedFormat('d M Y') }}
</p>

        </div>

        {{-- Kartu: Kelembapan --}}
        <div class="card card-monitor text-center p-4 shadow-sm">
            <img src="{{ asset('image/image9.png') }}" alt="Kelembapan" class="mx-auto mb-3" width="80">
            <h5 class="fw-semibold mb-1">Kelembapan</h5>
            <h2 id="kelembapan" class="fw-bold text-info mb-1">{{ $sensor->kelembapan }} <span class="fs-5">%</span></h2>
        <p class="tanggal text-muted small mb-0">
    {{ Carbon::parse($sensor->tanggal)->translatedFormat('d M Y') }}
</p>

        </div>
    </div>
</div>


@php
    $statusClass = '';
    $statusText = '';
    $statusIcon = '';

    if ($sensor->ketinggian_air <= 1) {
        $statusClass = 'status-aman';
        $statusText = 'Aman: Ketinggian air masih dalam batas normal.';
        $statusIcon = '✅';
    } elseif ($sensor->ketinggian_air > 1 && $sensor->ketinggian_air <= 2) {
        $statusClass = 'status-waspada';
        $statusText = 'Waspada! Ketinggian air mulai meningkat.';
        $statusIcon = '⚠️';
    } else {
        $statusClass = 'status-bahaya';
        $statusText = 'Bahaya! Ketinggian air sudah tinggi!';
        $statusIcon = '🚨';
    }
@endphp


<div id="statusBox" class="status-info {{ $statusClass }}">
    <span id="statusIcon" class="status-icon me-2">{{ $statusIcon }}</span>
    <span id="statusText" class="status-text">{{ $statusText }}</span>
</div>



{{-- Grafik dan Tabel Riwayat (Side-by-side, Responsive) --}}
<div class="row mt-4 g-4">
    {{-- Grafik --}}
    <div class="col-lg-6">
        <div class="card shadow h-100">
            <div class="card-body">
                <h5 class="card-title text-center mb-3 fw-bold">Grafik Sensor 7 Hari Terakhir</h5>
                <canvas id="sensorChart" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Tabel History --}}
    <div class="col-lg-6">
        <div class="card shadow h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold">Riwayat Data Sensor (10 Terakhir)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal/Jam</th>
                                <th>Suhu (°C)</th>
                                <th>Kelembapan (%)</th>
                                <th>Ketinggian Air (cm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historyData as $i => $data)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y H:i:s') }}</td>

                                <td>{{ $data->suhu }}</td>
                                <td>{{ $data->kelembapan }}</td>
                                <td>{{ $data->ketinggian_air }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    console.log('[DEBUG] Mulai fetchSensorData');
// ========== 1. Inisialisasi Grafik Sensor ==========


// Simpan referensi chart agar bisa diperbarui nantinya
let sensorChart;
const ctx = document.getElementById('sensorChart').getContext('2d');

// Inisialisasi grafik dengan data awal dari controller Blade
function initChart(labels, suhuData, kelembapanData, ketinggianData) {
    sensorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Suhu (°C)',
                    data: suhuData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255,99,132,0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Kelembapan (%)',
                    data: kelembapanData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Ketinggian Air (cm)',
                    data: ketinggianData,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Jalankan inisialisasi grafik saat pertama kali
initChart(
    @json($chartLabels),
    @json($chartSuhu),
    @json($chartKelembapan),
    @json($chartKetinggian)
);


// ========== 2. Fungsi untuk Meng-update Data Grafik ==========

function updateChartData(labels, suhuData, kelembapanData, ketinggianData) {
    if (!sensorChart) return;

    sensorChart.data.labels = labels;
    sensorChart.data.datasets[0].data = suhuData;
    sensorChart.data.datasets[1].data = kelembapanData;
    sensorChart.data.datasets[2].data = ketinggianData;
    sensorChart.update();
}


// ========== 3. Fetch Data Sensor dan Perbarui Halaman + Grafik ==========

async function fetchSensorData() {
    try {
        const response = await fetch('/api/sensor-terbaru');
        if (!response.ok) throw new Error('Gagal mengambil data sensor');

        const data = await response.json();

        // Update nilai kartu
        document.getElementById('suhu').innerHTML = `${data.suhu} <span class="fs-5">°C</span>`;
        document.getElementById('kelembapan').innerHTML = `${data.kelembapan} <span class="fs-5">%</span>`;
        document.getElementById('ketinggian').innerHTML = `${data.ketinggian_air} <span class="fs-5">cm</span>`;

        // Format tanggal lokal
        const tgl = new Date(data.tanggal);
        const formattedDate = tgl.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });

        // Update tanggal pada semua elemen dengan class .tanggal
        document.querySelectorAll('.tanggal').forEach(el => {
            el.textContent = formattedDate;
        });

        // Update status ketinggian air
        const statusBox = document.getElementById('statusBox');
        const statusText = document.getElementById('statusText');
        const statusIcon = document.getElementById('statusIcon');

        if (data.ketinggian_air < 10) {
            statusBox.className = 'status-info status-aman';
            statusText.textContent = 'Aman: Ketinggian air masih dalam batas normal.';
            statusIcon.textContent = '✅';
        } else if (data.ketinggian_air < 20) {
            statusBox.className = 'status-info status-waspada';
            statusText.textContent = 'Waspada! Ketinggian air mulai meningkat.';
            statusIcon.textContent = '⚠️';
        } else {
            statusBox.className = 'status-info status-bahaya';
            statusText.textContent = 'Bahaya! Ketinggian air sudah tinggi!';
            statusIcon.textContent = '🚨';
        }

        // Update grafik data terbaru
        const chartRes = await fetch('/api/sensor-chart');
        if (!chartRes.ok) throw new Error('Gagal mengambil data grafik');

        const chartData = await chartRes.json();
        updateChartData(chartData.labels, chartData.suhu, chartData.kelembapan, chartData.ketinggian);

    } catch (error) {
        console.error('[ERROR fetchSensorData]', error);
    }
}


// ========== 4. Jalankan Saat Halaman Dimuat dan Setiap 10 Detik ==========



// ========== 5. Fungsi untuk Refresh Tabel History ==========
async function refreshHistoryTable() {
    try {
        const response = await fetch('/api/sensor-history');
        const data = await response.json();
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';

        data.forEach((item, index) => {
            const date = new Date(item.tanggal);
            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    })}</td>
                    <td>${item.suhu}</td>
                    <td>${item.kelembapan}</td>
                    <td>${item.ketinggian_air}</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    } catch (error) {
        console.error("Gagal ambil history: ", error);
    }
}

// ========== 6. Menjalankan auto-refresh setiap detik ==========

fetchSensorData();
refreshHistoryTable();
setInterval(() => {
    fetchSensorData();
    refreshHistoryTable();
}, 5000);

console.log('[DEBUG] Selesai fetchSensorData');
</script>
@endpush
