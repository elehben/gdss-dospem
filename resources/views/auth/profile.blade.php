@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="container py-4">
    {{-- HEADER BANNER --}}
    <div class="page-banner-profile mb-4">
        <div class="page-banner-content">
            <div class="page-banner-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="page-banner-text">
                <h2 class="page-banner-title">Profil Saya</h2>
                <p class="page-banner-subtitle">Kelola informasi akun dan keamanan Anda</p>
            </div>
        </div>
        <div class="page-banner-decoration">
            <i class="bi bi-shield-check"></i>
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

    @if($errors->any())
        <div class="alert alert-danger alert-custom fade show" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon-custom danger">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <div class="ms-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- PROFILE CARD --}}
        <div class="col-lg-4">
            <div class="card profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <div class="profile-status">
                        @if($user->isAdmin())
                            <span class="badge-role admin">
                                <i class="bi bi-shield-fill-check me-1"></i>Administrator
                            </span>
                        @else
                            <span class="badge-role user">
                                <i class="bi bi-person-fill-check me-1"></i>Decision Maker
                            </span>
                        @endif
                    </div>
                </div>
                <div class="profile-body">
                    <h4 class="profile-name">{{ $user->name }}</h4>
                    <p class="profile-email"><i class="bi bi-envelope me-2"></i>{{ $user->email }}</p>
                    <div class="profile-info">
                        <div class="info-item">
                            <span class="info-label">ID User</span>
                            <span class="info-value">{{ $user->id_user }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Bergabung</span>
                            <span class="info-value">{{ $user->created_at ? $user->created_at->locale('id')->isoFormat('D MMMM Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORMS --}}
        <div class="col-lg-8">
            {{-- UPDATE PROFILE FORM --}}
            <div class="card form-card mb-4">
                <div class="form-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-person-gear"></i>
                        <h5 class="mb-0">Informasi Profil</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control form-control-custom" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control form-control-custom" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">ID User</label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-fingerprint"></i></span>
                                    <input type="text" class="form-control form-control-custom" value="{{ $user->id_user }}" disabled readonly>
                                </div>
                                <small class="text-muted">ID User tidak dapat diubah</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn-save-profile">
                                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- UPDATE PASSWORD FORM --}}
            <div class="card form-card">
                <div class="form-card-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock"></i>
                        <h5 class="mb-0">Ubah Password</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control form-control-custom" id="current_password" name="current_password" required>
                                    <button type="button" class="btn-toggle-password" onclick="togglePassword('current_password')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control form-control-custom" id="password" name="password" required>
                                    <button type="button" class="btn-toggle-password" onclick="togglePassword('password')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group-custom">
                                    <span class="input-icon"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control form-control-custom" id="password_confirmation" name="password_confirmation" required>
                                    <button type="button" class="btn-toggle-password" onclick="togglePassword('password_confirmation')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn-save-password">
                                <i class="bi bi-shield-check me-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endpush
@endsection
