<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sensor', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->float('suhu', 5, 2);
            $table->float('kelembapan', 5, 2);
            $table->float('ketinggian_air', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor');
    }
};
