<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp');
            $table->foreignId('kecamatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('bendungan_id')->constrained()->onDelete('cascade');
            $table->text('pesan');
            $table->string('foto')->nullable();
            $table->text('respon')->nullable();
            $table->string('status')->default('Belum Ditanggapi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
