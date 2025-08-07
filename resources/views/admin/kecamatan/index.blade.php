@extends('admin.layout.base')

@section('content')
    <div class="container">
        <h3>Data Kecamatan</h3>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Form Tambah Kecamatan --}}
        <form method="POST" action="{{ route('admin.kecamatan.store') }}">
            @csrf
            <input type="text" name="nama" class="form-control" placeholder="Nama Kecamatan" required>
            <button type="submit" class="btn btn-primary mt-2">Tambah</button>
        </form>

        {{-- Tabel Kecamatan --}}
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kecamatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kecamatans as $index => $kecamatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($edit_id == $kecamatan->id)
                                <form id="edit-form-{{ $kecamatan->id }}"
                                    action="{{ route('admin.kecamatan.update', $kecamatan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="nama" class="form-control" value="{{ $kecamatan->nama }}"
                                        required>
                                </form>
                            @else
                                {{ $kecamatan->nama }}
                            @endif
                        </td>
                        <td>
                            @if ($edit_id == $kecamatan->id)
                                <button type="submit" form="edit-form-{{ $kecamatan->id }}"
                                    class="btn btn-success btn-sm">Simpan</button>
                                <a href="{{ route('admin.kecamatan.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                            @else
                                <form method="POST" action="{{ route('admin.kecamatan.editMode', $kecamatan->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.kecamatan.destroy', $kecamatan->id) }}"
                                style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kecamatan ini?')">
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
