@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- HEADER SECTION --}}
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="welcome-banner p-4 rounded-4 position-relative overflow-hidden">
                <div class="position-relative z-1">
                    <h2 class="fw-bold text-white mb-2">
                        <i class="bi bi-shield-check me-2"></i>Dashboard Administrator
                    </h2>
                    <p class="text-white-50 mb-0">Selamat datang kembali! Berikut adalah ringkasan data sistem GDSS.</p>
                </div>
                <div class="welcome-decoration">
                    <i class="bi bi-gear-fill"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- KARTU STATISTIK --}}
    <div class="row g-4 mb-5">
        {{-- Card Total Decision Maker --}}
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-purple h-100">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Decision Makers</span>
                        <h2 class="stat-value">{{ $total_user }}</h2>
                        <span class="stat-badge">
                            <i class="bi bi-person-check"></i> User Aktif
                        </span>
                    </div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>

        {{-- Card Total Kriteria --}}
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-green h-100">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-list-check"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Kriteria</span>
                        <h2 class="stat-value">{{ $total_kriteria }}</h2>
                        <a href="{{ route('kriteria.index') }}" class="stat-link">
                            Kelola Kriteria <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>

        {{-- Card Total Alternatif --}}
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-cyan h-100">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">Total Alternatif</span>
                        <h2 class="stat-value">{{ $total_alternatif }}</h2>
                        <a href="{{ route('alternatif.index') }}" class="stat-link">
                            Kelola Alternatif <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
                <div class="stat-wave"></div>
            </div>
        </div>

        {{-- Card Status Borda --}}
        <div class="col-md-6 col-lg-3">
            <div class="stat-card stat-card-status h-100 {{ $status_borda == 'Sudah Dihitung' ? 'status-done' : 'status-pending' }}">
                <div class="stat-card-body">
                    <div class="stat-icon-status">
                        @if($status_borda == 'Sudah Dihitung')
                            <i class="bi bi-check-circle-fill"></i>
                        @else
                            <i class="bi bi-hourglass-split"></i>
                        @endif
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">STATUS HASIL</span>
                        <h4 class="stat-value-status">
                            {{ $status_borda }}
                        </h4>
                        <a href="{{ route('hasil.borda') }}" class="stat-link-status">
                            <span>Lihat Hasil</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="status-glow"></div>
            </div>
        </div>
    </div>

    {{-- CONTENT SECTION --}}
    <div class="row g-4">
        {{-- Aktivitas Terakhir --}}
        <div class="col-lg-8">
            <div class="card content-card border-0 shadow-sm h-100">
                <div class="content-card-header pt-4 pb-3 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">
                                <i class="bi bi-activity text-primary me-2"></i>Aktivitas Sistem
                            </h5>
                            <p class="text-muted small mb-0">Informasi terkini dari sistem</p>
                        </div>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-clock me-1"></i> Real-time
                        </span>
                    </div>
                </div>
                <div class="card-body p-4 pt-2">
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon bg-primary-subtle">
                                <i class="bi bi-info-circle text-primary"></i>
                            </div>
                            <div class="activity-content">
                                <p class="mb-1">Sistem siap digunakan untuk perhitungan metode <strong>Weighted Product</strong>.</p>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> Baru saja
                                </small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-success-subtle">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                            <div class="activity-content">
                                <p class="mb-1">Data Master <strong>(Kriteria & Alternatif)</strong> telah dimuat dengan sukses.</p>
                                <small class="text-muted">
                                    <i class="bi bi-cpu me-1"></i> System
                                </small>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon bg-info-subtle">
                                <i class="bi bi-database-check text-info"></i>
                            </div>
                            <div class="activity-content">
                                <p class="mb-1">Database terkoneksi dan siap digunakan.</p>
                                <small class="text-muted">
                                    <i class="bi bi-hdd me-1"></i> Database
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Menu Cepat --}}
        <div class="col-lg-4">
            <div class="card content-card border-0 shadow-sm h-100">
                <div class="content-card-header pt-4 pb-3 px-4">
                    <h5 class="fw-bold mb-1 text-dark">
                        <i class="bi bi-lightning-charge text-warning me-2"></i>Aksi Cepat
                    </h5>
                    <p class="text-muted small mb-0">Pintasan ke fitur utama</p>
                </div>
                <div class="card-body p-4 pt-2">
                    <div class="d-grid gap-3">
                        <button class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <div class="quick-action-icon bg-primary-subtle">
                                <i class="bi bi-plus-lg text-primary"></i>
                            </div>
                            <div class="quick-action-text">
                                <span class="fw-semibold">Tambah Kriteria</span>
                                <small class="text-muted d-block">Buat kriteria baru</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </button>
                        
                        <button class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#modalTambahAlt">
                            <div class="quick-action-icon bg-success-subtle">
                                <i class="bi bi-person-plus text-success"></i>
                            </div>
                            <div class="quick-action-text">
                                <span class="fw-semibold">Tambah Alternatif</span>
                                <small class="text-muted d-block">Tambah dosen baru</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </button>
                        
                        <a href="{{ route('hasil.borda') }}" class="quick-action-btn text-decoration-none">
                            <div class="quick-action-icon bg-warning-subtle">
                                <i class="bi bi-calculator text-warning"></i>
                            </div>
                            <div class="quick-action-text">
                                <span class="fw-semibold">Hitung Borda</span>
                                <small class="text-muted d-block">Proses perangkingan</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </a>
                        
                        <a href="{{ route('kriteria.index') }}" class="quick-action-btn text-decoration-none">
                            <div class="quick-action-icon bg-info-subtle">
                                <i class="bi bi-gear text-info"></i>
                            </div>
                            <div class="quick-action-text">
                                <span class="fw-semibold">Kelola Data</span>
                                <small class="text-muted d-block">Atur kriteria & alternatif</small>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- INFO SECTION --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="info-banner p-4 rounded-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="fw-bold mb-2">
                            <i class="bi bi-lightbulb me-2"></i>Tentang Sistem GDSS
                        </h5>
                        <p class="mb-0 text-muted">
                            Sistem ini menggunakan metode <strong>Weighted Product (WP)</strong> untuk penilaian individu 
                            dan <strong>Borda Count</strong> untuk agregasi keputusan kelompok dalam pemilihan dosen pembimbing.
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('hasil.borda') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-play-fill me-2"></i>Mulai Perhitungan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin())
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/kriteria" method="POST">
            @csrf
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kriteria
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kriteria</label>
                        <input type="text" name="id_kriteria" class="form-control" placeholder="Contoh: C1, C2, ..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="form-control" placeholder="Masukkan nama kriteria" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kriteria</label>
                        <select name="jenis" class="form-select">
                            <option value="Benefit">Benefit (Semakin tinggi semakin baik)</option>
                            <option value="Cost">Cost (Semakin rendah semakin baik)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bobot</label>
                        <input type="number" step="0.01" name="bobot" class="form-control" placeholder="Contoh: 5" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalTambahAlt" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/alternatif" method="POST">
            @csrf
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus me-2"></i>Tambah Alternatif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Alternatif</label>
                        <input type="text" name="id_alt" class="form-control" placeholder="Contoh: A1, A2, ..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Dosen</label>
                        <input type="text" name="nama_alt" class="form-control" placeholder="Masukkan nama dosen" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endsection