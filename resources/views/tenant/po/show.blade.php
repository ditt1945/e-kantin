@extends('layouts.app')

@section('title', 'Purchase Order Details - e-Kantin')

@section('content')
<div class="container py-3 py-md-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>PO Details
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">
                {{ $tenant->nama_tenant }} - Purchase Order #{{ $po->po_number }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tenant.po.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                <span class="d-none d-sm-inline">Kembali</span>
            </a>
            @if($po->isModifiable())
                <a href="{{ route('tenant.po.edit', $po) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-edit me-1"></i>
                    <span class="d-none d-sm-inline">Edit</span>
                </a>
            @endif
        </div>
    </div>

    <!-- PO Status & Summary -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <h5 class="mb-0 fw-bold">{{ $po->po_number }}</h5>
                                @php
                                    $statusInfo = $po->getStatusLabel();
                                @endphp
                                <span class="badge bg-{{ $statusInfo['color'] }} fs-6">{{ $statusInfo['text'] }}</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="small text-muted mb-1">Supplier</div>
                                    <div class="fw-semibold">{{ $po->supplier_name }}</div>
                                    @if($po->supplier_contact)
                                        <div class="small text-muted">{{ $po->supplier_contact }}</div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted mb-1">Order Date</div>
                                    <div class="fw-semibold">{{ $po->order_date->format('d M Y') }}</div>
                                    @if($po->expected_delivery_date)
                                        <div class="small text-muted">Expected: {{ $po->expected_delivery_date->format('d M Y') }}</div>
                                    @endif
                                </div>
                                @if($po->notes)
                                <div class="col-12">
                                    <div class="small text-muted mb-1">Notes</div>
                                    <div class="small">{{ $po->notes }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="small text-muted mb-1">Total Amount</div>
                            <div class="fw-bold fs-3 text-primary">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</div>
                            <div class="small text-muted">{{ $po->items->count() }} items</div>
                            <div class="small text-muted">Created by {{ $po->creator->name ?? 'System' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PO Items -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-bold">
                <i class="fas fa-list me-2"></i>Items
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-end">Quantity</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Total Price</th>
                            @if($po->status === 'delivered')
                            <th class="text-end">Received</th>
                            <th class="text-end">Remaining</th>
                            @endif
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($po->items as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->item_name }}</div>
                                @if($item->menu)
                                    <small class="text-muted">{{ $item->menu->category->nama_kategori ?? 'Uncategorized' }}</small>
                                @endif
                            </td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            @if($po->status === 'delivered')
                            <td class="text-end">{{ $item->received_quantity ?? 0 }}</td>
                            <td class="text-end">
                                <span class="text-muted">{{ $item->quantity - ($item->received_quantity ?? 0) }}</span>
                            </td>
                            @endif
                            <td>
                                @if($item->notes)
                                    <small class="text-muted">{{ $item->notes }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <th colspan="3">Total</th>
                            <th class="text-end fw-bold fs-5">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</th>
                            @if($po->status === 'delivered')
                            <th class="text-end">{{ $po->items->sum('received_quantity') ?? 0 }}</th>
                            <th class="text-end">{{ $po->items->sum('quantity') - ($po->items->sum('received_quantity') ?? 0) }}</th>
                            @endif
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Delivery Progress -->
    @if($po->status === 'delivered')
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-bold">
                <i class="fas fa-truck me-2"></i>Delivery Progress
            </h6>
        </div>
        <div class="card-body">
            @php
                $totalQty = $po->items->sum('quantity');
                $receivedQty = $po->items->sum('received_quantity');
                $percentage = $totalQty > 0 ? ($receivedQty / $totalQty) * 100 : 0;
            @endphp
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Progress</span>
                        <span class="fw-bold">{{ number_format($percentage, 1) }}%</span>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-success" role="progressbar"
                             style="width: {{ $percentage }}%"
                             aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="small text-muted mt-1">
                        {{ $receivedQty }} / {{ $totalQty }} items received
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    @if($percentage < 100)
                        <a href="{{ route('tenant.po.receive', $po) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-plus me-1"></i>Update Received
                        </a>
                    @else
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle me-1"></i>Complete
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Actions -->
    @if($po->status !== 'cancelled' && $po->status !== 'delivered')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">
                        Created: {{ $po->created_at->format('d M Y H:i') }} •
                        Updated: {{ $po->updated_at->diffForHumans() }}
                    </small>
                </div>
                <div class="d-flex gap-2">
                    @if($po->status === 'pending')
                        <form action="{{ route('tenant.po.confirm', $po) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Confirm this PO?')">
                                <i class="fas fa-check me-1"></i>Confirm PO
                            </button>
                        </form>
                        <form action="{{ route('tenant.po.cancel', $po) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this PO?')">
                                <i class="fas fa-times me-1"></i>Cancel PO
                            </button>
                        </form>
                    @elseif($po->status === 'confirmed')
                        <a href="{{ route('tenant.po.receive', $po) }}" class="btn btn-info">
                            <i class="fas fa-check-double me-1"></i>Receive Items
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.25rem;
        }

        .container {
            padding-left: 12px;
            padding-right: 12px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.1rem;
        }
    }
</style>
@endsection