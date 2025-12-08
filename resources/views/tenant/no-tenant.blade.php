@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-store fa-4x mb-4" style="color: var(--text-secondary);"></i>
                    <h3 class="mb-3">No Tenant Assigned</h3>
                    <p class="text-secondary mb-4">
                        You don't have a tenant (canteen) assigned to your account yet.
                        Please contact the administrator to set up your tenant.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
