<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensor';

    protected $fillable = ['suhu', 'kelembapan', 'ketinggian_air', 'tanggal'];

    public $timestamps = false;
}
