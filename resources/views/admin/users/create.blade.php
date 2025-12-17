@extends('layouts.app')

@section('title', 'Create User - e-Kantin Admin')

@section('content')
<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-user-plus me-2 text-primary"></i>Create User
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">Add new user to the system</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i><span class="d-none d-sm-inline">Back</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}" id="userForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">Full Name</label>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="Enter full name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold">Email Address</label>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="Enter email address"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Enter password"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                                    <input type="password"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                           placeholder="Confirm password"
                                           required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row" id="roleRow">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="role" class="form-label fw-bold">Role</label>
                                    <select id="role"
                                            name="role"
                                            class="form-select @error('role') is-invalid @enderror"
                                            required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="tenant_owner" {{ old('role') == 'tenant_owner' ? 'selected' : '' }}>Tenant Owner</option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6" id="tenantRow" style="display: none;">
                                <div class="mb-4">
                                    <label for="tenant_id" class="form-label fw-bold">Assign to Tenant</label>
                                    <select id="tenant_id"
                                            name="tenant_id"
                                            class="form-select @error('tenant_id') is-invalid @enderror">
                                        <option value="">Select Tenant</option>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                                {{ $tenant->nama_tenant }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Select tenant for tenant owner role</div>
                                    @error('tenant_id')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Role Information --}}
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2"></i>Role Information
                    </h6>
                    <div class="mb-3">
                        <h6 class="text-primary">Admin</h6>
                        <small class="text-muted">Full access to system administration</small>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-success">Tenant Owner</h6>
                        <small class="text-muted">Manage tenant menus, orders, and reports</small>
                    </div>
                    <div>
                        <h6 class="text-info">Customer</h6>
                        <small class="text-muted">Browse menus, place orders, and manage account</small>
                    </div>
                </div>
            </div>

            {{-- Password Requirements --}}
            <div class="card border-0 shadow-sm mt-3" style="border-radius: 12px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-lock me-2"></i>Password Requirements
                    </h6>
                    <div class="small text-muted">
                        <ul class="mb-0">
                            <li>At least 8 characters</li>
                            <li>Contains letters and numbers</li>
                            <li>Recommended: Use uppercase and symbols</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const tenantRow = document.getElementById('tenantRow');
    const tenantSelect = document.getElementById('tenant_id');

    roleSelect.addEventListener('change', function() {
        if (this.value === 'tenant_owner') {
            tenantRow.style.display = 'block';
            tenantSelect.required = true;
        } else {
            tenantRow.style.display = 'none';
            tenantSelect.required = false;
            tenantSelect.value = '';
        }
    });
});
</script>
@endsection