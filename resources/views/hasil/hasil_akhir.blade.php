@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/borda.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- HEADER BANNER --}}
    <div class="page-banner-hasil mb-4">
        <div class="page-banner-content">
            <div class="page-banner-icon">
                <i class="bi bi-trophy-fill"></i>
            </div>
            <div class="page-banner-text">
                <h2 class="page-banner-title">Keputusan Akhir</h2>
                <p class="page-banner-subtitle">Penggabungan ranking WP dari seluruh Decision Maker</p>
                <p class="page-banner-subtitle">menggunakan Metode Borda</p>
            </div>
        </div>
        <form action="{{ route('hitung.borda') }}" method="POST">
            @csrf
            <button type="submit" class="btn-calculate">
                <i class="bi bi-calculator-fill me-2"></i>Hitung Hasil Akhir
            </button>
        </form>
        <div class="page-banner-decoration">
            <i class="bi bi-award-fill"></i>
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
    
    @if(session('error'))
        <div class="alert alert-danger alert-custom fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon-custom danger">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <div class="ms-3">{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- WINNER CARD (if data exists and has winner) --}}
    @if($hasil->isNotEmpty() && $hasil->first()->rangking_borda == 1)
    <div class="winner-card mb-4">
        <div class="winner-badge">
            <i class="bi bi-trophy-fill"></i>
        </div>
        <div class="winner-content">
            <span class="winner-label">Rekomendasi Dosen Pembimbing Terbaik</span>
            <h2 class="winner-name">{{ $hasil->first()->alternatif->nama_alt ?? '-' }}</h2>
            <div class="winner-stats">
                <div class="winner-stat">
                    <span class="stat-label">Kode</span>
                    <span class="stat-value">{{ $hasil->first()->id_alt }}</span>
                </div>
                <div class="winner-stat">
                    <span class="stat-label">Total Poin</span>
                    <span class="stat-value">{{ $hasil->first()->total_poin }}</span>
                </div>
                <div class="winner-stat">
                    <span class="stat-label">Nilai Borda</span>
                    <span class="stat-value">{{ number_format($hasil->first()->nilai_borda, 4) }}</span>
                </div>
            </div>
        </div>
        <div class="winner-decoration">
            <i class="bi bi-star-fill star-1"></i>
            <i class="bi bi-star-fill star-2"></i>
            <i class="bi bi-star-fill star-3"></i>
        </div>
    </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="mini-card-hasil">
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
            <div class="mini-card-hasil">
                <div class="mini-card-icon bg-gold">
                    <i class="bi bi-trophy"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">PERINGKAT 1</span>
                    <!-- <h3 class="mini-card-value">{{ $hasil->isNotEmpty() ? 1 : 0 }}</h3> -->
                    <h3 class="mini-card-value">{{ $hasil->first()->alternatif->id_alt }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="mini-card-hasil">
                <div class="mini-card-icon bg-teal">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">NILAI TERTINGGI</span>
                    <h3 class="mini-card-value">{{ $hasil->isNotEmpty() ? number_format($hasil->first()->nilai_borda, 2) : '-' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="mini-card-hasil">
                <div class="mini-card-icon bg-blue">
                    <i class="bi bi-check2-all"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">STATUS</span>
                    <h4 class="mini-card-value mini-card-status {{ $hasil->isNotEmpty() ? 'text-success' : 'text-warning' }}">
                        {{ $hasil->isNotEmpty() ? 'Selesai' : 'Pending' }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- RANKING TABLE --}}
    <div class="card table-card-hasil">
        <div class="card-header-hasil">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-bar-chart-fill"></i>
                <h5 class="mb-0">Peringkat Final</h5>
            </div>
            <span class="gdss-badge">
                <i class="bi bi-diagram-3-fill me-1"></i>GDSS Result
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hasil mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 100px;">RANKING</th>
                            <th style="width: 100px;">KODE</th>
                            <th>NAMA ALTERNATIF (DOSEN)</th>
                            <th class="text-center" style="width: 150px;">TOTAL POIN</th>
                            <th class="text-center" style="width: 140px;">NILAI BORDA</th>
                            <th class="text-center pe-4" style="width: 180px;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasil as $row)
                        <tr class="{{ $row->rangking_borda == 1 ? 'row-winner' : '' }}">
                            <td class="ps-4">
                                <div class="ranking-badge rank-{{ $row->rangking_borda <= 3 ? $row->rangking_borda : 'other' }}">
                                    @if($row->rangking_borda == 1)
                                        <i class="bi bi-trophy-fill"></i>
                                    @elseif($row->rangking_borda == 2)
                                        <i class="bi bi-award-fill"></i>
                                    @elseif($row->rangking_borda == 3)
                                        <i class="bi bi-award"></i>
                                    @endif
                                    <span>{{ $row->rangking_borda }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="code-badge-hasil">{{ $row->id_alt }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-hasil" style="background: {{ ['#f093fb', '#667eea', '#11998e', '#f5576c', '#4facfe', '#00c6fb'][$loop->index % 6] }}">
                                        {{ strtoupper(substr($row->alternatif->nama_alt ?? 'X', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="fw-semibold d-block">{{ $row->alternatif->nama_alt ?? '-' }}</span>
                                        <small class="text-muted">Dosen Pembimbing</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="poin-badge">
                                    <i class="bi bi-star-fill me-1"></i>{{ $row->total_poin }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="nilai-borda">{{ number_format($row->nilai_borda, 4) }}</span>
                            </td>
                            <td class="text-center pe-4">
                                @if($row->rangking_borda == 1)
                                    <span class="status-badge-hasil status-winner">
                                        <i class="bi bi-check-circle-fill me-1"></i>REKOMENDASI UTAMA
                                    </span>
                                @elseif($row->rangking_borda <= 3)
                                    <span class="status-badge-hasil status-top3">
                                        <i class="bi bi-star me-1"></i>Top 3
                                    </span>
                                @else
                                    <span class="status-badge-hasil status-alt">
                                        Alternatif
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state-hasil">
                                    <div class="empty-icon">
                                        <i class="bi bi-calculator"></i>
                                    </div>
                                    <h5>Belum Ada Hasil Perhitungan</h5>
                                    <p class="text-muted">Silakan klik tombol <strong>"Hitung Hasil Akhir"</strong> untuk memproses data.</p>
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
    <div class="info-card-hasil mt-4">
        <div class="info-icon">
            <i class="bi bi-lightbulb-fill"></i>
        </div>
        <div class="info-content">
            <strong>Logika Borda:</strong> 
            Setiap ranking WP dari masing-masing Decision Maker dikonversi menjadi poin (Rank 1 = Poin Tertinggi). 
            Alternatif dengan Total Poin terbesar akan mendapatkan ranking tertinggi sebagai rekomendasi utama.
        </div>
    </div>
</div>

@endsection