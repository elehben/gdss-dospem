<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\alternatif;
use App\Models\hasil;
use App\Models\kriteria;
use App\Models\penilaian;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // --- DASHBOARD ADMIN ---
        if ($user->isAdmin()) {
            $data = [
                'total_user' => User::where('id_user', '!=', 'U0001')->count(),
                'total_kriteria' => kriteria::count(),
                'total_alternatif' => alternatif::count(),
                'status_borda' => hasil::exists() ? 'Sudah Dihitung' : 'Belum Dihitung',
            ];
            return view('dashboard.admin', $data);
        }

        // --- DASHBOARD USER (DM) ---
        else {
            // Cek apakah user ini sudah input penilaian
            $sudahMenilai = penilaian::where('id_user', $user->id_user)->exists();
            
            return view('dashboard.user', [
                'status_penilaian' => $sudahMenilai ? 'Sudah Selesai' : 'Belum Input',
                'user_name' => $user->name,
                'total_kriteria' => kriteria::count(),
                'total_alternatif' => alternatif::count(),
            ]);
        }
    }
}
