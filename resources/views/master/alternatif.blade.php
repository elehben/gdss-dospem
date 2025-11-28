@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/alternatif.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- HEADER BANNER --}}
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="page-banner-text">
                <h2 class="page-banner-title">Data Alternatif</h2>
                <p class="page-banner-subtitle">Kelola data dosen pembimbing sebagai alternatif pilihan</p>
            </div>
        </div>
        @if(auth()->user()->isAdmin())
        <button class="btn btn-light btn-add-banner" data-bs-toggle="modal" data-bs-target="#modalTambahAlt">
            <i class="bi bi-plus-lg me-2"></i>Tambah Dosen
        </button>
        @endif
        <div class="page-banner-decoration">
            <i class="bi bi-person-badge-fill"></i>
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
                    <i class="bi bi-people text-primary"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">Total Dosen</span>
                    <h3 class="mini-card-value">{{ $alternatif->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-card">
                <div class="mini-card-icon bg-success-subtle">
                    <i class="bi bi-mortarboard text-success"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">Siap Dinilai</span>
                    <h3 class="mini-card-value">{{ $alternatif->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-card">
                <div class="mini-card-icon bg-info-subtle">
                    <i class="bi bi-clipboard-check text-info"></i>
                </div>
                <div class="mini-card-content">
                    <span class="mini-card-label">Status</span>
                    <h5 class="mini-card-value text-success">Aktif</h5>
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
                            <th class="ps-4" style="width: 120px;">KODE</th>
                            <th>NAMA DOSEN</th>
                            <th class="text-center" style="width: 100px;">STATUS</th>
                            @if(auth()->user()->isAdmin()) <th class="text-center pe-4" style="width: 150px;">AKSI</th> @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alternatif as $index => $alt)
                        <tr>
                            <td class="ps-4">
                                <span class="code-badge">{{ $alt->id_alt }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="background: {{ ['#667eea', '#11998e', '#f093fb', '#00c6fb', '#f5576c', '#4facfe'][$index % 6] }}">
                                        {{ strtoupper(substr($alt->nama_alt, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="fw-semibold d-block">{{ $alt->nama_alt }}</span>
                                        <small class="text-muted">Dosen Pembimbing</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="status-badge status-active">
                                    <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                </span>
                            </td>
                            
                            @if(auth()->user()->isAdmin())
                            <td class="text-center pe-4">
                                <div class="action-buttons">
                                    <button class="btn-action btn-action-edit btn-edit-alt" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditAlt"
                                        data-id="{{ $alt->id_alt }}"
                                        data-nama="{{ $alt->nama_alt }}"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn-action btn-action-delete" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#hapus{{ $alt->id_alt }}"
                                        title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-person-x"></i>
                                    <p>Belum ada data alternatif</p>
                                    @if(auth()->user()->isAdmin())
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAlt">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Dosen
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
            <strong>Info:</strong> Data alternatif adalah daftar dosen yang akan dinilai oleh decision maker menggunakan metode Weighted Product (WP).
        </div>
    </div>
</div>

<!-- Modal -->
@if(auth()->user()->isAdmin())
{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahAlt" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('alternatif.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-person-plus me-2"></i>Tambah Dosen Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Alternatif</label>
                        <input type="text" name="id_alt" class="form-control" placeholder="Contoh: A01, A02, A03..." required>
                        <small class="text-muted">Gunakan format A01, A02, dst.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Dosen</label>
                        <input type="text" name="nama_alt" class="form-control" placeholder="Masukkan nama lengkap dosen" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEditAlt" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="formEditAlt" action="" method="POST">
            @csrf 
            @method('PUT')
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-pencil-square me-2"></i>Edit Data Dosen
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Alternatif</label>
                        <input type="text" id="edit_id_alt" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Dosen</label>
                        <input type="text" name="nama_alt" id="edit_nama_alt" class="form-control" placeholder="Masukkan nama lengkap dosen" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <i class="bi bi-save me-1"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
@foreach ($alternatif as $item)
<div class="modal fade" id="hapus{{ $item->id_alt }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('alternatif.destroy', $item->id_alt) }}" method="POST">
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
                        <i class="bi bi-person-x"></i>
                    </div>
                    <h5>Hapus Data Dosen?</h5>
                    <p class="text-muted mb-0">
                        Apakah Anda yakin ingin menghapus data<br>
                        <strong class="text-dark">"{{ $item->nama_alt }}"</strong>?
                    </p>
                    <p class="text-danger small mt-2">
                        <i class="bi bi-exclamation-circle me-1"></i>Data penilaian terkait juga akan terhapus!
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
    document.querySelectorAll('.btn-edit-alt').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;
            document.getElementById('formEditAlt').action = '/alternatif/' + id;
            document.getElementById('edit_id_alt').value = id;
            document.getElementById('edit_nama_alt').value = this.dataset.nama;
        });
    });
</script>
@endif
@endsection