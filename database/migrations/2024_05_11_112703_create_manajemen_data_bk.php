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
        Schema::create('manajemen_data_bk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('konselor_id');
            $table->dateTime('tgl_bk');
            $table->enum('jenis', ['bully', 'konsultasi']);
            $table->text('isi')->nullable();
            $table->text('tindakan')->nullable();
            $table->timestamps();

            $table->foreign("siswa_id")->references("id")->on("siswa");
            $table->foreign("konselor_id")->references("id")->on("konselor");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajemen_data_bk');
    }
};
