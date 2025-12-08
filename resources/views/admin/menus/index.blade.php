@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Semua Menu</h2>
        <p class="text-muted mb-0">Daftar menu dari seluruh tenant untuk monitoring cepat.</p>
    </div>
</div>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <label class="form-label">Tenant</label>
        <select name="tenant_id" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Tenant</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" @selected(request('tenant_id') == $tenant->id)>{{ $tenant->nama_tenant }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <a href="{{ route('menus.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Menu</th>
                    <th>Tenant</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td>{{ $menu->nama_menu }}</td>
                        <td>{{ $menu->tenant->nama_tenant ?? '-' }}</td>
                        <td>{{ $menu->category->nama_kategori ?? '-' }}</td>
                        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td>{{ $menu->stok }}</td>
                        <td>
                            <span class="badge bg-{{ $menu->is_available ? 'success' : 'secondary' }}">
                                {{ $menu->is_available ? 'Tersedia' : 'Tidak Aktif' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada menu ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">
        {{ $menus->links() }}
    </div>
</div>
@endsection
