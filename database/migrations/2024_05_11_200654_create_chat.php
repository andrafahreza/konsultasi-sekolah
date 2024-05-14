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
        Schema::create('chat', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->unsignedBigInteger('manajemen_data_bk_id');
            $table->enum('status_chat', ['active', 'nonactive']);
            $table->timestamps();

            $table->foreign("manajemen_data_bk_id")->references("id")->on("manajemen_data_bk");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
