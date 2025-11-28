<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\alternatif;
use App\Models\kriteria;
use App\Models\penilaian;
use App\Models\preferensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id_user;
        $alternatif = alternatif::all();
        $kriteria = kriteria::all();

        // Ambil data penilaian yang sudah ada (untuk pre-fill form)
        // Format array: [id_alt][id_kriteria] => nilai_awal
        $existing = penilaian::where('id_user', $userId)->get();
        $dataNilai = [];
        foreach ($existing as $p) {
            $dataNilai[$p->id_alt][$p->id_kriteria] = $p->nilai_awal;
        }

        return view('penilaian.index', compact('alternatif', 'kriteria', 'dataNilai'));
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id_user;
        $input = $request->input('nilai'); // Array 2D [alt][kriteria]

        if (!$input) {
            return back()->with('error', 'Data tidak boleh kosong.');
        }

        // Ambil data kriteria untuk perhitungan bobot pangkat
        $kriterias = Kriteria::all()->keyBy('id_kriteria');

        DB::beginTransaction();
        try {
            // 1. SIMPAN NILAI AWAL & NILAI TERBOBOT KE TABEL PENILAIAN
            foreach ($input as $altId => $vals) {
                foreach ($vals as $kriteriaId => $nilaiAwal) {
                    
                    $k = $kriterias[$kriteriaId];
                    
                    // Rumus Pangkat WP:
                    // Jika Benefit: nilai^bobot_norm
                    // Jika Cost: nilai^(-bobot_norm)
                    $pangkat = ($k->jenis == 'Benefit') ? $k->bobot_normalisasi : -$k->bobot_normalisasi;
                    $nilaiTerbobot = pow($nilaiAwal, $pangkat);

                    Penilaian::updateOrCreate(
                        [
                            'id_user' => $userId,
                            'id_alt' => $altId,
                            'id_kriteria' => $kriteriaId
                        ],
                        [
                            'nilai_awal' => $nilaiAwal,
                            'nilai_terbobot' => $nilaiTerbobot // Simpan hasil pangkat
                        ]
                    );
                }
            }

            // 2. HITUNG VECTOR S & VECTOR V (PREFERENSI WP)
            // $this->hitungWpUser($userId);

            // Panggil Calculation Logic dari PerhitunganController
            $hitung = new PerhitunganController();
            $hitung->hitungWpUser($userId);

            DB::commit();
            return redirect()->route('hasil.wp')->with('success', 'Penilaian disimpan dan WP berhasil dihitung!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Logika Inti Weighted Product
     */
    // private function hitungWpUser($userId)
    // {
    //     // Ambil semua nilai terbobot user ini
    //     $penilaians = Penilaian::where('id_user', $userId)->get()->groupBy('id_alt');
        
    //     $vectorS = [];
    //     $totalS = 0;

    //     // --- TAHAP 1: Hitung Vector S (Perkalian) ---
    //     foreach ($penilaians as $altId => $items) {
    //         $perkalian = 1;
    //         foreach ($items as $item) {
    //             $perkalian *= $item->nilai_terbobot;
    //         }
            
    //         $vectorS[$altId] = $perkalian;
    //         $totalS += $perkalian;
    //     }

    //     // --- TAHAP 2: Hitung Vector V (Preferensi & Ranking) ---
    //     // Urutkan Vector S dari terbesar ke terkecil untuk ranking sementara
    //     arsort($vectorS); 

    //     $rank = 1;
    //     foreach ($vectorS as $altId => $nilaiS) {
    //         // Rumus V: S_alternatif / Total_S
    //         $skorPref = ($totalS > 0) ? ($nilaiS / $totalS) : 0;

    //         preferensi::updateOrCreate(
    //             [
    //                 'id_user' => $userId,
    //                 'id_alt' => $altId
    //             ],
    //             [
    //                 'perkalian' => $nilaiS,
    //                 'skor_pref' => $skorPref,
    //                 'rangking_wp' => $rank++
    //             ]
    //         );
    //     }
    // }
}
