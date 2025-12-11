@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/wp.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- HEADER BANNER --}}
    <div class="page-banner-wp mb-4">
        <div class="page-banner-content">
            <div class="page-banner-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="page-banner-text">
                <h2 class="page-banner-title">Hasil Perhitungan WP</h2>
                @if(isset($viewedByAdmin) && $viewedByAdmin)
                    <p class="page-banner-subtitle">Hasil preferensi dari <strong>{{ $dmName }}</strong> menggunakan Metode Weighted Product</p>
                @else
                    <p class="page-banner-subtitle">Hasil preferensi berdasarkan penilaian Anda menggunakan Metode Weighted Product</p>
                @endif
            </div>
        </div>
        @if(!isset($viewedByAdmin) && !auth()->user()->isAdmin())
        <a href="{{ route('penilaian.index') }}" class="btn-revisi">
            <i class="bi bi-pencil-square"></i>
            <span>Revisi Penilaian</span>
        </a>
        @endif
        @if(isset($viewedByAdmin) && $viewedByAdmin)
        <a href="{{ route('hasil.borda') }}" class="btn-revisi btn-back">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali</span>
        </a>
        @endif
        <div class="page-banner-decoration">
            <i class="bi bi-bar-chart-line-fill"></i>
        </div>
    </div>

    {{-- FILTER TAHUN --}}
    @if(isset($tahunList) && $tahunList->isNotEmpty())
    <div class="filter-card mb-4">
        <div class="filter-content">
            <div class="filter-label">
                <i class="bi bi-funnel-fill me-2"></i>
                <span>Filter Tahun</span>
            </div>
            <form action="" method="GET" class="filter-form">
                <select name="tahun" class="form-select filter-select" onchange="this.form.submit()">
                    @foreach($tahunList as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="filter-info">
            <i class="bi bi-calendar3 me-1"></i>
            Menampilkan data tahun <strong>{{ $tahun }}</strong>
        </div>
    </div>
    @endif

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success alert-custom fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon-custom success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="ms-3">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CHECK IF DATA IS EMPTY --}}
    @if($hasil->isEmpty())
    {{-- EMPTY STATE - Belum Ada Perhitungan WP --}}
    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body text-center py-5">
            <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <i class="bi bi-clipboard-data" style="font-size: 3.5rem; color: #667eea;"></i>
            </div>
            <h4 style="font-weight: 700; color: #1a1a2e; margin-bottom: 0.75rem;">Belum Ada Hasil Perhitungan WP</h4>
            @if(isset($viewedByAdmin) && $viewedByAdmin)
            <p class="text-muted mb-4" style="max-width: 450px; margin: 0 auto;">
                <strong>{{ $dmName }}</strong> belum melakukan penilaian untuk tahun <strong>{{ $tahun }}</strong> atau perhitungan WP belum diproses.
            </p>
            <a href="{{ route('hasil.borda') }}" class="btn px-4 py-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 12px; font-weight: 600; text-decoration: none;">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Hasil Borda
            </a>
            @else
            <p class="text-muted mb-4" style="max-width: 450px; margin: 0 auto;">
                Anda belum melakukan penilaian untuk tahun <strong>{{ $tahun ?? date('Y') }}</strong>. Silakan lakukan penilaian terlebih dahulu untuk melihat hasil perhitungan Weighted Product.
            </p>
            <a href="{{ route('penilaian.index') }}" class="btn px-4 py-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 12px; font-weight: 600; text-decoration: none;">
                <i class="bi bi-pencil-square me-2"></i>Input Penilaian Sekarang
            </a>
            @endif
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="info-card-wp mt-4">
        <div class="info-icon">
            <i class="bi bi-info-circle-fill"></i>
        </div>
        <div class="info-content">
            <strong>Informasi:</strong><br>
            <span class="text-muted">
                • Hasil WP akan muncul setelah Anda melakukan penilaian pada menu <strong>Input Penilaian</strong>.<br>
                • Sistem akan otomatis menghitung ranking berdasarkan metode Weighted Product.
            </span>
        </div>
    </div>

    @else
    {{-- TOP RESULT CARD (if data exists) --}}
    @if($hasil->isNotEmpty() && $hasil->first()->rangking_wp == 1)
    <div class="top-result-card mb-4">
        <div class="top-result-badge">
            <i class="bi bi-star-fill"></i>
        </div>
        <div class="top-result-content">
            @if(isset($viewedByAdmin) && $viewedByAdmin)
                <span class="top-result-label">⭐ Rekomendasi Terbaik Versi {{ $dmName }}</span>
            @else
                <span class="top-result-label">⭐ Rekomendasi Terbaik Versi Anda</span>
            @endif
            <h2 class="top-result-name">{{ $hasil->first()->alternatif->nama_alt ?? '-' }}</h2>
            <div class="top-result-stats">
                <div class="top-result-stat">
                    <span class="stat-label">Kode</span>
                    <span class="stat-value">{{ $hasil->first()->id_alt }}</span>
                </div>
                <div class="top-result-stat">
                    <span class="stat-label">Vector S</span>
                    <span class="stat-value">{{ number_format($hasil->first()->perkalian, 4) }}</span>
                </div>
                <div class="top-result-stat">
                    <span class="stat-label">Vector V</span>
                    <span class="stat-value">{{ number_format($hasil->first()->skor_pref, 4) }}</span>
                </div>
            </div>
        </div>
        <div class="top-result-decoration">
            <i class="bi bi-trophy-fill trophy-1"></i>
        </div>
    </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="mini-card-wp">
                <div class="mini-card-icon bg-purple">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">TOTAL ALTERNATIF</span>
                    <h3 class="mini-card-value">{{ $hasil->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="mini-card-wp">
                <div class="mini-card-icon bg-cyan">
                    <i class="bi bi-trophy"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">PERINGKAT 1</span>
                    <h3 class="mini-card-value">{{ $hasil->first()->alternatif->id_alt }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="mini-card-wp">
                <div class="mini-card-icon bg-teal">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">NILAI TERTINGGI</span>
                    <h3 class="mini-card-value">{{ $hasil->isNotEmpty() ? number_format($hasil->first()->skor_pref, 2) : '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="mini-card-wp">
                <div class="mini-card-icon bg-green">
                    <i class="bi bi-check2-all"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">STATUS</span>
                    <h4 class="mini-card-value mini-card-status text-success">Selesai</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- RANKING TABLE --}}
    <div class="card table-card-wp">
        <div class="card-header-wp">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-list-ol"></i>
                <h5 class="mb-0">Peringkat Preferensi WP</h5>
            </div>
            <span class="wp-badge">
                @if(isset($viewedByAdmin) && $viewedByAdmin)
                    <i class="bi bi-person-fill me-1"></i>Hasil {{ $dmName }}
                @else
                    <i class="bi bi-person-fill me-1"></i>Hasil Pribadi
                @endif
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-wp mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 100px;">RANKING</th>
                            <th style="width: 100px;">KODE</th>
                            <th>NAMA ALTERNATIF</th>
                            <th class="text-center" style="width: 150px;">VECTOR S</th>
                            <th class="text-center" style="width: 150px;">VECTOR V</th>
                            <th class="text-center pe-4" style="width: 150px;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasil as $row)
                        <tr class="{{ $row->rangking_wp == 1 ? 'row-top' : '' }}">
                            <td class="ps-4">
                                <div class="ranking-badge rank-{{ $row->rangking_wp <= 3 ? $row->rangking_wp : 'other' }}">
                                    @if($row->rangking_wp == 1)
                                        <i class="bi bi-trophy-fill"></i>
                                    @elseif($row->rangking_wp == 2)
                                        <i class="bi bi-award-fill"></i>
                                    @elseif($row->rangking_wp == 3)
                                        <i class="bi bi-award"></i>
                                    @endif
                                    <span>{{ $row->rangking_wp }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="code-badge-wp">{{ $row->id_alt }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-wp" style="background: {{ ['#667eea', '#11998e', '#f093fb', '#00c6fb', '#f5576c', '#4facfe'][$loop->index % 6] }}">
                                        {{ strtoupper(substr($row->alternatif->nama_alt ?? 'X', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="fw-semibold d-block">{{ $row->alternatif->nama_alt ?? 'Alternatif Terhapus' }}</span>
                                        <small class="text-muted">Dosen Pembimbing</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="vector-badge vector-s">
                                    {{ number_format($row->perkalian, 4) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="vector-badge vector-v">
                                    <i class="bi bi-star-fill me-1"></i>{{ number_format($row->skor_pref, 4) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                @if($row->rangking_wp == 1)
                                    <span class="status-badge-wp status-top">
                                        <i class="bi bi-check-circle-fill me-1"></i>TERBAIK
                                    </span>
                                @elseif($row->rangking_wp <= 3)
                                    <span class="status-badge-wp status-top3">
                                        <i class="bi bi-star me-1"></i>Top 3
                                    </span>
                                @else
                                    <span class="status-badge-wp status-alt">
                                        Alternatif
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state-wp">
                                    <div class="empty-icon">
                                        <i class="bi bi-calculator"></i>
                                    </div>
                                    <h5>Belum Ada Hasil Perhitungan</h5>
                                    <p class="text-muted">Silakan lakukan penilaian terlebih dahulu.</p>
                                    <a href="{{ route('penilaian.index') }}" class="btn btn-primary">
                                        <i class="bi bi-pencil-square me-2"></i>Input Penilaian
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="info-card-wp mt-4">
        <div class="info-icon">
            <i class="bi bi-info-circle-fill"></i>
        </div>
        <div class="info-content">
            <strong>Keterangan:</strong><br>
            <span class="text-muted">
                • <strong>Vector S:</strong> Hasil perkalian nilai ternormalisasi pangkat bobot kriteria.<br>
                • <strong>Vector V:</strong> Nilai preferensi relatif (Total V semua alternatif = 1). Semakin tinggi nilai V, semakin direkomendasikan.
            </span>
        </div>
    </div>

    {{-- RUMUS WP CARD --}}
    <div class="formula-card-wp mt-4">
        <div class="formula-card-header-wp">
            <i class="bi bi-calculator me-2"></i>
            <strong>Rumus Metode Weighted Product (WP)</strong>
        </div>
        <div class="formula-card-body-wp">
            <div class="row g-4">
                {{-- Vector S --}}
                <div class="col-lg-6">
                    <div class="formula-box">
                        <div class="formula-title">
                            <span class="formula-badge">1</span>
                            <span>Vector S (Nilai Preferensi)</span>
                        </div>
                        <div class="formula-display-box">
                            <div class="formula-equation">
                                <span class="var-main">S<sub>i</sub></span>
                                <span class="equal-sign">=</span>
                                <span class="product-wrapper">
                                    <span class="product-top">n</span>
                                    <span class="product-symbol">∏</span>
                                    <span class="product-bottom">j=1</span>
                                </span>
                                <span class="var-main">X<sub>ij</sub></span><sup class="power-text">W<sub>j</sub></sup>
                            </div>
                        </div>
                        <div class="formula-legend">
                            <div class="legend-item">
                                <span class="legend-var">S<sub>i</sub></span>
                                <span class="legend-desc">Nilai S alternatif ke-i</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-var">X<sub>ij</sub></span>
                                <span class="legend-desc">Nilai alternatif ke-i kriteria ke-j</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-var">W<sub>j</sub></span>
                                <span class="legend-desc">Bobot kriteria ke-j</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Vector V --}}
                <div class="col-lg-6">
                    <div class="formula-box">
                        <div class="formula-title">
                            <span class="formula-badge">2</span>
                            <span>Vector V (Preferensi Relatif)</span>
                        </div>
                        <div class="formula-display-box">
                            <div class="formula-equation">
                                <span class="var-main">V<sub>i</sub></span>
                                <span class="equal-sign">=</span>
                                {{-- Fraction with product symbols --}}
                                <div class="fraction-box fraction-detailed">
                                    <div class="fraction-top">
                                        <span class="product-wrapper-sm">
                                            <span class="product-top-sm">n</span>
                                            <span class="product-symbol-sm">∏</span>
                                            <span class="product-bottom-sm">j=1</span>
                                        </span>
                                        <span class="var-sm">X<sub>ij</sub></span><sup class="power-sm">W<sub>j</sub></sup>
                                    </div>
                                    <div class="fraction-line"></div>
                                    <div class="fraction-bottom">
                                        <span class="product-wrapper-sm">
                                            <span class="product-top-sm">n</span>
                                            <span class="product-symbol-sm">∏</span>
                                            <span class="product-bottom-sm">j=1</span>
                                        </span>
                                        <span class="var-sm">X<sub>ij</sub><sup class="power-sm-star">*</sup></span><sup class="power-sm">W<sub>j</sub></sup>
                                    </div>
                                </div>
                                <span class="equal-sign">=</span>
                                {{-- Simplified fraction --}}
                                <div class="fraction-box fraction-simple">
                                    <div class="fraction-top">S<sub>i</sub></div>
                                    <div class="fraction-line"></div>
                                    <div class="fraction-bottom">∑ S<sub>i</sub></div>
                                </div>
                            </div>
                        </div>
                        <div class="formula-legend">
                            <div class="legend-item">
                                <span class="legend-var">V<sub>i</sub></span>
                                <span class="legend-desc">Nilai preferensi relatif alternatif ke-i</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-var">∑S<sub>i</sub></span>
                                <span class="legend-desc">Total nilai S semua alternatif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection