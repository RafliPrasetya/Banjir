@extends('admin.layout.base')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboardAdmin.css') }}">

    </style>
    @php use Carbon\Carbon; @endphp
    {{-- Dropdown Pilih Kecamatan --}}
    <div class="container mt-4 mb-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <label for="kecamatan" class="form-label fw-bold">Pilih Kecamatan</label>
                <select id="kecamatan" class="form-select">
                    <option value="">-- Pilih Kecamatan --</option>
                    {{-- Daftar Kecamatan --}}
                    @php
                        $kecamatanList = [
                            'Banyuwangi',
                            'Rogojampi',
                            'Genteng',
                            'Glenmore',
                            'Kalibaru',
                            'Kabat',
                            'Wongsorejo',
                            'Srono',
                            'Tegaldlimo',
                            'Cluring',
                            'Muncar',
                            'Purwoharjo',
                            'Pesanggaran',
                            'Bangorejo',
                            'Siliragung',
                            'Tegalsari',
                            'Sempu',
                            'Singojuruh',
                            'Songgon',
                            'Glagah',
                            'Licin',
                            'Kalipuro',
                            'Gambiran',
                            'Blimbingsari',
                            'Temurejo',
                        ];
                    @endphp
                    @foreach ($kecamatanList as $kec)
                        <option value="{{ $kec }}">{{ $kec }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Judul & Kartu --}}
    <div class="container my-5">
        <h2 class="text-center mb-4 fw-bold">Dashboard Admin Monitoring Sensor</h2>
        <div class="d-flex flex-wrap justify-content-center gap-4 mb-3">

            {{-- Ketinggian Air --}}
            <div class="card card-monitor">
                <img src="{{ asset('image/sea.png') }}" alt="Ketinggian Air">
                <h5>Ketinggian Air</h5>
                <h2 id="ketinggian" class="text-primary">
                    {{ $sensor->ketinggian_air }} <span class="fs-5">cm</span>
                </h2>
                <p class="tanggal">
                    {{ \Carbon\Carbon::parse($sensor->tanggal)->translatedFormat('d M Y') }}
                </p>
            </div>

            {{-- Suhu --}}
            <div class="card card-monitor">
                <img src="{{ asset('image/image8.png') }}" alt="Suhu">
                <h5>Suhu</h5>
                <h2 id="suhu" class="text-danger">
                    {{ $sensor->suhu }} <span class="fs-5">°C</span>
                </h2>
                <p class="tanggal">
                    {{ \Carbon\Carbon::parse($sensor->tanggal)->translatedFormat('d M Y') }}
                </p>
            </div>

            {{-- Kelembapan --}}
            <div class="card card-monitor">
                <img src="{{ asset('image/image9.png') }}" alt="Kelembapan">
                <h5>Kelembapan</h5>
                <h2 id="kelembapan" class="text-info">
                    {{ $sensor->kelembapan }} <span class="fs-5">%</span>
                </h2>
                <p class="tanggal">
                    {{ \Carbon\Carbon::parse($sensor->tanggal)->translatedFormat('d M Y') }}
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
        } elseif ($sensor->ketinggian_air > 1 && $sensor->ketinggian_air <= 3) {
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
    <div class="row g-4 mt-4">
        {{-- Grafik --}}
        <div class="col-lg-6">
            <div class="card shadow h-100 d-flex flex-column">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center mb-3 fw-bold">Grafik Sensor 7 Hari Terakhir</h5>
                    <div class="flex-grow-1 position-relative">
                        <canvas id="sensorChart" class="w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel History --}}
        <div class="col-lg-6">
            <div class="card shadow h-100 d-flex flex-column">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center mb-3 fw-bold">Riwayat Data Sensor (10 Terakhir)</h5>
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-bordered text-center mb-0">
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
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y H:i:s') }}
                                        </td>
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

<script>
    window.chartInitData = {
        labels: @json($chartLabels),
        suhu: @json($chartSuhu),
        kelembapan: @json($chartKelembapan),
        ketinggian: @json($chartKetinggian)
    };
</script>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/monitoringDasboardAdmin.js') }}"></script>
@endpush
