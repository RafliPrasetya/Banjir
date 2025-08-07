@extends('layouts.app')

@section('content')
    <style>
        .notifikasi-title {
            margin-top: 3%;
        }

        .custom-thead {
            background-color: #4e73df !important;
            color: white !important;
        }
    </style>

    <div class="container">
        <h2 class="fw-bold mb-4 notifikasi-title">Form Pengaduan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
                <label for="kecamatan" class="form-label">Pilih Kecamatan</label>
                <select id="kecamatan" name="kecamatan_id" class="form-select" required>
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="bendungan" class="form-label">Pilih Bendungan</label>
                <select id="bendungan" name="bendungan_id" class="form-select" required>
                    <option value="">-- Pilih Bendungan --</option>
                    {{-- Option akan terisi otomatis via JS --}}
                </select>
            </div>


            <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP</label>
                <input type="number" class="form-control" id="no_hp" name="no_hp" required>
            </div>

            <div class="mb-3">
                <label for="pesan" class="form-label">Pesan Pengaduan</label>
                <textarea class="form-control" id="pesan" name="pesan" rows="4" required></textarea>
            </div>


            <!-- Tambah foto -->
            <div class="mb-3">
                <label for="foto_pengaduan" class="form-label">Foto Pengaduan</label>
                <input class="form-control" type="file" id="foto_pengaduan" name="foto" accept="image/*">
            </div>

            <!-- Preview Foto -->
            <div class="mb-3">
                <img id="previewImage" style="max-width: 200px; margin-top: 10px; display: none;" alt="Preview Gambar" />
            </div>

            <button type="submit" class="btn btn-primary mt-2">Kirim Pengaduan</button>
        </form>
        @if (!empty($riwayat) && $riwayat->count() > 0)
            <div class="card shadow mb-4 mt-5">
                <div class="card-body">
                    <h1 class="h4 mb-4 text-gray-800 fw-bold">Riwayat Pengaduan</h1>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped align-middle small text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kecamatan</th>
                                    <th>Bendungan</th>
                                    <th>Pesan</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th>Respon</th>
                                    <th>Dikirim Pada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayat as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->kecamatan->nama ?? '-' }}</td>
                                        <td>{{ $item->bendungan->nama ?? '-' }}</td>
                                        <td class="text-wrap text-start" style="max-width: 200px;">{{ $item->pesan }}</td>
                                        <td>
                                            @if ($item->foto)
                                                @php
                                                    $fotoUrl = asset(
                                                        'uploads/foto_pengaduan/' . rawurlencode(basename($item->foto)),
                                                    );
                                                @endphp
                                                <img src="{{ $fotoUrl }}" alt="foto" width="80"
                                                    class="img-thumbnail rounded" style="cursor: zoom-in;"
                                                    onclick="previewFoto('{{ $fotoUrl }}')">
                                            @else
                                                <em class="text-muted">Tidak ada</em>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $item->status == 'Sudah Ditanggapi' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="text-wrap text-start" style="max-width: 200px;">
                                            {{ $item->respon ?? '-' }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Preview Gambar -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-light bg-opacity-75 position-relative rounded">
                <div class="modal-body text-center p-0">
                    <img id="previewModalImage" src="" class="img-fluid rounded shadow" alt="preview"
                        style="max-height:90vh;">
                    <button type="button" class="btn btn-light position-absolute top-0 end-0 m-3 shadow"
                        data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 🔍 Preview gambar saat upload
            const inputFoto = document.getElementById('foto_pengaduan');
            const previewImage = document.getElementById('previewImage');

            if (inputFoto && previewImage) {
                inputFoto.addEventListener('change', function() {
                    const file = this.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewImage.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        previewImage.src = '';
                        previewImage.style.display = 'none';
                    }
                });
            }

            // ✅ Auto-hide alert success and error after 5 seconds
            const alertSuccess = document.querySelector('.alert-success');
            const alertError = document.querySelector('.alert-danger');

            if (alertSuccess) {
                setTimeout(() => alertSuccess.style.display = 'none', 5000);
            }

            if (alertError) {
                setTimeout(() => alertError.style.display = 'none', 5000);
            }

            // 🔁 Populate Bendungan berdasarkan Kecamatan
            const kecamatanData = @json($kecamatans);
            const kecamatanSelect = document.getElementById('kecamatan');
            const bendunganSelect = document.getElementById('bendungan');

            if (kecamatanSelect && bendunganSelect) {
                kecamatanSelect.addEventListener('change', function() {
                    const selectedId = this.value;

                    // Reset bendungan dropdown
                    bendunganSelect.innerHTML = '<option value="">-- Pilih Bendungan --</option>';

                    if (selectedId) {
                        const selectedKecamatan = kecamatanData.find(k => k.id == selectedId);
                        if (selectedKecamatan && selectedKecamatan.bendungans.length > 0) {
                            selectedKecamatan.bendungans.forEach(b => {
                                const option = document.createElement('option');
                                option.value = b.id;
                                option.textContent = b.nama;
                                bendunganSelect.appendChild(option);
                            });
                        }
                    }
                });
            }
        });

        // 📸 Preview gambar dari tabel riwayat (bukan input file)
        function previewFoto(url) {
            console.log("Preview src:", url);
            const image = document.getElementById('previewModalImage');
            image.src = url + '?t=' + new Date().getTime();
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }
    </script>
@endpush
