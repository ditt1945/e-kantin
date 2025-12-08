@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Detail Pesanan {{ $order->kode_pesanan }}</h2>
        <p class="text-muted mb-0">Status: {{ ucfirst($order->status) }}</p>
    </div>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Informasi Pemesan</h5>
                <p class="mb-1"><strong>Nama:</strong> {{ $order->user->name ?? '-' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
                <p class="mb-1"><strong>Tenant:</strong> {{ $order->tenant->nama_tenant ?? '-' }}</p>
                <p class="mb-1"><strong>Tanggal:</strong> {{ optional($order->created_at)->format('d M Y H:i') }}</p>
                <p class="mb-0"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Ringkasan Pembayaran</h5>
                <p class="mb-1"><strong>Total Harga:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                <p class="mb-1"><strong>Kode Pembayaran:</strong> {{ $order->payment->invoice_number ?? '-' }}</p>
                <p class="mb-0"><strong>Status Pembayaran:</strong> {{ ucfirst($order->payment->status ?? 'pending') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h5 class="mb-3">Item Pesanan</h5>
        <div class="table-responsive">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Menu</th>
                        <th>Kuantitas</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->menu->nama_menu ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
