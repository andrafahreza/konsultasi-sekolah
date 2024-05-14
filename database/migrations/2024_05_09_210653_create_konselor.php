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
        Schema::table('siswa', function (Blueprint $table) {
            $table->foreign("pengguna_id")->references("id")->on("pengguna")->onDelete("cascade");
        });
        Schema::create('konselor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_id');
            $table->string('nip');
            $table->string('nama_konselor');
            $table->string('agama_konselor');
            $table->text('alamat_konselor');
            $table->string('telepon_konselor');
            $table->timestamps();

            $table->foreign("pengguna_id")->references("id")->on("pengguna")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konselor');
    }
};
