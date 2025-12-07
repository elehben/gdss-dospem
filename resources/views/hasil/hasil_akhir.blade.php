@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/borda.css') }}">
@endpush

@section('content')
<div class="container py-4">

    @if(auth()->check() && auth()->user()->isAdmin() || auth()->user()->isKadep())
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
            @if($wpSudahLengkap)
            <button type="submit" class="btn-calculate">
                <i class="bi bi-calculator-fill me-2"></i>Hitung Hasil Akhir
            </button>
            @else
            <button type="button" class="btn-calculate" data-bs-toggle="modal" data-bs-target="#modalWPBelumLengkap">
                <i class="bi bi-calculator-fill me-2"></i>Hitung Hasil Akhir
            </button>
            @endif
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
    @endif

    {{-- CHECK IF DATA IS EMPTY --}}
    @if($hasil->isEmpty())
    {{-- EMPTY STATE - Belum Ada Perhitungan --}}
    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body text-center py-5">
            <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.15) 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <i class="bi bi-calculator" style="font-size: 3.5rem; color: #f093fb;"></i>
            </div>
            <h4 style="font-weight: 700; color: #1a1a2e; margin-bottom: 0.75rem;">Belum Ada Hasil Perhitungan Borda</h4>
            <p class="text-muted mb-4" style="max-width: 450px; margin: 0 auto;">
                Hasil akhir menggunakan metode Borda belum tersedia. Pastikan semua Decision Maker telah melakukan penilaian dan perhitungan WP, kemudian klik tombol <strong>"Hitung Hasil Akhir"</strong>.
            </p>
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="info-card-hasil mt-4">
        <div class="info-icon">
            <i class="bi bi-info-circle-fill"></i>
        </div>
        <div class="info-content">
            <strong>Informasi:</strong> 
            Sebelum menghitung hasil akhir Borda, pastikan:
            <ul class="mb-0 mt-2">
                <li>Semua Decision Maker telah melakukan penilaian</li>
                <li>Perhitungan WP untuk setiap Decision Maker sudah selesai</li>
            </ul>
        </div>
    </div>

    @else
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
    @endif
</div>

{{-- MODAL WP BELUM LENGKAP --}}
@if(!$wpSudahLengkap)
<div class="modal fade" id="modalWPBelumLengkap" tabindex="-1" aria-labelledby="modalWPBelumLengkapLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); padding: 1.5rem;">
                <h5 class="modal-title" id="modalWPBelumLengkapLabel" style="font-weight: 700; color: #5a3e00;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Perhitungan WP Belum Lengkap
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="padding: 2rem;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="bi bi-people-fill" style="font-size: 2rem; color: #5a3e00;"></i>
                </div>
                <h5 style="font-weight: 700; color: #1a1a2e; margin-bottom: 0.75rem;">Decision Maker Belum Melakukan Penilaian</h5>
                <p style="color: #6c757d; margin-bottom: 1rem;">
                    Beberapa Decision Maker belum melakukan penilaian atau perhitungan WP. Hasil Borda tidak dapat dihitung sebelum semua DM menyelesaikan penilaian mereka.
                </p>
                <div class="text-start" style="background: #fff3cd; border-radius: 12px; padding: 1rem; margin-bottom: 1rem;">
                    <strong style="color: #856404;"><i class="bi bi-person-x me-2"></i>Decision Maker yang belum input:</strong>
                    <ul class="mb-0 mt-2" style="color: #856404;">
                        @foreach($dmBelumWP as $nama)
                        <li>{{ $nama }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection