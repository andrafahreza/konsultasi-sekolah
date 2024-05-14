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
        Schema::create('isi_chat', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('chat_id', 50);
            $table->unsignedBigInteger('pengguna_id');
            $table->text('isi_chat');
            $table->timestamps();

            $table->foreign("chat_id")->references("id")->on("chat");
            $table->foreign("pengguna_id")->references("id")->on("pengguna");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isi_chat');
    }
};
