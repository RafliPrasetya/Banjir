<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function show($id)
    {
        $beritaList = [
            [
                'img' => '/image/image4.jpg',
                'tanggal' => '21/07/2024',
                'judul' => 'Banjir Melanda Desa Kajaharjo, Infrastruktur Rusak',
                'isi_lengkap' => 'Curah hujan ekstrem menyebabkan banjir besar di desa Kajaharjo. Rumah warga tergenang, akses jalan terputus, dan jembatan utama roboh. Pemerintah daerah menetapkan status siaga banjir dan mengerahkan BPBD serta relawan.',
            ],
            [
                'img' => '/image/image5.jpg',
                'tanggal' => '20/07/2024',
                'judul' => 'Evakuasi Warga Dipercepat di Kalibaru',
                'isi_lengkap' => 'Tim SAR dan relawan melakukan evakuasi terhadap warga yang rumahnya terendam. Bantuan berupa makanan, obat-obatan, dan pakaian telah disalurkan ke posko pengungsian. Pemerintah mengimbau warga tetap waspada.',
            ],
            [
                'img' => '/image/image6.jpg',
                'tanggal' => '19/07/2024',
                'judul' => 'Sekolah Terendam, Proses Belajar Dihentikan',
                'isi_lengkap' => 'Dinas pendidikan meliburkan sekolah yang terendam banjir. Siswa diminta untuk melakukan pembelajaran daring. Sekolah yang terdampak akan segera diperbaiki setelah banjir surut.',
            ],
            [
                'img' => '/image/image7.jpg',
                'tanggal' => '18/07/2024',
                'judul' => 'Bantuan Logistik Mulai Disalurkan',
                'isi_lengkap' => 'Bantuan logistik berupa beras, mie instan, air mineral, dan selimut mulai didistribusikan. Pemerintah bekerja sama dengan organisasi sosial untuk menjangkau wilayah terpencil yang terdampak banjir.',
            ],
        ];

        // Validasi ID
        if (!isset($beritaList[$id])) {
            abort(404);
        }

        $berita = $beritaList[$id];
        return view('berita.show', compact('berita'));
    }
}
