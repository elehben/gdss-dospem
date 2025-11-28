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
</div>

@endsection