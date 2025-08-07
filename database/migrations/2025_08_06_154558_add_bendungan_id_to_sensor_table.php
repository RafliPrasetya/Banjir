<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sensor', function (Blueprint $table) {
            $table->unsignedBigInteger('bendungan_id')->nullable()->after('id');
            $table->foreign('bendungan_id')->references('id')->on('bendungans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('sensor', function (Blueprint $table) {
            $table->dropForeign(['bendungan_id']);
            $table->dropColumn('bendungan_id');
        });
    }
};
