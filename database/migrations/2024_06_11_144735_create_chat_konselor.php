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
        Schema::create('chat_konselor', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->unsignedBigInteger('orangtua_id');
            $table->unsignedBigInteger('konselor_id');
            $table->timestamps();

            $table->foreign("orangtua_id")->references("id")->on("pengguna");
            $table->foreign("konselor_id")->references("id")->on("pengguna");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_konselor');
    }
};
