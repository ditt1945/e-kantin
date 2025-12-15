@extends('layouts.app')

@include('partials.admin-styles')

@section('content')
<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="admin-page-title">
                    <i class="fas fa-users me-2"></i>Kelola Pengguna
                </h1>
                <p class="admin-page-subtitle">Kelola semua pengguna sistem e-Kantin</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="admin-action-bar justify-content-md-end">
                    <button type="button" class="admin-action-btn btn-info" data-bs-toggle="modal" data-bs-target="#checkRoleModal">
                        <i class="fas fa-search"></i>
                        <span>Cek Role</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="admin-action-btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="admin-alert admin-alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('warning') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="admin-alert admin-alert-danger">
            <i class="fas fa-times-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics -->
    <div class="admin-stats-row">
        <div class="admin-stats-card">
            <h5 class="text-primary mb-1">{{ $roleCounts->get('customer', 0) }}</h5>
            <h6 class="text-muted">Customers</h6>
        </div>
        <div class="admin-stats-card">
            <h5 class="text-warning mb-1">{{ $roleCounts->get('tenant_owner', 0) }}</h5>
            <h6 class="text-muted">Tenants</h6>
        </div>
        <div class="admin-stats-card">
            <h5 class="text-danger mb-1">{{ $roleCounts->get('admin', 0) }}</h5>
            <h6 class="text-muted">Admins</h6>
        </div>
        <div class="admin-stats-card">
            <h5 class="text-info mb-1">{{ $users->total() }}</h5>
            <h6 class="text-muted">Total Users</h6>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="admin-search-filter">
        <form method="GET" action="{{ route('users.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="admin-form-label">Cari User</label>
                    <input type="text" class="admin-form-control" name="search" placeholder="Masukkan nama atau email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="admin-form-label">Role</label>
                    <select class="admin-form-control" name="role">
                        <option value="">Semua Role</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer ({{ $roleCounts->get('customer', 0) }})</option>
                        <option value="tenant_owner" {{ request('role') == 'tenant_owner' ? 'selected' : '' }}>Tenant ({{ $roleCounts->get('tenant_owner', 0) }})</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin ({{ $roleCounts->get('admin', 0) }})</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="admin-form-label">Tenant</label>
                    <select class="admin-form-control" name="tenant">
                        <option value="">Semua Tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ request('tenant') == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->nama_tenant }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="admin-form-label">&nbsp;</label>
                    <div class="admin-action-bar">
                        <button type="submit" class="admin-action-btn btn-primary">
                            <i class="fas fa-filter"></i>
                            <span>Filter</span>
                        </button>
                        <a href="{{ route('users.index') }}" class="admin-action-btn btn-outline-secondary">
                            <i class="fas fa-sync"></i>
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Desktop Table -->
    <div class="admin-data-table d-none d-lg-block">
        @if($users->count() > 0)
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tenant</th>
                    <th>Tenant ID</th>
                    <th>Bergabung</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="fw-semibold">
                        {{ $user->name }}
                        @if($user->id == auth()->id())
                            <span class="badge bg-info ms-2">You</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        <form method="POST" action="{{ route('users.update', $user) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            <select name="role" class="form-select form-select-sm" style="width: auto;"
                                    @if($user->id == auth()->id()) disabled @endif
                                    onchange="if(confirm('Ubah role user {{ $user->name }}?')) this.form.submit()">
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>
                                    🛒 Customer
                                </option>
                                <option value="tenant_owner" {{ $user->role === 'tenant_owner' ? 'selected' : '' }}>
                                    🏢 Tenant Owner
                                </option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                    👤 Admin
                                </option>
                            </select>
                            @if($user->id == auth()->id())
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            @endif
                        </form>
                    </td>
                    <td class="text-muted">{{ $user->tenant->nama_tenant ?? '-' }}</td>
                    <td class="text-muted">{{ $user->tenant_id ?? '-' }}</td>
                    <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        @if($user->role !== 'admin' && $user->id != auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus user">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-2"></i>
            <h5 class="text-muted">Belum ada pengguna</h5>
            <p class="text-muted mb-0">Pengguna akan muncul setelah registrasi.</p>
        </div>
        @endif
    </div>

    <!-- Mobile Cards -->
    <div class="d-lg-none">
        @forelse($users as $user)
            @php
                $roleColor = match($user->role) {
                    'admin' => 'danger',
                    'tenant_owner' => 'warning',
                    default => 'primary',
                };
            @endphp
            <div class="card mb-2 border-start border-3 border-{{ $roleColor }}">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0 fw-bold">
                                {{ $user->name }}
                                @if($user->id == auth()->id())
                                    <span class="badge bg-info ms-2">You</span>
                                @endif
                            </h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                        <span class="badge bg-{{ $roleColor }}">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                        @if($user->tenant)
                            <small class="text-muted"><i class="fas fa-store me-1"></i>{{ $user->tenant->nama_tenant }}</small>
                        @endif
                        <small class="text-muted"><i class="fas fa-calendar me-1"></i>{{ $user->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                        <form method="POST" action="{{ route('users.update', $user) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            <select name="role" class="form-select form-select-sm" style="width: auto; font-size: 0.8rem;"
                                    @if($user->id == auth()->id()) disabled @endif
                                    onchange="if(confirm('Ubah role user {{ $user->name }}?')) this.form.submit()">
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="tenant_owner" {{ $user->role === 'tenant_owner' ? 'selected' : '' }}>Tenant</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @if($user->id == auth()->id())
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            @endif
                        </form>
                        @if($user->role !== 'admin' && $user->id != auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-2"></i>
                <h5 class="text-muted">Belum ada pengguna</h5>
            </div>
        @endforelse
        <div class="admin-pagination mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Check Role Modal -->
<div class="modal fade" id="checkRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-search me-2"></i>Cek Role User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Email User</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="checkEmail" placeholder="Masukkan email user...">
                        <button class="btn btn-primary" type="button" id="btnCheckRole">
                            <i class="fas fa-search"></i> Cek
                        </button>
                    </div>
                </div>
                <div id="roleResult" class="d-none">
                    <!-- Result will be shown here -->
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnCheckRole = document.getElementById('btnCheckRole');
    const checkEmail = document.getElementById('checkEmail');
    const roleResult = document.getElementById('roleResult');

    btnCheckRole.addEventListener('click', function() {
        const email = checkEmail.value.trim();

        if (!email) {
            alert('Masukkan email user');
            return;
        }

        btnCheckRole.disabled = true;
        btnCheckRole.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengecek...';

        fetch('{{ route("users.check-role") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            btnCheckRole.disabled = false;
            btnCheckRole.innerHTML = '<i class="fas fa-search"></i> Cek';

            if (data.error) {
                roleResult.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ${data.error}
                    </div>
                `;
            } else {
                let roleBadge = '';
                switch(data.role) {
                    case 'admin':
                        roleBadge = '<span class="badge bg-danger">Admin</span>';
                        break;
                    case 'tenant_owner':
                        roleBadge = '<span class="badge bg-warning">Tenant Owner</span>';
                        break;
                    default:
                        roleBadge = '<span class="badge bg-primary">Customer</span>';
                }

                roleResult.innerHTML = `
                    <div class="alert alert-success">
                        <h6>Informasi User:</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td>${data.name}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>${data.email}</td>
                            </tr>
                            <tr>
                                <td><strong>Role:</strong></td>
                                <td>${roleBadge}</td>
                            </tr>
                            ${data.tenant ? `
                            <tr>
                                <td><strong>Tenant:</strong></td>
                                <td>${data.tenant.nama_tenant} (ID: ${data.tenant.id})</td>
                            </tr>
                            ` : ''}
                            <tr>
                                <td><strong>Tenant ID:</strong></td>
                                <td>${data.tenant_id || 'Tidak ada'}</td>
                            </tr>
                            <tr>
                                <td><strong>Bergabung:</strong></td>
                                <td>${data.created_at}</td>
                            </tr>
                        </table>
                    </div>
                `;
            }
            roleResult.classList.remove('d-none');
        })
        .catch(error => {
            btnCheckRole.disabled = false;
            btnCheckRole.innerHTML = '<i class="fas fa-search"></i> Cek';
            roleResult.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Terjadi kesalahan: ${error.message}
                </div>
            `;
            roleResult.classList.remove('d-none');
        });
    });

    // Enter key support for email input
    checkEmail.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            btnCheckRole.click();
        }
    });
});
</script>
@endpush
@endsection