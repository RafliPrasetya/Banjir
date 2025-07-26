@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <img src="{{ url($berita['img']) }}" alt="Image" class="img-fluid rounded mb-4 shadow" />
            <h5 class="text-muted">Posted {{ $berita['tanggal'] }}</h5>
            <h2 class="fw-bold">{{ $berita['judul'] }}</h2>
            <p class="mt-3">{{ $berita['isi_lengkap'] }}</p>

            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">← Kembali</a>
        </div>
    </div>
</div>

@endsection
