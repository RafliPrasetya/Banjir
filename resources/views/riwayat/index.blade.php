@extends('layouts.app')

@section('content')

@php
    $beritaList = [
        [
            'img' => '/image/image4.jpg',
            'tanggal' => '21/07/2024',
            'judul' => 'Banjir Melanda Desa Kajaharjo, Infrastruktur Rusak',
            'isi' => 'Curah hujan ekstrem menyebabkan banjir besar di desa Kajaharjo, Kalibaru. Jembatan penghubung dan akses jalan terputus akibat derasnya arus air.',
        ],
        [
            'img' => '/image/image5.jpg',
            'tanggal' => '20/07/2024',
            'judul' => 'Evakuasi Warga Dipercepat di Kalibaru',
            'isi' => 'Banjir bandang memaksa warga mengungsi ke tempat yang lebih tinggi. Tim SAR dan relawan bergerak cepat menyelamatkan warga yang terjebak.',
        ],
        [
            'img' => '/image/image6.jpg',
            'tanggal' => '19/07/2024',
            'judul' => 'Sekolah Terendam, Proses Belajar Dihentikan',
            'isi' => 'Beberapa sekolah di Kalibaru diliburkan karena ruang kelas terendam. Dinas pendidikan menyiapkan pembelajaran daring sebagai alternatif.',
        ],
        [
            'img' => '/image/image7.jpg',
            'tanggal' => '18/07/2024',
            'judul' => 'Bantuan Logistik Mulai Disalurkan',
            'isi' => 'Pemerintah daerah mulai mendistribusikan logistik berupa makanan, air bersih, dan selimut kepada warga terdampak banjir di Kalibaru.',
        ],
    ];
@endphp

<style>
    .search-bar {
        margin: 50px 0 30px;
    }

    .search input {
        padding-left: 2.5rem;
    }

    .search i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .news-card {
        display: flex;
        align-items: center;
        margin-bottom: 60px;
        flex-wrap: wrap;
    }

    .news-card:nth-child(even) {
        flex-direction: row-reverse;
    }

    .news-image {
        flex: 1;
        min-width: 300px;
    }

    .news-image img {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .news-content {
        flex: 1;
        padding: 20px;
        max-width: 550px;
    }

    .news-content h5 {
        font-weight: bold;
        color: #6c757d;
    }

    .news-content h2 {
        font-weight: 700;
        margin-top: 10px;
        font-size: 1.8rem;
    }

    .news-content p {
        margin-top: 10px;
    }
</style>

{{-- Search --}}
<div class="container mt-5">
    <div class="row height d-flex justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="search">
                <i class="fa fa-search"></i>
                <input type="text" class="form-control" placeholder="Cari riwayat">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</div>

{{-- Daftar Berita --}}
<div class="container mt-5">
    @foreach($beritaList as $index => $berita)
        <div class="news-card">
            <div class="news-image">
                <img src="{{ url($berita['img']) }}" alt="Image">
            </div>
            <div class="news-content">
                <h5>Posted {{ $berita['tanggal'] }}</h5>
                <h2>{{ $berita['judul'] }}</h2>
                <p>{{ $berita['isi'] }}</p>
                <a href="{{ route('berita.show', ['id' => $index]) }}">
                    <button class="btn btn-primary mt-2">Continue reading</button>
                </a>
            </div>
        </div>
    @endforeach
</div>

@endsection
