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
        // Tambah kolom tahun ke tabel penilaian
        Schema::table('penilaian', function (Blueprint $table) {
            $table->year('tahun')->after('nilai_terbobot')->default(date('Y'));
            $table->index('tahun');
        });

        // Tambah kolom tahun ke tabel preferensi_wp
        Schema::table('preferensi_wp', function (Blueprint $table) {
            $table->year('tahun')->after('rangking_wp')->default(date('Y'));
            $table->index('tahun');
        });

        // Tambah kolom tahun ke tabel hasil_borda
        Schema::table('hasil_borda', function (Blueprint $table) {
            $table->year('tahun')->after('rangking_borda')->default(date('Y'));
            $table->index('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->dropIndex(['tahun']);
            $table->dropColumn('tahun');
        });

        Schema::table('preferensi_wp', function (Blueprint $table) {
            $table->dropIndex(['tahun']);
            $table->dropColumn('tahun');
        });

        Schema::table('hasil_borda', function (Blueprint $table) {
            $table->dropIndex(['tahun']);
            $table->dropColumn('tahun');
        });
    }
};
