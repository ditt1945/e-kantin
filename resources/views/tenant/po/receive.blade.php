@extends('layouts.app')

@section('title', 'Receive Purchase Order - e-Kantin')

@section('content')
<div class="container py-3 py-md-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-check-double me-2 text-primary"></i>Receive PO Items
            </h2>
            <p class="text-muted small mb-0 d-none d-md-block">
                {{ $tenant->nama_tenant }} - PO #{{ $po->po_number }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tenant.po.show', $po) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                <span class="d-none d-sm-inline">Kembali</span>
            </a>
        </div>
    </div>

    <!-- PO Info -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-1">{{ $po->po_number }}</h6>
                    <div class="text-muted small">
                        Supplier: {{ $po->supplier_name }} •
                        Order Date: {{ $po->order_date->format('d M Y') }}
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="fw-bold">Total: Rp {{ number_format($po->total_amount, 0, ',', '.') }}</div>
                    <div class="text-muted small">{{ $po->items->count() }} items</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Receive Form -->
    <form method="POST" action="{{ route('tenant.po.receive.process', $po) }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-clipboard-check me-2"></i>Update Received Quantities
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Ordered</th>
                                <th class="text-center">Received</th>
                                <th class="text-center">Remaining</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($po->items as $item)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $item->item_name }}</div>
                                    @if($item->menu)
                                        <small class="text-muted">
                                            {{ $item->menu->category->nama_kategori ?? 'Uncategorized' }}
                                            • Current Stock: {{ $item->menu->stok }}
                                        </small>
                                    @endif
                                    @if($item->notes)
                                        <div class="small text-muted">Notes: {{ $item->notes }}</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fw-semibold">{{ $item->quantity }}</span>
                                </td>
                                <td class="text-center">
                                    <input type="number"
                                           name="received_quantities[{{ $item->id }}]"
                                           class="form-control form-control-sm text-center received-qty"
                                           value="{{ $item->received_quantity ?? 0 }}"
                                           min="0"
                                           max="{{ $item->quantity }}"
                                           step="0.1"
                                           required>
                                </td>
                                <td class="text-center">
                                    <span class="remaining-qty" data-total="{{ $item->quantity }}">
                                        {{ $item->quantity - ($item->received_quantity ?? 0) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="received-status text-muted">
                                        @if(($item->received_quantity ?? 0) >= $item->quantity)
                                            <span class="text-success"><i class="fas fa-check-circle"></i> Complete</span>
                                        @elseif(($item->received_quantity ?? 0) > 0)
                                            <span class="text-warning"><i class="fas fa-exclamation-circle"></i> Partial</span>
                                        @else
                                            <span class="text-secondary"><i class="fas fa-clock"></i> Pending</span>
                                        @endif
                                    </small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Receiving Guidelines</h6>
                            <ul class="mb-0 small">
                                <li>Enter the actual quantity received for each item</li>
                                <li>Stock will be automatically updated for menu items</li>
                                <li>PO status will be updated based on completion</li>
                                <li>You can update received quantities later if needed</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Ordered:</span>
                                    <span class="fw-bold" id="totalOrdered">{{ $po->items->sum('quantity') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Received:</span>
                                    <span class="fw-bold" id="totalReceived">{{ $po->items->sum('received_quantity') ?? 0 }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Remaining:</span>
                                    <span class="fw-bold text-warning" id="totalRemaining">
                                        {{ $po->items->sum('quantity') - ($po->items->sum('received_quantity') ?? 0) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('tenant.po.show', $po) }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i>Cancel
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i>Update Received Quantities
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const receivedInputs = document.querySelectorAll('.received-qty');

    function updateSummary() {
        let totalOrdered = 0;
        let totalReceived = 0;

        document.querySelectorAll('tbody tr').forEach(row => {
            const ordered = parseFloat(row.querySelector('td:nth-child(2) span').textContent) || 0;
            const received = parseFloat(row.querySelector('.received-qty').value) || 0;

            totalOrdered += ordered;
            totalReceived += received;

            // Update remaining
            const remainingSpan = row.querySelector('.remaining-qty');
            const remaining = ordered - received;
            remainingSpan.textContent = remaining;

            // Update status
            const statusSpan = row.querySelector('.received-status');
            if (received >= ordered) {
                statusSpan.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> Complete</span>';
            } else if (received > 0) {
                statusSpan.innerHTML = '<span class="text-warning"><i class="fas fa-exclamation-circle"></i> Partial</span>';
            } else {
                statusSpan.innerHTML = '<span class="text-secondary"><i class="fas fa-clock"></i> Pending</span>';
            }
        });

        // Update summary
        document.getElementById('totalOrdered').textContent = totalOrdered.toFixed(1);
        document.getElementById('totalReceived').textContent = totalReceived.toFixed(1);
        document.getElementById('totalRemaining').textContent = (totalOrdered - totalReceived).toFixed(1);
    }

    receivedInputs.forEach(input => {
        input.addEventListener('input', updateSummary);
    });

    // Initialize
    updateSummary();
});
</script>

<style>
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .received-qty {
        width: 100px;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.25rem;
        }

        .container {
            padding-left: 12px;
            padding-right: 12px;
        }

        .received-qty {
            width: 80px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.1rem;
        }
    }
</style>
@endsection