@push('styles')
<style>
/* Cart Page Styles */
.cart-item {
    background: var(--light-gray, #f8f9fa);
    border-radius: 10px;
    padding: 8px;
}

.quantity-input {
    width: 60px;
    padding: 6px 8px;
    text-align: center;
    font-weight: 600;
    font-size: 0.9rem;
    border: 2px solid #ddd;
    border-radius: 8px;
    outline: none;
    transition: all 0.2s ease;
}

.quantity-input:focus {
    border-color: var(--primary, #0d6efd);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn-delete {
    padding: 0.25rem 0.5rem;
}

.btn-delete:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.menu-name {
    font-size: 0.95rem;
}

.menu-price {
    color: var(--text-secondary, #6c757d);
    font-size: 0.85rem;
}

.menu-total {
    color: var(--primary, #0d6efd);
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
}

.cart-total {
    color: var(--primary, #0d6efd);
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
@endpush