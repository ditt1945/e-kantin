@extends('layouts.app')

@section('title', 'Edit Purchase Order - e-Kantin')

@section('content')
<div class="container py-3 py-md-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
        <div>
            <h2 class="page-title mb-0">
                <i class="fas fa-edit me-2 text-primary"></i>Edit Purchase Order
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

    <form method="POST" action="{{ route('tenant.po.update', $po) }}" id="poForm">
        @csrf
        @method('PUT')

        <!-- Supplier Information -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-building me-2"></i>Informasi Supplier
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="supplier_name" class="form-label fw-semibold">Nama Supplier</label>
                        <input type="text" id="supplier_name" name="supplier_name" class="form-control"
                               value="{{ old('supplier_name', $po->supplier_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="supplier_contact" class="form-label fw-semibold">Kontak Supplier</label>
                        <input type="text" id="supplier_contact" name="supplier_contact" class="form-control"
                               value="{{ old('supplier_contact', $po->supplier_contact) }}" placeholder="No. HP atau Email">
                    </div>
                    <div class="col-md-6">
                        <label for="order_date" class="form-label fw-semibold">Tanggal Order</label>
                        <input type="date" id="order_date" name="order_date" class="form-control"
                               value="{{ old('order_date', $po->order_date->format('Y-m-d')) }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="expected_delivery_date" class="form-label fw-semibold">Tgl. Pengiriman Diharapkan</label>
                        <input type="date" id="expected_delivery_date" name="expected_delivery_date" class="form-control"
                               value="{{ old('expected_delivery_date', $po->expected_delivery_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label fw-semibold">Catatan</label>
                        <textarea id="notes" name="notes" class="form-control" rows="2"
                                  placeholder="Catatan khusus untuk PO ini">{{ old('notes', $po->notes) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- PO Items -->
        <div class="card mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2"></i>Item PO
                </h6>
                <button type="button" class="btn btn-sm btn-primary" onclick="addPoItem()">
                    <i class="fas fa-plus me-1"></i>Tambah Item
                </button>
            </div>
            <div class="card-body">
                <div id="poItemsContainer">
                    <!-- Existing PO Items -->
                    @foreach($po->items as $index => $item)
                    <div class="po-item-row border rounded p-3 mb-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pilih Menu</label>
                                <select class="form-select menu-select" required>
                                    <option value="">-- Pilih Menu --</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}"
                                                data-name="{{ $menu->nama_menu }}"
                                                data-price="{{ $menu->harga }}"
                                                {{ $item->menu_id == $menu->id ? 'selected' : '' }}>
                                            {{ $menu->nama_menu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                    <option value="custom" {{ !$item->menu_id ? 'selected' : '' }}>-- Custom Item --</option>
                                </select>
                                <input type="hidden" name="items[{{ $index }}][menu_id]" value="{{ $item->menu_id ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nama Item</label>
                                <input type="text" class="form-control item-name" name="items[{{ $index }}][name]"
                                       value="{{ old('items.' . $index . '.name', $item->item_name) }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control item-quantity" name="items[{{ $index }}][quantity]"
                                       value="{{ old('items.' . $index . '.quantity', $item->quantity) }}" min="0.1" step="0.1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Harga Satuan</label>
                                <input type="number" class="form-control item-price" name="items[{{ $index }}][price]"
                                       value="{{ old('items.' . $index . '.price', $item->unit_price) }}" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Total Harga</label>
                                <input type="text" class="form-control item-total" readonly>
                            </div>
                            <div class="col-md-9">
                                <label class="form-label fw-semibold">Catatan</label>
                                <input type="text" class="form-control item-notes" name="items[{{ $index }}][notes]"
                                       placeholder="Catatan item" value="{{ old('items.' . $index . '.notes', $item->notes) }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removePoItem(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- PO Summary -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-calculator me-2"></i>Ringkasan PO
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Subtotal:</span>
                            <span id="subtotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-5">Total:</span>
                            <span class="fw-bold fs-5 text-primary" id="totalAmount">Rp 0</span>
                        </div>
                        <input type="hidden" name="total_amount" id="totalAmountInput" value="{{ old('total_amount', $po->total_amount) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('tenant.po.show', $po) }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>Update PO
            </button>
        </div>
    </form>
</div>

<script>
let poItemCount = {{ $po->items->count() }};

function addPoItem() {
    poItemCount++;
    const container = document.getElementById('poItemsContainer');

    const itemRow = document.createElement('div');
    itemRow.className = 'po-item-row border rounded p-3 mb-3';
    itemRow.innerHTML = `
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Pilih Menu</label>
                <select class="form-select menu-select" required>
                    <option value="">-- Pilih Menu --</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}"
                                data-name="{{ $menu->nama_menu }}"
                                data-price="{{ $menu->harga }}">
                            {{ $menu->nama_menu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                    <option value="custom">-- Custom Item --</option>
                </select>
                <input type="hidden" name="items[${poItemCount}][menu_id]" value="">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Nama Item</label>
                <input type="text" class="form-control item-name" name="items[${poItemCount}][name]" required>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Quantity</label>
                <input type="number" class="form-control item-quantity" name="items[${poItemCount}][quantity]" min="0.1" step="0.1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Harga Satuan</label>
                <input type="number" class="form-control item-price" name="items[${poItemCount}][price]" min="0" step="0.01" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Total Harga</label>
                <input type="text" class="form-control item-total" readonly>
            </div>
            <div class="col-md-9">
                <label class="form-label fw-semibold">Catatan</label>
                <input type="text" class="form-control item-notes" name="items[${poItemCount}][notes]" placeholder="Catatan item">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removePoItem(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;

    container.appendChild(itemRow);
    attachItemListeners(itemRow);
}

function removePoItem(button) {
    const row = button.closest('.po-item-row');
    row.remove();
    calculateTotal();
}

function attachItemListeners(row) {
    const menuSelect = row.querySelector('.menu-select');
    const nameInput = row.querySelector('.item-name');
    const quantityInput = row.querySelector('.item-quantity');
    const priceInput = row.querySelector('.item-price');
    const totalInput = row.querySelector('.item-total');
    const menuIdInput = row.querySelector('input[type="hidden"]');

    menuSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            nameInput.readOnly = false;
            nameInput.value = '';
            priceInput.readOnly = false;
            priceInput.value = '';
            menuIdInput.value = '';
        } else if (this.value) {
            const option = this.options[this.selectedIndex];
            nameInput.readOnly = true;
            nameInput.value = option.dataset.name || '';
            priceInput.readOnly = true;
            priceInput.value = option.dataset.price || '';
            menuIdInput.value = this.value;
        } else {
            nameInput.readOnly = false;
            nameInput.value = '';
            priceInput.readOnly = false;
            priceInput.value = '';
            menuIdInput.value = '';
        }
        calculateItemTotal(row);
    });

    quantityInput.addEventListener('input', () => calculateItemTotal(row));
    priceInput.addEventListener('input', () => calculateItemTotal(row));
}

function calculateItemTotal(row) {
    const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
    const price = parseFloat(row.querySelector('.item-price').value) || 0;
    const total = quantity * price;
    row.querySelector('.item-total').value = `Rp ${total.toLocaleString('id-ID')}`;
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    document.querySelectorAll('.po-item-row').forEach(row => {
        const total = parseFloat(row.querySelector('.item-total').value.replace(/[^\d]/g, '')) || 0;
        subtotal += total;
    });

    document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
    document.getElementById('totalAmount').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
    document.getElementById('totalAmountInput').value = subtotal;
}

// Initialize existing items
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.po-item-row').forEach(row => {
        attachItemListeners(row);
        calculateItemTotal(row);
    });
});
</script>

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