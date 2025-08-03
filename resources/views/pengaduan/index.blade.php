@extends('layouts.app')

@section('content')

<style>
      .notifikasi-title {
        margin-top: 3%;
    }
</style>

<div class="container">
    <h2 class="fw-bold mb-4 notifikasi-title">Form Pengaduan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="mb-3">
            <label for="asal_kecamatan" class="form-label">Pilih Kecamatan</label>
            <select id="asal_kecamatan" name="asal_kecamatan" class="form-select" required>
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

        
        <!-- Tambah Bendungan terintegrasi dengan filter kecamatan -->
         <div class= "mb-3">
            <label for="bendungan" class="form-label">Pilih Bendungan</label>
            <select id="bendungan" name="bendungan" class="form-select" required>
                <option value="">-- Pilih Bendungan --</option>
                <option value="Kali A">Kali A</option>
                <option value="Kali B">Kali B</option>
                <option value="Kali C">Kali C</option>
                <option value="Kali D">Kali D</option>
                <option value="Kali E">Kali E</option>
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
            <img id="previewImage" style="max-width: 200px; margin-top: 10px; display: none;" alt="Preview Gambar"/>
        </div>



        <button type="submit" class="btn btn-primary mt-2">Kirim Pengaduan</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('foto_pengaduan');
        const preview = document.getElementById('previewImage');

        input.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });

        
        const alertSuccess = document.querySelector('.alert-success');
        const alertError = document.querySelector('.alert-danger');
        if (alertSuccess) {
            setTimeout(() => alertSuccess.style.display = 'none', 5000);
        }
        if (alertError) {
            setTimeout(() => alertError.style.display = 'none', 5000);
        }
    });
</script>
@endpush

