@extends('layouts.app')

@section('content')

@php
    $notifikasiList = [
        [
            'tanggal' => '11 Desember 2023',
            'curah' => 'Curah hujan tinggi diprediksi akan berlangsung hingga 12 Des–13 Des.',
            'tinggi' => 'Ketinggian air di sungai Bomo telah mencapai tingkat yang mengkhawatirkan.',
            'risiko' => 'Risiko banjir tinggi di wilayah Wonosobo dan sekitarnya.',
        ],
        // Tambahkan item lagi jika perlu
        [
            'tanggal' => '11 Desember 2023',
            'curah' => 'Curah hujan tinggi diprediksi akan berlangsung hingga 12 Des–13 Des.',
            'tinggi' => 'Ketinggian air di sungai Bomo telah mencapai tingkat yang mengkhawatirkan.',
            'risiko' => 'Risiko banjir tinggi di wilayah Wonosobo dan sekitarnya.',
        ],
        [
            'tanggal' => '11 Desember 2023',
            'curah' => 'Curah hujan tinggi diprediksi akan berlangsung hingga 12 Des–13 Des.',
            'tinggi' => 'Ketinggian air di sungai Bomo telah mencapai tingkat yang mengkhawatirkan.',
            'risiko' => 'Risiko banjir tinggi di wilayah Wonosobo dan sekitarnya.',
        ],
    ];
@endphp

<style>
    .notifikasi-title {
        margin-left: 3%;
        margin-top: 5%;
    }

    .status-baca {
        position: absolute;
        top: 5.2%;
        right: 10%;
        color: rgb(12, 104, 223);
        font-weight: bold;
    }

    .card-notifikasi {
        width: 90%;
        margin: 10px auto;
        height: auto;
    }

    .card-notifikasi .card-body {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        position: relative;
    }

    .card-notifikasi img {
        margin-top: 6px;
        margin-left: 10pt;
    }

    .card-notifikasi .text-section {
        flex: 1;
    }

    .text-section p {
        margin-bottom: 4px;
        margin-left: 3pt;
    }

    .text-section .tanggal {
        color: blue;
    }

    .text-section a {
        position: absolute;
        bottom: 10px;
        right: 20px;
    }
</style>

<div class="mt-5">
    <h2 class="fw-bold notifikasi-title">Notifikasi</h2>
    <p class="status-baca">Sudah dibaca</p>
</div>

<div class="card-container mt-3">
    <div class="row w-100">
        <div class="col">
            @foreach($notifikasiList as $notif)
                <div class="card shadow-sm card-notifikasi">
                    <div class="card-body">
                        <img src="{{ url('/image/image10.png') }}" alt="Icon" width="40" />
                        <div class="text-section">
                            <p><b>Curah Hujan:</b> {{ $notif['curah'] }}</p>
                            <p><b>Ketinggian Air:</b> {{ $notif['tinggi'] }}</p>
                            <p><b>Risiko:</b> {{ $notif['risiko'] }}</p>
                            <p class="tanggal">{{ $notif['tanggal'] }}</p>
                            <a href="#">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
