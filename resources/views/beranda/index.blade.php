@extends('layouts.app')
@section('content')
    <div class="container">
    <div class="d-flex justify-content-end mb-5">
        <div class="container d-flex align-items-center" style="height: 70vh;">
            <div class="text-left">
                <h1 class="fw-bolder">Selamat datang di website informasi banjir</h1>
                <p class="fw-light">Ketahui kondisi banjir terkini, pelajari cara terbaik untuk mempersiapkan diri, dan temukan bantuan yang Anda perlukan di saat darurat. Kami berkomitmen untuk menjaga Anda tetap aman dengan informasi real-time dan panduan praktis. Bersama, kita bisa menghadapi banjir dengan lebih siap dan tanggap.</p>
            </div>
            <div class="image">
                <img src="{{url('/image/image2.jpg')}}" alt="Image" width="600"/>
            </div>   
        </div>
    </div>
      
    </div>
    <div class="container ">
    <div class="d-flex justify-content-start mb-5">
        <div class="container d-flex align-items-center justify-content-end" style="height: 70vh;">
            <div class="image">
                <img src="{{url('/image/image1.jpg')}}" alt="Image" width="600"/>
            </div>
            <div class="text-left">
                <h1 class="fw-bolder">Dampak banjir di kajaharjo, kalibaru</h1>
                <p class="fw-light">Pada tahun 2023 banjir melanda di wilayah desa kajaharjo kec. Kalibaru, akibat curah hujan yang tinggi sungai di sekitar kecamatan kalibaru meluap dan menimbulkan kerusakan pada jembatan yang menghubungkan antar desa ke desa.</p>
                <a href="{{ route('riwayat') }}">
                <button type="button" class="btn btn-primary shadowed-image">Berita</button>
            </div>
        </div>
    </div>
    </div>
@endsection
