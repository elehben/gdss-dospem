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
        Schema::create('bobot_borda', function (Blueprint $table) {
            $table->id('ranking');
            $table->integer('bobot_borda');
        });

        Schema::create('hasil_borda', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->char('id_alt', 5);
            $table->decimal('total_poin', 10, 4);
            $table->decimal('nilai_borda', 10, 4);
            $table->integer('rangking_borda');

            $table->foreign('id_alt')->references('id_alt')
            ->on('alternatif')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bobot_borda');
        Schema::dropIfExists('hasils');
    }
};
