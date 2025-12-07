@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endpush

@section('content')
<div class="container py-4">
    
    {{-- WELCOME BANNER --}}
    <div class="welcome-user-banner mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="welcome-content">
                    <span class="welcome-badge mb-3">
                        <i class="bi bi-person-badge me-1"></i> Decision Maker
                    </span>
                    <h1 class="welcome-title">Halo, {{ $user_name }}! 👋</h1>
                    <p class="welcome-subtitle">
                        Selamat datang di Sistem Pendukung Keputusan GDSS. Peran Anda adalah memberikan 
                        penilaian objektif terhadap alternatif dosen pembimbing.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <div class="welcome-illustration">
                    <i class="bi bi-clipboard-data"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- STATUS CARD --}}
    <div class="row mb-5">
        <div class="col-12">
            @if($status_penilaian == 'Belum Input')
                <div class="status-card status-warning">
                    <div class="status-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="status-content">
                        <h4 class="status-title">Anda Belum Memberikan Penilaian</h4>
                        <p class="status-text">Silakan isi formulir penilaian matriks untuk melanjutkan proses perhitungan WP.</p>
                        <a href="{{ route('penilaian.index') }}" class="btn btn-warning btn-lg mt-2">
                            <i class="bi bi-pencil-square me-2"></i>Mulai Penilaian Sekarang
                        </a>
                    </div>
                </div>
            @else
                <div class="status-card status-success">
                    <div class="status-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="status-content">
                        <h4 class="status-title">Terima Kasih! Penilaian Anda Telah Tersimpan</h4>
                        <p class="status-text">Data penilaian Anda telah tersimpan dan hasil WP pribadi Anda telah dihitung.</p>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="{{ route('hasil.wp') }}" class="btn btn-success btn-lg">
                                <i class="bi bi-bar-chart-line me-2"></i>Lihat Hasil WP Saya
                            </a>
                            <a href="{{ route('penilaian.index') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-pencil me-2"></i>Edit Penilaian
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- QUICK STATS --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="mini-stat-card">
                <div class="mini-stat-icon bg-primary-subtle">
                    <i class="bi bi-list-check text-primary"></i>
                </div>
                <div class="mini-stat-content">
                    <span class="mini-stat-label">Total Kriteria</span>
                    <h3 class="mini-stat-value">{{ $total_kriteria }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-stat-card">
                <div class="mini-stat-icon bg-success-subtle">
                    <i class="bi bi-people text-success"></i>
                </div>
                <div class="mini-stat-content">
                    <span class="mini-stat-label">Total Alternatif</span>
                    <h3 class="mini-stat-value">{{ $total_alternatif }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-stat-card">
                <div class="mini-stat-icon bg-info-subtle">
                    <i class="bi bi-{{ $status_penilaian == 'Belum Input' ? 'clock' : 'check2-all' }} text-info"></i>
                </div>
                <div class="mini-stat-content">
                    <span class="mini-stat-label">Status Penilaian</span>
                    <h5 class="mini-stat-value {{ $status_penilaian == 'Belum Input' ? 'text-warning' : 'text-success' }}">
                        {{ $status_penilaian }}
                    </h5>
                </div>
            </div>
        </div>
    </div>

    {{-- PANDUAN --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="guide-card guide-dark">
                <div class="guide-header">
                    <div class="guide-icon">
                        <i class="bi bi-calculator"></i>
                    </div>
                    <h4 class="guide-title">Tentang Metode WP</h4>
                </div>
                <div class="guide-body">
                    <p>Metode <strong>Weighted Product (WP)</strong> adalah metode pengambilan keputusan dengan menggunakan perkalian untuk menghubungkan rating atribut.</p>
                    <ul class="guide-list">
                        <li><i class="bi bi-check-circle text-success me-2"></i>Setiap kriteria memiliki bobot kepentingan</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Rating dipangkatkan dengan bobot normalisasi</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Hasil berupa nilai preferensi relatif</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="guide-card guide-light">
                <div class="guide-header">
                    <div class="guide-icon">
                        <i class="bi bi-list-ol"></i>
                    </div>
                    <h4 class="guide-title">Langkah-Langkah</h4>
                </div>
                <div class="guide-body">
                    <div class="steps-list">
                        <div class="step-item">
                            <span class="step-number">1</span>
                            <span>Buka menu <strong>Input Penilaian</strong></span>
                        </div>
                        <div class="step-item">
                            <span class="step-number">2</span>
                            <span>Isi nilai untuk setiap alternatif pada setiap kriteria</span>
                        </div>
                        <div class="step-item">
                            <span class="step-number">3</span>
                            <span>Klik <strong>Simpan</strong> untuk menyimpan data</span>
                        </div>
                        <div class="step-item">
                            <span class="step-number">4</span>
                            <span>Lihat hasil preferensi WP Anda</span>
                        </div>
                        <div class="step-item">
                            <span class="step-number">5</span>
                            <span>Admin menggabungkan dengan metode <strong>Borda</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection