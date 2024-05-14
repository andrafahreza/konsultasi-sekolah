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
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id');
            $table->unsignedBigInteger('siswa_id');
            $table->string('nama');
            $table->string('agama');
            $table->text('alamat');
            $table->string('telepon');
            $table->timestamps();

            $table->foreign("pengguna_id")->references("id")->on("pengguna")->onDelete("cascade");
            $table->foreign("siswa_id")->references("id")->on("siswa")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tua');
    }
};
