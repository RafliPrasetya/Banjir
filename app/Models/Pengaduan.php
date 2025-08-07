<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kecamatan_id',
        'bendungan_id',
        'no_hp',
        'pesan',
        'foto',
        'status',
        'respon',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function bendungan()
    {
        return $this->belongsTo(Bendungan::class);
    }
}
