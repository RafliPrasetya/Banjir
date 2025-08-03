@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h1 class="fw-bold">Selamat datang di website informasi banjir</h1>
                <p class="fw-light">
                    Ketahui kondisi banjir terkini, pelajari cara terbaik untuk mempersiapkan diri, dan temukan bantuan yang
                    Anda perlukan di saat darurat.
                    Kami berkomitmen untuk menjaga Anda tetap aman dengan informasi real-time dan panduan praktis. Bersama,
                    kita bisa menghadapi banjir dengan lebih siap dan tanggap.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{ url('/image/image2.jpg') }}" alt="Image Hero" class="img-fluid rounded shadow">
            </div>
        </div>

        <!-- Dampak Section -->
        <div class="row align-items-center flex-column-reverse flex-md-row">
            <div class="col-md-6 text-center">
                <img src="{{ url('/image/image1.jpg') }}" alt="Image Dampak" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6 mb-4 mb-md-0">
                <h1 class="fw-bold">Dampak banjir di Kajaharjo, Kalibaru</h1>
                <p class="fw-light">
                    Pada tahun 2023 banjir melanda di wilayah desa Kajaharjo, Kec. Kalibaru. Akibat curah hujan yang tinggi,
                    sungai di sekitar Kalibaru meluap dan menimbulkan kerusakan pada jembatan yang menghubungkan antar desa.
                </p>
                <a href="{{ route('riwayat') }}" class="btn btn-primary">Berita</a>
            </div>
        </div>
    </div>
@endsection
