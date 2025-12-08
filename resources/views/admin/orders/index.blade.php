@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="page-title mb-0"><i class="fas fa-clipboard-list me-2 text-primary"></i>Semua Pesanan</h2>
            <p class="text-muted mb-0 small d-none d-md-block">Monitoring status pesanan lintas tenant</p>
        </div>
    </div>

    <div class="card mb-3 shadow-sm">
        <div class="card-body py-2">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-6 col-md-4">
                    <label class="form-label small mb-1">Tenant</label>
                    <select name="tenant_id" class="form-select form-select-sm">
                        <option value="">Semua Tenant</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" @selected(request('tenant_id') == $tenant->id)>{{ $tenant->nama_tenant }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label small mb-1">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        @foreach(['pending' => 'Menunggu', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'dibatalkan' => 'Batal'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Desktop Table --}}
    <div class="card shadow-sm d-none d-md-block">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tenant</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-medium">{{ $order->kode_pesanan }}</td>
                            <td>{{ $order->tenant->nama_tenant ?? '-' }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-{{ $order->status === 'selesai' ? 'success' : ($order->status === 'diproses' ? 'warning' : ($order->status === 'dibatalkan' ? 'danger' : 'secondary')) }}">{{ ucfirst($order->status) }}</span></td>
                            <td>{{ optional($order->created_at)->format('d M Y H:i') }}</td>
                            <td class="text-end"><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- Mobile Cards --}}
    <div class="d-md-none">
        @forelse($orders as $order)
            @php
                $badgeClass = match($order->status) {
                    'selesai' => 'success',
                    'diproses' => 'warning',
                    'dibatalkan' => 'danger',
                    default => 'secondary',
                };
            @endphp
            <div class="card mb-2 border-start border-3 border-{{ $badgeClass }}">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $order->kode_pesanan }}</h6>
                            <small class="text-muted">{{ $order->tenant->nama_tenant ?? '-' }}</small>
                        </div>
                        <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block"><i class="fas fa-user me-1"></i>{{ $order->user->name ?? '-' }}</small>
                            <strong class="text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                        </div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    <small class="text-muted mt-1 d-block"><i class="fas fa-clock me-1"></i>{{ optional($order->created_at)->format('d M Y H:i') }}</small>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-2"></i>
                <p class="text-muted">Belum ada pesanan</p>
            </div>
        @endforelse
        <div class="mt-3">
            {{ $orders->links() }}
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
