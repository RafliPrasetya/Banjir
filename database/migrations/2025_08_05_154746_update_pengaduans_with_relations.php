<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Drop kolom lama
            if (Schema::hasColumn('pengaduans', 'asal_kecamatan')) {
                $table->dropColumn('asal_kecamatan');
            }

            if (Schema::hasColumn('pengaduans', 'bendungan')) {
                $table->dropColumn('bendungan');
            }

            // Tambah kolom baru relasi ke kecamatans
            if (!Schema::hasColumn('pengaduans', 'kecamatan_id')) {
                $table->foreignId('kecamatan_id')
                    ->after('no_hp')
                    ->constrained()
                    ->onDelete('cascade');
            }

            // Tambah kolom baru relasi ke bendungans
            if (!Schema::hasColumn('pengaduans', 'bendungan_id')) {
                $table->foreignId('bendungan_id')
                    ->after('kecamatan_id')
                    ->constrained()
                    ->onDelete('cascade');
            }

            // Kolom untuk upload foto
            if (!Schema::hasColumn('pengaduans', 'foto')) {
                $table->string('foto')->nullable()->after('pesan');
            }

            // Kolom respon dari admin
            if (!Schema::hasColumn('pengaduans', 'respon')) {
                $table->text('respon')->nullable()->after('foto');
            }

            // Kolom status pengaduan
            if (!Schema::hasColumn('pengaduans', 'status')) {
                $table->string('status')->default('Belum Ditanggapi')->after('respon');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Drop foreign key dulu sebelum drop kolomnya
            if (Schema::hasColumn('pengaduans', 'kecamatan_id')) {
                $table->dropForeign(['kecamatan_id']);
                $table->dropColumn('kecamatan_id');
            }

            if (Schema::hasColumn('pengaduans', 'bendungan_id')) {
                $table->dropForeign(['bendungan_id']);
                $table->dropColumn('bendungan_id');
            }

            // Drop kolom baru
            if (Schema::hasColumn('pengaduans', 'foto')) {
                $table->dropColumn('foto');
            }

            if (Schema::hasColumn('pengaduans', 'respon')) {
                $table->dropColumn('respon');
            }

            if (Schema::hasColumn('pengaduans', 'status')) {
                $table->dropColumn('status');
            }

            // Tambah kembali kolom lama
            $table->string('asal_kecamatan')->nullable();
            $table->string('bendungan')->nullable();
        });
    }
};
