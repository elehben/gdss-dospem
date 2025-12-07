<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\alternatif;
use App\Models\borda;
use App\Models\hasil;
use App\Models\penilaian;
use App\Models\preferensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    /**
     * Menampilkan Halaman Hasil WP Pribadi (User Login)
     */
    public function hasilWpPribadi()
    {
        $userId = auth()->user()->id_user;

        // Ambil data Preferensi WP (Hasil Hitungan) join dengan Alternatif
        $hasil = preferensi::with('alternatif')
                    ->where('id_user', $userId)
                    ->orderBy('rangking_wp', 'asc')
                    ->get();

        // Cek jika data kosong (User belum menilai)
        if ($hasil->isEmpty()) {
            return redirect()->route('penilaian.index')
                             ->with('error', 'Anda belum melakukan penilaian. Silakan isi form terlebih dahulu.');
        }

        return view('hasil.wp_pribadi', compact('hasil'));
    }

    /**
     * Menampilkan Halaman Hasil WP untuk DM tertentu (Admin Only)
     */
    public function hasilWpDM($userId)
    {
        // Pastikan hanya admin
        if (!auth()->user()->isAdmin()) abort(403);

        // Ambil data user DM
        $dm = User::find($userId);
        if (!$dm) {
            return redirect()->route('dashboard')->with('error', 'Decision Maker tidak ditemukan.');
        }

        // Ambil data Preferensi WP
        $hasil = preferensi::with('alternatif')
                    ->where('id_user', $userId)
                    ->orderBy('rangking_wp', 'asc')
                    ->get();

        // Flag untuk view bahwa ini dilihat oleh admin
        $viewedByAdmin = true;
        $dmName = $dm->name;

        return view('hasil.wp_pribadi', compact('hasil', 'viewedByAdmin', 'dmName'));
    }

    /**
     * LOGIKA INTI WP: Hitung Vector S & V
     * Fungsi ini dipanggil oleh PenilaianController setelah store()
     */
    public function hitungWpUser($userId)
    {
        // 1. Ambil data nilai terbobot dari tabel penilaian
        // Group by Alternatif agar mudah dikalikan per alternatif
        $penilaians = penilaian::where('id_user', $userId)->get()->groupBy('id_alt');
        
        $vectorS = [];
        $totalS = 0;

        // 2. TAHAP VECTOR S (Perkalian)
        // Rumus: S = Π (Nilai^Bobot)
        foreach ($penilaians as $altId => $items) {
            $perkalian = 1;
            
            // Kalikan semua nilai kriteria untuk alternatif ini
            foreach ($items as $item) {
                // Pastikan nilai_terbobot sudah dihitung di PenilaianController (Pangkat Bobot)
                $perkalian *= $item->nilai_terbobot;
            }
            
            $vectorS[$altId] = $perkalian;
            $totalS += $perkalian;
        }

        // 3. TAHAP VECTOR V (Preferensi Relatif) & RANKING
        // Rumus: V = S / ΣS
        
        // Urutkan Vector S dari besar ke kecil untuk penentuan ranking
        arsort($vectorS); 

        $rank = 1;
        foreach ($vectorS as $altId => $nilaiS) {
            
            // Hindari division by zero
            $skorPref = ($totalS > 0) ? ($nilaiS / $totalS) : 0;

            // Simpan / Update ke tabel preferensi_wp
            preferensi::updateOrCreate(
                [
                    'id_user' => $userId,
                    'id_alt' => $altId
                ],
                [
                    'perkalian' => $nilaiS,     // Nilai Vector S
                    'skor_pref' => $skorPref,   // Nilai Vector V
                    'rangking_wp' => $rank++    // Ranking 1, 2, 3...
                ]
            );
        }
    }

    /**
     * TAMPILAN HASIL AKHIR (BORDA) - ADMIN ONLY
     */
    public function hasilBorda()
    {
        // Pastikan hanya admin
        // if (!auth()->user()->isAdmin()) abort(403);

        // Ambil hasil yang sudah diurutkan berdasarkan Ranking Borda
        $hasil = hasil::with('alternatif')
                    ->orderBy('rangking_borda', 'asc')
                    ->get();

        return view('hasil.hasil_akhir', compact('hasil'));
    }

    /**
     * LOGIKA HITUNG BORDA (Group Decision)
     * Dijalankan saat Admin menekan tombol "Hitung Hasil Akhir"
     * 
     * RUMUS:
     * - Total Poin Borda = Σ (Skor Preferensi WP × Bobot Borda berdasarkan ranking)
     * - Nilai Borda = Total Poin / Σ Total Poin (semua alternatif)
     */
    public function hitungBorda()
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isKadep()) abort(403);

        // 1. Persiapan Data
        $alternatifs = alternatif::all();
        $users = User::where('id_user', '!=', 'U0001')->get(); // Ambil semua DM
        
        // Ambil Referensi Bobot Borda (Array: [Ranking => Bobot])
        // Contoh: [1 => 9, 2 => 8, ... 10 => 0]
        $refBobot = borda::pluck('bobot_borda', 'ranking')->toArray();

        // Bersihkan hasil lama agar tidak duplikat
        DB::table('hasil_borda')->truncate();

        $tempHasil = [];
        $grandTotalPoin = 0; // Total poin seluruh alternatif

        // 2. Loop Per Alternatif untuk Akumulasi Poin
        foreach ($alternatifs as $alt) {
            $totalPoin = 0;

            foreach ($users as $user) {
                // Ambil data preferensi WP dari user ini untuk alternatif ini
                $pref = preferensi::where('id_user', $user->id_user)
                            ->where('id_alt', $alt->id_alt)
                            ->first();

                if ($pref) {
                    $rankDidapat = $pref->rangking_wp;
                    $skorPreferensi = $pref->skor_pref; // Vector V dari WP
                    
                    // Ambil bobot borda berdasarkan ranking
                    // Jika rank tidak ada di ref (misal rank 11), kasih nilai 0
                    $bobotBorda = $refBobot[$rankDidapat] ?? 0;
                    
                    // RUMUS: Skor Preferensi × Bobot Borda
                    $poinDM = $skorPreferensi * $bobotBorda;
                    
                    $totalPoin += $poinDM;
                }
            }

            $tempHasil[] = [
                'id_alt' => $alt->id_alt,
                'total_poin' => $totalPoin
            ];

            // Akumulasi grand total untuk perhitungan nilai borda
            $grandTotalPoin += $totalPoin;
        }

        // 3. Hitung Nilai Borda (Normalisasi) & Sorting
        // Rumus: Nilai Borda = Total Poin Alternatif / Grand Total Poin
        foreach ($tempHasil as &$item) {
            $item['nilai_borda'] = ($grandTotalPoin > 0) 
                ? $item['total_poin'] / $grandTotalPoin 
                : 0;
        }
        unset($item); // Hapus referensi

        // Urutkan array berdasarkan Total Poin (Desc)
        usort($tempHasil, function ($a, $b) {
            return $b['total_poin'] <=> $a['total_poin'];
        });

        // 4. Simpan ke Database
        $rank = 1;
        foreach ($tempHasil as $item) {
            hasil::create([
                'id_alt' => $item['id_alt'],
                'total_poin' => $item['total_poin'],
                'nilai_borda' => $item['nilai_borda'],
                'rangking_borda' => $rank++
            ]);
        }

        return back()->with('success', 'Perhitungan Borda Selesai! Hasil akhir telah diperbarui.');
    }
}
