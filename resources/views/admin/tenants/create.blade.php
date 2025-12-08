@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Tambah Tenant</h2>
        <p class="text-muted mb-0">Daftarkan kantin baru dan hubungkan dengan pemilik.</p>
    </div>
    <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Tenant</label>
                    <input type="text" name="nama_tenant" value="{{ old('nama_tenant') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Pemilik</label>
                    <input type="text" name="pemilik" value="{{ old('pemilik') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pemilik (User)</label>
                    <select name="owner_user_id" class="form-select">
                        <option value="">- Pilih Pemilik -</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" @selected(old('owner_user_id') == $owner->id)>{{ $owner->name }} ({{ $owner->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktifkan Tenant</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
