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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->char('id_user', 5);
            $table->char('id_alt', 5);
            $table->char('id_kriteria', 5);
            $table->decimal('nilai_awal', 10, 4);
            $table->decimal('nilai_terbobot', 10, 4);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')
            ->on('users')->onDelete('cascade');
            $table->foreign('id_alt')->references('id_alt')
            ->on('alternatif')->onDelete('cascade');
            $table->foreign('id_kriteria')->references('id_kriteria')
            ->on('kriteria')->onDelete('cascade');
        });

        Schema::create('preferensi_wp', function (Blueprint $table) {
            $table->id('id_pref');
            $table->char('id_alt', 5);
            $table->char('id_user', 5);
            $table->decimal('perkalian', 10, 4);
            $table->decimal('skor_pref', 10, 4);
            $table->integer('rangking_wp');
            $table->timestamps();

            $table->foreign('id_alt')->references('id_alt')
            ->on('alternatif')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')
            ->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
        Schema::dropIfExists('preferensi_wp');
    }
};
