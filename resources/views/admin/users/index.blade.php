@extends('layouts.app')

@push('styles')
@include('partials.admin-professional-styles')
@endpush

@push('styles')
@include('partials.admin-minimalis-styles')
@endpush

@section('content')
<div class="admin-container">
    <!-- Professional Admin Header - Inside content area -->
    <div class="admin-header" style="background: var(--bg-primary); border-bottom: 1px solid var(--border); padding: 1rem; margin-bottom: 2rem; border-radius: var(--radius-lg);">
        <div class="admin-header-left">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                <img src="{{ asset('favicon-192.png') }}" alt="SMKN 2 Surabaya" style="width: 40px; height: 40px; border-radius: var(--radius-md);">
                <h1 class="admin-title">
                    <i class="fas fa-users"></i>
                    Kelola Pengguna
                </h1>
            </div>
            <p class="admin-subtitle">
                <i class="far fa-calendar-alt"></i>
                {{ now()->translatedFormat('l, d F Y') }} • Kelola Pengguna Sistem e-Kantin SMKN 2 Surabaya
            </p>
        </div>
        <div class="admin-header-right">
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- ===== STATISTICS ===== --}}
    <div class="admin-stats">
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $roleCounts->get('customer', 0) }}</div>
            <div class="admin-stat-label">Customers</div>
            <div class="admin-stat-change">Registered users</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $roleCounts->get('tenant_owner', 0) }}</div>
            <div class="admin-stat-label">Tenants</div>
            <div class="admin-stat-change">Store owners</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $roleCounts->get('admin', 0) }}</div>
            <div class="admin-stat-label">Admins</div>
            <div class="admin-stat-change">System admins</div>
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-value">{{ $users->total() }}</div>
            <div class="admin-stat-label">All Users</div>
            <div class="admin-stat-change">Total registered</div>
        </div>
    </div>

    {{-- ===== FILTERS ===== --}}
    <div class="admin-filter">
        <div class="admin-filter-title">
            <i class="fas fa-filter"></i>
            Filter Pengguna
        </div>
        <form method="GET">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-md);">
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Cari Pengguna</label>
                    <input type="text" name="search" class="form-control" placeholder="Masukkan nama atau email..." value="{{ request('search') }}">
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Role</label>
                    <select name="role" class="form-control">
                        <option value="">Semua Role</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer ({{ $roleCounts->get('customer', 0) }})</option>
                        <option value="tenant_owner" {{ request('role') == 'tenant_owner' ? 'selected' : '' }}>Tenant ({{ $roleCounts->get('tenant_owner', 0) }})</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin ({{ $roleCounts->get('admin', 0) }})</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: var(--space-sm); font-size: 0.875rem; font-weight: 500; color: var(--text-primary);">Tenant</label>
                    <select name="tenant" class="form-control">
                        <option value="">Semua Tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ request('tenant') == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->nama_tenant }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="admin-action-bar" style="margin-top: var(--space-md);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i>
                    Reset
                </a>
                <button type="button" class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Cetak
                </button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#checkRoleModal">
                    <i class="fas fa-search"></i>
                    Cek Role
                </button>
            </div>
        </form>
    </div>

    {{-- ===== USERS TABLE ===== --}}
    <div class="admin-table-container">
        <div class="admin-table-header">
            <div class="admin-table-title">
                <i class="fas fa-users"></i>
                Data Pengguna
            </div>
            <div class="admin-table-search">
                <input type="text" placeholder="Cari nama, email..." id="userSearch">
                <i class="fas fa-search"></i>
            </div>
        </div>

        @if($users->count() > 0)
            <table class="admin-table" id="usersTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tenant</th>
                        <th>Bergabung</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="user-row" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-role="{{ $user->role }}">
                            <td>
                                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                                    <div class="avatar" style="background: var(--primary);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->id == auth()->id())
                                            <span class="badge badge-success">You</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form method="POST" action="{{ route('users.update', $user) }}" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $user->name }}">
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                    <select name="role" class="form-control" style="width: auto;"
                                            @if($user->id == auth()->id()) disabled @endif
                                            onchange="if(confirm('Ubah role user {{ $user->name }}?')) this.form.submit()">
                                        <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>
                                            🛒 Customer
                                        </option>
                                        <option value="tenant_owner" {{ $user->role === 'tenant_owner' ? 'selected' : '' }}>
                                            🏢 Tenant
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
                            <td>{{ $user->tenant->nama_tenant ?? '-' }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div style="display: flex; gap: var(--space-xs); justify-content: flex-end;">
                                    @if($user->role !== 'admin' && $user->id != auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus user">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($users->hasPages())
                <div style="padding: var(--space-lg); display: flex; justify-content: center;">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <div class="empty-state-title">Belum Ada Pengguna</div>
                <div class="empty-state-text">Pengguna akan muncul setelah registrasi</div>
            </div>
        @endif
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time search functionality
    const searchInput = document.getElementById('userSearch');
    const tableRows = document.querySelectorAll('#usersTable tbody .user-row');

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Check Role functionality
    const btnCheckRole = document.getElementById('btnCheckRole');
    const checkEmail = document.getElementById('checkEmail');
    const roleResult = document.getElementById('roleResult');

    btnCheckRole.addEventListener('click', function() {
        const email = checkEmail.value.trim();

        if (!email) {
            alert('Masukkan email user');
            return;
        }

        fetch(`/users/check-role`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            roleResult.classList.remove('d-none');

            if (data.success) {
                roleResult.innerHTML = `
                    <div class="alert alert-success">
                        <strong>Role ditemukan!</strong><br>
                        Email: ${data.email}<br>
                        Role: ${data.role}<br>
                        Nama: ${data.name}<br>
                        Tenant: ${data.tenant ?? 'Tidak ada'}
                    </div>
                `;
            } else {
                roleResult.innerHTML = `
                    <div class="alert alert-danger">
                        User tidak ditemukan
                    </div>
                `;
            }
        })
        .catch(error => {
            roleResult.classList.remove('d-none');
            roleResult.innerHTML = `
                <div class="alert alert-danger">
                    Terjadi kesalahan saat mencari user
                </div>
            `;
        });
    });

    checkEmail.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            btnCheckRole.click();
        }
    });
});
</script>
@endsection