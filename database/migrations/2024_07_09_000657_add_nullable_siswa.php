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
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tgl_lahir')->nullable()->change();
            $table->string('agama')->nullable()->change();
            $table->string('golongan_darah')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('telepon')->nullable()->change();
            $table->string('sekolah_asal')->nullable()->change();
            $table->string('diterima_sebagai')->nullable()->change();
            $table->year('tahun_terima')->nullable()->change();
            $table->string('hobi')->nullable()->change();
            $table->string('nama_ayah')->nullable()->change();
            $table->string('tempat_lahir_ayah')->nullable()->change();
            $table->date('tgl_lahir_ayah')->nullable()->change();
            $table->string('pekerjaan_ayah')->nullable()->change();
            $table->string('agama_ayah')->nullable()->change();
            $table->string('nama_ibu')->nullable()->change();
            $table->string('tempat_lahir_ibu')->nullable()->change();
            $table->date('tgl_lahir_ibu')->nullable()->change();
            $table->string('pekerjaan_ibu')->nullable()->change();
            $table->string('agama_ibu')->nullable()->change();
            $table->text('alamat_ortu')->nullable()->change();
            $table->string('telepon_ortu')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
