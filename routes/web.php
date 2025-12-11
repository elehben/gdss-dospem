<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMasterController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------- 
*/

// --- 1. GUEST ROUTES (Login) ---
Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- 2. AUTHENTICATED ROUTES (Harus Login) ---
Route::middleware(['auth'])->group(function () {

    // Dashboard (Controller akan memilah tampilan Admin vs User)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil User
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');

    // Data Master (Kriteria & Alternatif) - VIEW ONLY untuk User Biasa
    Route::get('/kriteria', [DataMasterController::class, 'indexKriteria'])->name('kriteria.index');
    Route::get('/alternatif', [DataMasterController::class, 'indexAlternatif'])->name('alternatif.index');

    // --- 3. KHUSUS USER / DECISION MAKER (Input Penilaian) ---
    // User biasa bisa akses ini, tapi Admin sebaiknya tidak perlu (logic di view/controller)
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
    
    // Hasil WP Pribadi
    Route::get('/hasil-wp', [PerhitunganController::class, 'hasilWpPribadi'])->name('hasil.wp');

    // Hasil Borda
    Route::get('/hasil-borda', [PerhitunganController::class, 'hasilBorda'])->name('hasil.borda');

    // Perhitungan Akhir (Borda)
        Route::post('/hitung-borda', [PerhitunganController::class, 'hitungBorda'])->name('hitung.borda');

    // --- 4. KHUSUS ADMIN (Middleware 'is_admin') ---
    Route::middleware(['is_admin'])->group(function () {
        
        // CRUD Kriteria (Store, Update, Destroy)
        Route::post('/kriteria', [DataMasterController::class, 'storeKriteria'])->name('kriteria.store');
        Route::put('/kriteria/{id}', [DataMasterController::class, 'updateKriteria'])->name('kriteria.update');
        Route::delete('/kriteria/{id}', [DataMasterController::class, 'destroyKriteria'])->name('kriteria.destroy');

        // CRUD Alternatif (Store, Update, Destroy)
        Route::post('/alternatif', [DataMasterController::class, 'storeAlternatif'])->name('alternatif.store');
        Route::put('/alternatif/{id}', [DataMasterController::class, 'updateAlternatif'])->name('alternatif.update');
        Route::delete('/alternatif/{id}', [DataMasterController::class, 'destroyAlternatif'])->name('alternatif.destroy');
        
        // Lihat Hasil WP per Decision Maker
        Route::get('/hasil-wp/{userId}', [PerhitunganController::class, 'hasilWpDM'])->name('hasil.wp.dm');
    });

});

Route::get('/cek-model', function() {
    $user = new \App\Models\User();
    return [
        'Primary Key' => $user->getKeyName(), // Harus tertulis "id_user"
        'Incrementing' => $user->getIncrementing(), // Harus false
        'Key Type' => $user->getKeyType(), // Harus string
    ];
});

// --- ROUTE DEBUGGING SEMENTARA (HAPUS NANTI) ---
// Route::get('/debug-login', function () {
    
//     // 1. Cek Apakah User Ada?
//     $user = \App\Models\User::find('U0001'); // Pastikan ID ini ada di DB Anda
    
//     if (!$user) {
//         return 'ERROR: User U0001 tidak ditemukan di database.';
//     }

//     // 2. Cek Password Hash Manual
//     // Ganti 'password' dengan password yang Anda yakini benar
//     $inputPassword = '1234'; 
//     $checkHash = \Illuminate\Support\Facades\Hash::check($inputPassword, $user->password);

//     // 3. Coba Login Manual
//     \Illuminate\Support\Facades\Auth::login($user);
    
//     return [
//         '1_user_found' => $user->toArray(),
//         '2_password_check' => $checkHash ? 'MATCH (Cocok)' : 'MISMATCH (Password Salah)',
//         '3_session_id_before' => session()->getId(),
//         '4_auth_check_immediate' => \Illuminate\Support\Facades\Auth::check() ? 'Login Sukses' : 'Gagal Login',
//         '5_user_id_from_auth' => \Illuminate\Support\Facades\Auth::id(),
//     ];
// });

// Route::middleware(['auth', 'is_admin'])->group(function () {
//     // ... route lain ...
    
//     // Lihat Hasil
//     Route::get('/hasil-borda', [PerhitunganController::class, 'hasilBorda'])->name('hasil.borda');
    
//     // Action Hitung Ulang
//     Route::post('/hitung-borda', [PerhitunganController::class, 'hitungBorda'])->name('hitung.borda');
// });