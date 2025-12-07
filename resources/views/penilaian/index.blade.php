@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/penilaian.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- HEADER BANNER --}}
    <div class="page-banner-penilaian mb-4">
        <div class="page-banner-content">
            <div class="page-banner-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="page-banner-text">
                <h2 class="page-banner-title">Input Penilaian</h2>
                <p class="page-banner-subtitle">Matriks Keputusan untuk Pemilihan Dosen Pembimbing</p>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="btn-back-penilaian">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
        <div class="page-banner-decoration">
            <i class="bi bi-clipboard-data-fill"></i>
        </div>
    </div>

    {{-- ALERTS --}}
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

    {{-- STATS CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="mini-card-penilaian">
                <div class="mini-card-icon bg-purple">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">TOTAL ALTERNATIF</span>
                    <h3 class="mini-card-value">{{ $alternatif->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="mini-card-penilaian">
                <div class="mini-card-icon bg-orange">
                    <i class="bi bi-list-check"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">TOTAL KRITERIA</span>
                    <h3 class="mini-card-value">{{ $kriteria->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="mini-card-penilaian">
                <div class="mini-card-icon bg-teal">
                    <i class="bi bi-grid-3x3"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">TOTAL INPUT</span>
                    <h3 class="mini-card-value">{{ $alternatif->count() * $kriteria->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="mini-card-penilaian">
                <div class="mini-card-icon bg-pink">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">PENILAI</span>
                    <h6 class="mini-card-value mini-card-name">{{ auth()->user()->name }}</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="card table-card-penilaian">
        <div class="card-header-penilaian">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-table"></i>
                <h5 class="mb-0">Matriks Penilaian</h5>
            </div>
            <span class="penilaian-badge">
                <i class="bi bi-calculator me-1"></i>Metode WP
            </span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('penilaian.store') }}" id="formPenilaian" method="POST">
                @csrf
                
                <div class="table-responsive">
                    <table class="table table-penilaian mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 60px;">NO</th>
                                <th style="min-width: 220px;">ALTERNATIF</th>
                                @foreach($kriteria as $k)
                                    <th class="text-center" style="min-width: 130px;">
                                        <div class="kriteria-header">
                                            <span class="kriteria-name">{{ $k->nama_kriteria }}</span>
                                            <span class="kriteria-code">{{ $k->id_kriteria }}</span>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alternatif as $index => $alt)
                            <tr>
                                <td class="ps-4">
                                    <span class="row-number">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-penilaian" style="background: {{ ['#667eea', '#11998e', '#f093fb', '#00c6fb', '#f5576c', '#4facfe', '#f093fb', '#43e97b'][$index % 8] }}">
                                            {{ strtoupper(substr($alt->nama_alt, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="fw-semibold d-block">{{ $alt->nama_alt }}</span>
                                            <span class="code-badge-penilaian">{{ $alt->id_alt }}</span>
                                        </div>
                                    </div>
                                </td>
                                
                                @foreach($kriteria as $k)
                                @php
                                    // Tentukan max value berdasarkan kriteria
                                    $maxValue = match($k->id_kriteria) {
                                        'C1' => 2,  // Tingkat Pendidikan (S2=1, S3=2)
                                        'C2' => 5,  // Jabatan Akademik (Pengajar-Profesor: 1-5)
                                        'C3' => 5,  // Masa Jabatan Kelompok (1-5)
                                        'C4' => 2,  // Sertifikasi Dosen (1-2)
                                        'C5' => 5,  // Prestasi 3 Pilar (1-5)
                                        default => 5
                                    };
                                @endphp
                                <td class="text-center">
                                    <input type="number" 
                                           name="nilai[{{ $alt->id_alt }}][{{ $k->id_kriteria }}]" 
                                           class="form-control-nilai input-nilai"
                                           value="{{ $dataNilai[$alt->id_alt][$k->id_kriteria] ?? '' }}"
                                           min="1" 
                                           max="{{ $maxValue }}" 
                                           required
                                           placeholder="1-{{ $maxValue }}"
                                           title="Nilai: 1 - {{ $maxValue }}">
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="action-bar mt-4">
                    <div class="action-info">
                        <i class="bi bi-info-circle text-muted me-2"></i>
                        <span class="text-muted">Isi nilai sesuai skala kriteria (lihat panduan di bawah)</span>
                    </div>
                    <div class="action-buttons">
                        <button type="button" class="btn-reset-penilaian" data-bs-toggle="modal" data-bs-target="#modalReset">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Kosongkan
                        </button>
                        <button type="submit" class="btn-submit-penilaian">
                            <i class="bi bi-calculator me-2"></i>Simpan & Hitung WP
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    {{-- INFO CARD - PANDUAN SKALA PENILAIAN --}}
    <div class="card table-card-penilaian mt-4">
        <div class="card-header-penilaian">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-lightbulb-fill"></i>
                <h5 class="mb-0">Panduan Skala Penilaian</h5>
            </div>
            <span class="penilaian-badge bg-warning text-dark">
                <i class="bi bi-info-circle me-1"></i>Referensi
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                {{-- C1: Tingkat Pendidikan --}}
                <div class="col-md-6 col-lg-4">
                    <div class="skala-card">
                        <div class="skala-header">
                            <span class="skala-badge">C1</span>
                            <h6 class="skala-title">Tingkat Pendidikan</h6>
                        </div>
                        <table class="table table-skala mb-0">
                            <thead>
                                <tr>
                                    <th>Kualifikasi</th>
                                    <th class="text-center">Skala</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>S2-Magister</td><td class="text-center"><span class="nilai-badge">1</span></td></tr>
                                <tr><td>S3-Doktor</td><td class="text-center"><span class="nilai-badge">2</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- C2: Jabatan Akademik --}}
                <div class="col-md-6 col-lg-4">
                    <div class="skala-card">
                        <div class="skala-header">
                            <span class="skala-badge">C2</span>
                            <h6 class="skala-title">Jabatan Akademik</h6>
                        </div>
                        <table class="table table-skala mb-0">
                            <thead>
                                <tr>
                                    <th>Kualifikasi</th>
                                    <th class="text-center">Skala</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Pengajar</td><td class="text-center"><span class="nilai-badge">1</span></td></tr>
                                <tr><td>Dosen</td><td class="text-center"><span class="nilai-badge">2</span></td></tr>
                                <tr><td>Dosen Senior</td><td class="text-center"><span class="nilai-badge">3</span></td></tr>
                                <tr><td>Dosen Asisten</td><td class="text-center"><span class="nilai-badge">4</span></td></tr>
                                <tr><td>Profesor</td><td class="text-center"><span class="nilai-badge">5</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- C3: Masa Jabatan Kelompok --}}
                <div class="col-md-6 col-lg-4">
                    <div class="skala-card">
                        <div class="skala-header">
                            <span class="skala-badge">C3</span>
                            <h6 class="skala-title">Masa Jabatan Kelompok</h6>
                        </div>
                        <table class="table table-skala mb-0">
                            <thead>
                                <tr>
                                    <th>Kualifikasi</th>
                                    <th class="text-center">Skala</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>0-5 tahun</td><td class="text-center"><span class="nilai-badge">1</span></td></tr>
                                <tr><td>6-10 tahun</td><td class="text-center"><span class="nilai-badge">2</span></td></tr>
                                <tr><td>11-15 tahun</td><td class="text-center"><span class="nilai-badge">3</span></td></tr>
                                <tr><td>16-20 tahun</td><td class="text-center"><span class="nilai-badge">4</span></td></tr>
                                <tr><td>> 20 tahun</td><td class="text-center"><span class="nilai-badge">5</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- C4: Sertifikasi Dosen --}}
                <div class="col-md-6 col-lg-4">
                    <div class="skala-card">
                        <div class="skala-header">
                            <span class="skala-badge">C4</span>
                            <h6 class="skala-title">Sertifikasi Dosen</h6>
                        </div>
                        <table class="table table-skala mb-0">
                            <thead>
                                <tr>
                                    <th>Kualifikasi</th>
                                    <th class="text-center">Skala</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Tidak bersertifikasi</td><td class="text-center"><span class="nilai-badge">1</span></td></tr>
                                <tr><td>Tersertifikasi</td><td class="text-center"><span class="nilai-badge">2</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- C5: Prestasi 3 Pilar Pendidikan Tinggi --}}
                <div class="col-md-6 col-lg-4">
                    <div class="skala-card">
                        <div class="skala-header">
                            <span class="skala-badge">C5</span>
                            <h6 class="skala-title">Pencapaian 3 Pilar</h6>
                        </div>
                        <table class="table table-skala mb-0">
                            <thead>
                                <tr>
                                    <th>Kualifikasi</th>
                                    <th class="text-center">Skala</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Sangat buruk</td><td class="text-center"><span class="nilai-badge">1</span></td></tr>
                                <tr><td>Buruk</td><td class="text-center"><span class="nilai-badge">2</span></td></tr>
                                <tr><td>Cukup</td><td class="text-center"><span class="nilai-badge">3</span></td></tr>
                                <tr><td>Baik</td><td class="text-center"><span class="nilai-badge">4</span></td></tr>
                                <tr><td>Sangat baik</td><td class="text-center"><span class="nilai-badge">5</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Info Tambahan --}}
                <div class="col-md-6 col-lg-4">
                    <div class="skala-card skala-info">
                        <div class="skala-header">
                            <span class="skala-badge bg-info">i</span>
                            <h6 class="skala-title">Informasi</h6>
                        </div>
                        <div class="skala-info-content">
                            <p><i class="bi bi-check-circle text-success me-2"></i>Semua kriteria bertipe <b> Benefit</b></p>
                            <p><i class="bi bi-arrow-up-circle text-primary me-2"></i>Nilai lebih tinggi = performa lebih baik</p>
                            <p><i class="bi bi-calculator text-warning me-2"></i>Sistem akan otomatis menghitung rangking dengan metode <strong>WP</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI RESET --}}
