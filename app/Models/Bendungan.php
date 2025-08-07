<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bendungan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kecamatan_id'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    public function sensorTerbaru()
    {
        return $this->hasOne(Sensor::class)->latestOfMany('tanggal');
    }
}
