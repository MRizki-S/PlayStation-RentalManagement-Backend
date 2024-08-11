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
        Schema::create('game_logs', function (Blueprint $table) {
            $table->id();
            // relasi ke table playstation
            $table->unsignedBigInteger('ps_id');
            $table->foreign('ps_id')->references('id')->on('playstation');

            $table->dateTime('start_time');
            $table->dateTime('time_ends');
            $table->bigInteger('total_price');
            $table->string('status_permainan', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_logs');
    }
};
