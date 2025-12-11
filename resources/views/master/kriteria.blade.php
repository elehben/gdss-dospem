@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/kriteria.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- HEADER BANNER --}}
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-icon">
                <i class="bi bi-list-check"></i>
            </div>
            <div class="page-banner-text">
                <h2 class="page-banner-title">Data Kriteria</h2>
                <p class="page-banner-subtitle">Kelola kriteria penilaian untuk metode Weighted Product</p>
            </div>
        </div>
        @if(auth()->user()->isAdmin())
        <button class="btn btn-light btn-add-banner" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-2"></i>Tambah Kriteria
        </button>
        @endif
        <div class="page-banner-decoration">
            <i class="bi bi-gear-fill"></i>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-custom fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="ms-3">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="mini-card">
                <div class="mini-card-icon bg-primary-subtle">
                    <i class="bi bi-collection text-primary"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">Total Kriteria</span>
                    <h3 class="mini-card-value">{{ $kriteria->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-card">
                <div class="mini-card-icon bg-success-subtle">
                    <i class="bi bi-arrow-up-circle text-success"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">Benefit</span>
                    <h3 class="mini-card-value">{{ $kriteria->where('jenis', 'Benefit')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-card">
                <div class="mini-card-icon bg-danger-subtle">
                    <i class="bi bi-arrow-down-circle text-danger"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">Cost</span>
                    <h3 class="mini-card-value">{{ $kriteria->where('jenis', 'Cost')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card table-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">KODE</th>
                            <th>NAMA KRITERIA</th>
                            <th class="text-center">JENIS</th>
                            <th class="text-center">BOBOT</th>
                            <th class="text-center">NORMALISASI</th>
                            @if(auth()->user()->isAdmin()) <th class="text-center pe-4">AKSI</th> @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kriteria as $k)
                        <tr>
                            <td class="ps-4">
                                <span class="code-badge">{{ $k->id_kriteria }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="kriteria-icon">
                                        <i class="bi bi-{{ $k->jenis == 'Benefit' ? 'graph-up-arrow' : 'graph-down-arrow' }}"></i>
                                    </div>
                                    <span class="fw-semibold">{{ $k->nama_kriteria }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge-jenis {{ $k->jenis == 'Benefit' ? 'badge-benefit' : 'badge-cost' }}">
                                    <i class="bi bi-{{ $k->jenis == 'Benefit' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                    {{ $k->jenis }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-dark">{{ number_format($k->bobot, 2) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="progress-wrapper">
                                    <div class="progress" style="height: 8px; width: 100px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $k->bobot_normalisasi * 100 }}%"></div>
                                    </div>
                                    <span class="progress-value">{{ number_format($k->bobot_normalisasi, 4) }}</span>
                                </div>
                            </td>
                            
                            @if(auth()->user()->isAdmin())
                            <td class="text-center pe-4">
                                <div class="action-buttons">
                                    <button class="btn-action btn-action-edit btn-edit" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEdit"
                                        data-id="{{ $k->id_kriteria }}"
                                        data-nama="{{ $k->nama_kriteria }}"
                                        data-jenis="{{ $k->jenis }}"
                                        data-bobot="{{ $k->bobot }}"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn-action btn-action-delete" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#hapus{{ $k->id_kriteria }}"
                                        title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>Belum ada data kriteria</p>
                                    @if(auth()->user()->isAdmin())
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Kriteria
                                    </button>
                                    @endif
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
    <div class="info-card mt-4">
        <div class="info-card-icon">
            <i class="bi bi-info-circle"></i>
        </div>
        <div class="info-card-content">
            <strong>Keterangan:</strong>
            <span class="badge-jenis badge-benefit ms-2"><i class="bi bi-arrow-up me-1"></i>Benefit</span> = Semakin tinggi semakin baik
            <span class="mx-2">|</span>
            <span class="badge-jenis badge-cost"><i class="bi bi-arrow-down me-1"></i>Cost</span> = Semakin rendah semakin baik
        </div>
    </div>

    {{-- RUMUS CARD --}}
    <div class="formula-card mt-3">
        <div class="formula-card-header">
            <i class="bi bi-calculator me-2"></i>
            <strong>Rumus Normalisasi Bobot</strong>
        </div>
        <div class="formula-card-body">
            <div class="formula-display">
                <span class="formula-var">W<sub>j</sub></span>
                <span class="formula-equal">=</span>
                <div class="formula-fraction">
                    <span class="formula-numerator">W<sub>j</sub></span>
                    <span class="formula-denominator">∑ W<sub>j</sub></span>
                </div>
            </div>
            <div class="formula-description">
                <p class="mb-1"><strong>Keterangan:</strong></p>
                <ul class="mb-0">
                    <li><strong>W<sub>j</sub></strong> = Bobot kriteria ke-j yang sudah dinormalisasi</li>
                    <li><strong>W<sub>j</sub></strong> (pembilang) = Bobot awal kriteria ke-j</li>
                    <li><strong>∑W<sub>j</sub></strong> = Jumlah total semua bobot kriteria</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
@if(auth()->user()->isAdmin())
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/kriteria" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kriteria Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kriteria</label>
                        <input type="text" name="id_kriteria" class="form-control" placeholder="Contoh: C1, C2, C3..." required>
                        <small class="text-muted">Gunakan format C1, C2, dst.</small>
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
                        <small class="text-muted">Normalisasi akan dihitung otomatis</small>
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

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="formEdit" action="" method="POST">
            @method('PUT')
            @csrf 
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>Edit Kriteria
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kriteria</label>
                        <input type="text" id="edit_id" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kriteria</label>
                        <select name="jenis" id="edit_jenis" class="form-select">
                            <option value="Benefit">Benefit (Semakin tinggi semakin baik)</option>
                            <option value="Cost">Cost (Semakin rendah semakin baik)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bobot</label>
                        <input type="number" step="0.01" name="bobot" id="edit_bobot" class="form-control" required>
                        <small class="text-muted">Normalisasi akan diperbarui otomatis</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
@foreach ($kriteria as $item)
<div class="modal fade" id="hapus{{ $item->id_kriteria }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('kriteria.destroy', $item->id_kriteria) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="delete-icon mb-3">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h5>Hapus Kriteria?</h5>
                    <p class="text-muted mb-0">
                        Apakah Anda yakin ingin menghapus kriteria<br>
                        <strong class="text-dark">"{{ $item->nama_kriteria }}"</strong>?
                    </p>
                    <p class="text-danger small mt-2">
                        <i class="bi bi-exclamation-circle me-1"></i>Tindakan ini tidak dapat dibatalkan!
                    </p>
                </div>
                <div class="modal-footer justify-content-center border-0 pb-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-trash3 me-1"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    // Script untuk mengisi Modal Edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;
            document.getElementById('formEdit').action = '/kriteria/' + id;
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = this.dataset.nama;
            document.getElementById('edit_jenis').value = this.dataset.jenis;
            document.getElementById('edit_bobot').value = this.dataset.bobot;
        });
    });
</script>
@endif

@endsection