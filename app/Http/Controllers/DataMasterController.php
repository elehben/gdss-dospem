<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Alternatif;

class DataMasterController extends Controller
{
    // ==========================================
    // BAGIAN KRITERIA
    // ==========================================

    public function indexKriteria()
    {
        $kriteria = Kriteria::get();
        return view('master.kriteria', ['kriteria' => $kriteria]);
    }

    public function storeKriteria(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // 1. Validasi (Hapus bobot_normalisasi dari validasi)
        $request->validate([
            'id_kriteria' => 'required|unique:kriteria,id_kriteria|max:5',
            'nama_kriteria' => 'required',
            'jenis' => 'required|in:Benefit,Cost',
            'bobot' => 'required|numeric|min:0',
        ]);

        // 2. Simpan Data Baru (Set normalisasi 0 dulu sementara)
        Kriteria::create([
            'id_kriteria' => $request->id_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'jenis' => $request->jenis,
            'bobot' => $request->bobot,
            'bobot_normalisasi' => 0 // Akan diupdate otomatis di bawah
        ]);

        // 3. Hitung Ulang Normalisasi SEMUA Kriteria
        $this->hitungNormalisasiOtomatis();

        return redirect('/kriteria')->with('success', 'Kriteria berhasil ditambahkan dan bobot dinormalisasi ulang.');
    }

    public function updateKriteria(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        $kriteria = Kriteria::findOrFail($id);
        
        
        // Update data (kecuali ID)
        $kriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'jenis' => $request->jenis,
            'bobot' => $request->bobot,
            // bobot_normalisasi jangan diupdate manual dari request
        ]);

        // Hitung ulang karena bobot mungkin berubah
        $this->hitungNormalisasiOtomatis();

        return redirect('/kriteria')->with('success', 'Kriteria berhasil diupdate dan dinormalisasi ulang.');
    }

    public function destroyKriteria($id)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        Kriteria::findOrFail($id)->delete();

        // Hitung ulang karena pembagi (total bobot) berubah setelah dihapus
        $this->hitungNormalisasiOtomatis();

        return redirect('/kriteria')->with('success', 'Kriteria berhasil dihapus dan bobot sisa dinormalisasi ulang.');
    }

    /**
     * FUNGSI KHUSUS MENGHITUNG BOBOT NORMALISASI
     * Rumus: Bobot Item / Total Semua Bobot
     */
    private function hitungNormalisasiOtomatis()
    {
        // 1. Ambil semua kriteria
        $semuaKriteria = Kriteria::all();

        // 2. Hitung Total Bobot saat ini
        $totalBobot = $semuaKriteria->sum('bobot');

        // Cegah pembagian dengan nol (jika data kosong)
        if ($totalBobot <= 0) return;

        // 3. Loop setiap kriteria untuk update normalisasinya
        foreach ($semuaKriteria as $k) {
            $norm = $k->bobot / $totalBobot;
            
            // Update langsung ke database tanpa mengubah timestamp
            $k->bobot_normalisasi = $norm;
            $k->save();
        }
    }

    // ==========================================
    // BAGIAN ALTERNATIF (TIDAK BERUBAH)
    // ==========================================

    public function indexAlternatif()
    {
        $alternatif = Alternatif::all();
        return view('master.alternatif', compact('alternatif'));
    }

    public function storeAlternatif(Request $request)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        $request->validate([
            'id_alt' => 'required|unique:alternatif,id_alt|max:5',
            'nama_alt' => 'required',
        ]);

        Alternatif::create($request->all());
        return redirect('/alternatif')->with('success', 'Alternatif berhasil ditambahkan');
    }

    public function updateAlternatif(Request $request, $id)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        $alt = Alternatif::findOrFail($id);
        $alt->update($request->only('nama_alt'));
        return redirect('/alternatif')->with('success', 'Alternatif berhasil diupdate');
    }

    public function destroyAlternatif($id)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        Alternatif::findOrFail($id)->delete();
        return redirect('/alternatif')->with('success', 'Alternatif berhasil dihapus');
    }
}