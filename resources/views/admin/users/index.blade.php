@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-users me-2 text-primary"></i>Kelola Pengguna
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">Kelola semua pengguna sistem e-Kantin</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Kembali</span>
        </a>
    </div>

    {{-- Desktop Table --}}
    <div class="card shadow-sm d-none d-lg-block" style="border-radius: 12px;">
        <div class="card-body p-3">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">Nama</th>
                                <th class="fw-bold">Email</th>
                                <th class="fw-bold">Role</th>
                                <th class="fw-bold">Kantin</th>
                                <th class="fw-bold">Bergabung</th>
                                <th class="fw-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td class="text-muted">{{ $user->email }}</td>
                                <td>
                                    <form method="POST" action="{{ route('users.update', $user) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                            <option value="tenant_owner" {{ $user->role === 'tenant_owner' ? 'selected' : '' }}>Tenant</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-muted">{{ $user->tenant->nama_tenant ?? '-' }}</td>
                                <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if($user->role !== 'admin')
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    </div>

    {{-- Mobile Cards --}}
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
                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                        <span class="badge bg-{{ $roleColor }}">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        @if($user->tenant)
                            <small class="text-muted"><i class="fas fa-store me-1"></i>{{ $user->tenant->nama_tenant }}</small>
                        @endif
                        <small class="text-muted"><i class="fas fa-calendar me-1"></i>{{ $user->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                        <form method="POST" action="{{ route('users.update', $user) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <select name="role" class="form-select form-select-sm" style="width: auto; font-size: 0.8rem;" onchange="this.form.submit()">
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="tenant_owner" {{ $user->role === 'tenant_owner' ? 'selected' : '' }}>Tenant</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                        @if($user->role !== 'admin')
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
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.2rem;
        }
        
        .container-fluid {
            padding-left: 12px;
            padding-right: 12px;
        }
    }
</style>
@endsection