@extends('admin.layout.base')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center fw-bold mb-4">Monitoring Beberapa Bendungan</h2>

        {{-- Filter Form --}}
        <div class="mb-4">
            <form action="{{ route('admin.monitoring.multi') }}" method="GET" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="kecamatan" class="form-label">Pilih Kecamatan</label>
                        <select name="kecamatan_id" id="kecamatan" class="form-select" onchange="fetchBendungan()">
                            <option value="">-- Semua Kecamatan --</option>
                            @foreach ($kecamatanList as $kecamatan)
                                <option value="{{ $kecamatan->id }}"
                                    {{ request('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>
                                    {{ $kecamatan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="bendungan" class="form-label">Pilih Bendungan (maks 5)</label>
                        <select name="bendungan_id[]" id="bendungan" class="form-select" multiple required>
                            {{-- Diisi via AJAX --}}
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Monitoring Cards --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($bendunganData as $bendungan)
                @php
                    $sensor = $bendungan->sensorTerbaru;
                    $statusClass = '';
                    $statusText = '';

                    if ($sensor && $sensor->ketinggian_air <= 1) {
                        $statusClass = 'bg-success text-white';
                        $statusText = 'Aman';
                    } elseif ($sensor && $sensor->ketinggian_air > 1 && $sensor->ketinggian_air <= 3) {
                        $statusClass = 'bg-warning';
                        $statusText = 'Waspada';
                    } elseif ($sensor) {
                        $statusClass = 'bg-danger text-white';
                        $statusText = 'Bahaya';
                    }
                @endphp

                <div class="col">
                    <div class="card shadow {{ $statusClass }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $bendungan->nama }} - <small>{{ $bendungan->kecamatan->nama }}</small>
                            </h5>

                            @if ($sensor)
                                <p>Suhu: {{ $sensor->suhu }}°C</p>
                                <p>Kelembapan: {{ $sensor->kelembapan }}%</p>
                                <p>Ketinggian Air: {{ $sensor->ketinggian_air }} cm</p>
                                <p class="small">Update:
                                    {{ \Carbon\Carbon::parse($sensor->tanggal)->format('d M Y H:i') }}</p>
                            @else
                                <p class="text-muted">Belum ada data sensor.</p>
                            @endif

                            <div class="fw-bold">Status: {{ $statusText }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function fetchBendungan() {
            const kecamatanId = document.getElementById('kecamatan').value;
            const bendunganSelect = document.getElementById('bendungan');
            bendunganSelect.innerHTML = '';

            if (!kecamatanId) return;

            fetch(`/admin/fetch-bendungan/${kecamatanId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(b => {
                        const option = document.createElement('option');
                        option.value = b.id;
                        option.text = b.nama;
                        bendunganSelect.appendChild(option);
                    });
                });
        }

        document.getElementById('bendungan').addEventListener('change', function() {
            if (this.selectedOptions.length > 5) {
                alert('Maksimal 5 bendungan!');
                for (let i = 5; i < this.selectedOptions.length; i++) {
                    this.selectedOptions[i].selected = false;
                }
            }
        });

        @if (request('kecamatan_id'))
            fetchBendungan();
        @endif
    </script>
@endpush
