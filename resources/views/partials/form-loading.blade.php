@push('scripts')
<script>
// Enhanced form loading states
document.addEventListener('DOMContentLoaded', function () {
    // Handle quantity change forms
    document.querySelectorAll('input[name="quantity"]').forEach((input) => {
        input.addEventListener('change', function () {
            const form = this.closest('form');
            if (form) {
                submitFormWithLoading(form, 'Menyimpan...');
            }
        });
    });

    // Handle delete forms
    document.querySelectorAll('form[method="DELETE"]').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                submitFormWithLoading(this, 'Menghapus...');
            }
        });
    });

    // Handle delete buttons with custom confirmation
    document.querySelectorAll('.btn-delete').forEach((btn) => {
        btn.closest('form').addEventListener('submit', function (e) {
            // The inline onsubmit will handle confirmation
            if (e.defaultPrevented) {
                return;
            }
            submitFormWithLoading(this, 'Menghapus...');
        });
    });

    // Handle checkout forms
    document.querySelectorAll('form[id^="checkout-form"]').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const spinner = submitBtn.querySelector('.spinner-border');
                const btnText = submitBtn.querySelector('.btn-text');

                submitBtn.disabled = true;
                if (spinner) spinner.classList.remove('d-none');
                if (btnText) btnText.textContent = 'Memproses pesanan...';

                // Submit after small delay
                setTimeout(() => {
                    this.submit();
                }, 500);
            }
        });
    });
});

// Generic form submit with loading
function submitFormWithLoading(form, loadingText) {
    const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');

    if (submitBtn) {
        const originalText = submitBtn.textContent || submitBtn.value;
        const spinner = document.createElement('i');
        spinner.className = 'fas fa-spinner fa-spin me-2';

        // Store original state
        const wasDisabled = submitBtn.disabled;
        submitBtn.disabled = true;

        // Add loading indicator
        if (submitBtn.tagName === 'BUTTON') {
            submitBtn.insertBefore(spinner.cloneNode(true), submitBtn.firstChild);
            submitBtn.textContent = loadingText;
        } else {
            submitBtn.value = loadingText;
        }

        // Submit form
        form.submit();

        // Restore after delay (in case form doesn't navigate)
        setTimeout(() => {
            submitBtn.disabled = wasDisabled;
            if (submitBtn.tagName === 'BUTTON') {
                submitBtn.removeChild(submitBtn.querySelector('.fa-spinner'));
                submitBtn.textContent = originalText;
            } else {
                submitBtn.value = originalText;
            }
        }, 5000);
    }
}
</script>
@endpush