<div class="modal fade" id="modalReset" tabindex="-1" aria-labelledby="modalResetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-custom-penilaian">
            <div class="modal-header-custom warning">
                <div class="modal-icon-custom">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h5 class="modal-title" id="modalResetLabel">Konfirmasi Reset</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="modal-warning-icon mb-3">
                    <i class="bi bi-trash3"></i>
                </div>
                <h5 class="mb-2">Kosongkan Semua Data?</h5>
                <p class="text-muted mb-0">Apakah Anda yakin ingin mengosongkan semua isian pada form penilaian ini?</p>
                <small class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>Tindakan ini tidak dapat dibatalkan</small>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <button type="button" class="btn-modal-danger" id="btnConfirmReset">
                    <i class="bi bi-trash me-1"></i>Ya, Reset
                </button>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil tombol konfirmasi di dalam modal
        const btnConfirm = document.getElementById('btnConfirmReset');
        
        btnConfirm.addEventListener('click', function() {
            // 1. Ambil semua input dengan class 'input-nilai'
            const inputs = document.querySelectorAll('.input-nilai');
            
            // 2. Kosongkan nilainya
            inputs.forEach(function(input) {
                input.value = '';
            });

            // 3. Tutup Modal secara manual menggunakan Bootstrap API
            const modalElement = document.getElementById('modalReset');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();
        });
    });
</script>
@endpush

@endsection