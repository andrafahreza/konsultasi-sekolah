<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('manajemen_data_bk', function (Blueprint $table) {
            $table->enum('acc_konselor', ['menunggu', 'ditolak', 'diterima']);
            $table->text('alasan_tolak')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manajemen_data_bk', function (Blueprint $table) {
            //
        });
    }
};
