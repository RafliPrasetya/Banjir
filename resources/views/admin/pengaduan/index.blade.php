@extends('admin.layout.base')

@section('title', 'Manajemen Pengaduan')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Manajemen Pengaduan</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kecamatan</th>
                                <th>Bendungan</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengaduan as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->kecamatan->nama ?? '-' }}</td>
                                    <td>{{ $item->bendungan->nama ?? '-' }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge rounded-pill {{ $item->status == 'Sudah Ditanggapi' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#detailModal"
                                                onclick='showDetail(@json($item))'>
                                                <i class="fas fa-eye"></i> Lihat
                                            </button>

                                            <form action="{{ route('pengaduan.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada pengaduan yang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="responForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="pengaduanId">

                        <div class="mb-3">
                            <strong>Nama:</strong> <span id="namaPengadu"></span><br>
                            <strong>No. HP:</strong> <span id="nohpPengadu"></span><br>
                            <strong>Kecamatan:</strong> <span id="kecamatanPengadu"></span><br>
                            <strong>Bendungan:</strong> <span id="bendunganPengadu"></span><br>
                            <strong>Waktu:</strong> <span id="waktuPengadu"></span>
                        </div>

                        <div class="mb-3">
                            <strong>Pesan:</strong>
                            <p id="pesanPengadu" class="mt-1 border rounded p-2 bg-light"></p>
                        </div>

                        <div class="mb-3">
                            <strong>Foto:</strong><br>
                            <img id="fotoPengadu" src="" class="img-fluid rounded shadow-sm mt-2"
                                style="max-height:300px; cursor:pointer;" alt="foto pengaduan"
                                onclick="previewFoto(this.src)">
                            <div class="mt-2">
                                <a id="downloadFotoBtn" href="#" class="btn btn-sm btn-outline-primary" download
                                    target="_blank">
                                    <i class="fas fa-download me-1"></i> Unduh Foto
                                </a>
                            </div>
                        </div>

                        <div class="mb-3" id="responSection">
                            <!-- Akan diisi dinamis oleh JS -->
                        </div>
                    </div>

                    <div class="modal-footer" id="modalFooter">
                        <!-- Dikosongkan untuk isi dinamis -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview Gambar -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0 position-relative">
                <div class="modal-body text-center p-0">
                    <img id="previewImage" src="" class="img-fluid rounded shadow" alt="preview"
                        style="max-height:90vh;">

                    <!-- Tombol Tutup (Cancel) -->
                    <button type="button" class="btn btn-light position-absolute top-0 end-0 m-3 shadow"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function showDetail(data) {
            console.log(data);

            document.getElementById('pengaduanId').value = data.id;
            document.getElementById('namaPengadu').innerText = data.nama;
            document.getElementById('nohpPengadu').innerText = data.no_hp ?? '-';
            document.getElementById('kecamatanPengadu').innerText = data.kecamatan?.nama ?? '-';
            document.getElementById('bendunganPengadu').innerText = data.bendungan?.nama ?? '-';
            document.getElementById('waktuPengadu').innerText = new Date(data.created_at).toLocaleString('id-ID');
            document.getElementById('pesanPengadu').innerText = data.pesan;

            const fotoTag = document.getElementById('fotoPengadu');
            const downloadLink = document.getElementById('downloadFotoBtn');
            if (data.foto) {
                const fullPath = `/${data.foto}`;
                fotoTag.src = fullPath;
                fotoTag.style.display = 'block';
                downloadLink.href = fullPath;
                downloadLink.style.display = 'inline-block';
            } else {
                fotoTag.style.display = 'none';
                downloadLink.style.display = 'none';
            }

            const responSection = document.getElementById('responSection');
            const modalFooter = document.getElementById('modalFooter');
            const responForm = document.getElementById('responForm');
            modalFooter.innerHTML = '';
            responForm.action = `/admin/pengaduan/${data.id}/respon`;

            if (data.status === 'Belum Ditanggapi') {
                responSection.innerHTML = `
                <label for="respon" class="form-label"><strong>Tulis Respon:</strong></label>
                <textarea name="respon" class="form-control" rows="3" required></textarea>
            `;
                modalFooter.innerHTML = `
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-1"></i> Kirim Respon
                </button>
            `;
            } else {
                responSection.innerHTML = `
                <label class="form-label"><strong>Respon:</strong></label>
                <textarea name="respon" class="form-control" rows="3">${data.respon}</textarea>
            `;
                modalFooter.innerHTML = `
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-edit me-1"></i> Update Respon
                </button>
                <a href="/admin/pengaduan/${data.id}/hapus-respon" class="btn btn-danger" onclick="return confirm('Yakin ingin hapus respon ini?')">
                    <i class="fas fa-trash me-1"></i> Hapus Respon
                </a>
            `;
            }
        }

        function previewFoto(src) {
            const previewImage = document.getElementById('previewImage');
            previewImage.src = src;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        }
    </script>
@endpush
