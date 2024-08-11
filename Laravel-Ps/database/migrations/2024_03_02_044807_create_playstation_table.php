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
        Schema::create('playstation', function (Blueprint $table) {
            $table->id();
            $table->string('ps_code', 10);
            $table->string('name', 100);
            $table->bigInteger('price_perjam')->nullable();
            $table->string('status', 100)->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playstation');
    }
};
