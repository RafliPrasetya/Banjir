@extends('admin.layout.base')

@section('content')
    <div class="container">
        <h3 class="mb-4">Data Bendungan</h3>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Tambah Bendungan --}}
        <form method="POST" action="{{ route('admin.bendungan.store') }}" class="mb-4">
            @csrf
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Bendungan" required>
                </div>
                <div class="col-md-5">
                    <select name="kecamatan_id" class="form-select" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </div>
            </div>
        </form>

        {{-- Tabel Bendungan --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Bendungan</th>
                    <th>Kecamatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bendungans as $index => $bendungan)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        {{-- Kolom Nama Bendungan --}}
                        <td>
                            @if (session('edit_id') == $bendungan->id)
                                <form action="{{ route('admin.bendungan.update', $bendungan->id) }}" method="POST"
                                    id="edit-form-{{ $bendungan->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="nama" value="{{ $bendungan->nama }}" class="form-control"
                                        required>
                                @else
                                    {{ $bendungan->nama }}
                            @endif
                        </td>

                        {{-- Kolom Kecamatan --}}
                        <td>
                            @if (session('edit_id') == $bendungan->id)
                                <select name="kecamatan_id" class="form-select" required>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}"
                                            {{ $bendungan->kecamatan_id == $kecamatan->id ? 'selected' : '' }}>
                                            {{ $kecamatan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                {{ $bendungan->kecamatan->nama }}
                            @endif
                        </td>

                        {{-- Tombol Aksi --}}
                        <td>
                            @if (session('edit_id') == $bendungan->id)
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                </form>
                                <a href="{{ route('admin.bendungan.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                            @else
                                <form method="POST" action="{{ route('admin.bendungan.editMode', $bendungan->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                                </form>
                            @endif

                            {{-- Tombol Hapus --}}
                            <form method="POST" action="{{ route('admin.bendungan.destroy', $bendungan->id) }}"
                                style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus bendungan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
