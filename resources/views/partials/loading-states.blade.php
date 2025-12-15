@push('styles')
<style>
/* Loading States */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.loading-overlay.dark {
    background: rgba(0, 0, 0, 0.8);
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid var(--light-gray);
    border-top: 4px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Skeleton Loaders */
.skeleton {
    background: linear-gradient(90deg, var(--light-gray) 25%, #e2e8f0 50%, var(--light-gray) 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.skeleton-text {
    height: 1rem;
    margin-bottom: 0.5rem;
    border-radius: 0.25rem;
}

.skeleton-text.title {
    height: 1.5rem;
    width: 70%;
}

.skeleton-text.subtitle {
    width: 50%;
}

.skeleton-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}

.skeleton-card {
    height: 200px;
    border-radius: 8px;
}

.skeleton-image {
    width: 100%;
    height: 150px;
    border-radius: 4px;
}

/* Card Loading State */
.card.loading {
    pointer-events: none;
    opacity: 0.7;
    position: relative;
}

.card.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.card.loading::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    margin: -20px 0 0 -20px;
    border: 3px solid var(--light-gray);
    border-top: 3px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 11;
}

/* Button Loading States */
.btn.loading {
    position: relative;
    color: transparent !important;
    pointer-events: none;
}

.btn.loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin: -10px 0 0 -10px;
    border: 2px solid currentColor;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 0.8s linear infinite;
}

/* Form Loading */
.form-loading {
    opacity: 0.6;
    pointer-events: none;
}

.form-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 32px;
    height: 32px;
    margin: -16px 0 0 -16px;
    border: 3px solid var(--light-gray);
    border-top: 3px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 1000;
}

/* Table Loading */
.table-loading {
    position: relative;
    min-height: 200px;
}

.table-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 48px;
    height: 48px;
    margin: -24px 0 0 -24px;
    border: 4px solid var(--light-gray);
    border-top: 4px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Page Loading */
.page-loading {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--bg-primary);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 9998;
}

.page-loading-spinner {
    width: 60px;
    height: 60px;
    border: 5px solid var(--light-gray);
    border-top: 5px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 1rem;
}

.page-loading-text {
    color: var(--text-secondary);
    font-size: 1rem;
    margin-top: 1rem;
}

/* Progress Bar */
.progress-bar-container {
    width: 100%;
    height: 4px;
    background: var(--light-gray);
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--success));
    transition: width 0.3s ease;
    animation: progress-shine 2s infinite;
}

@keyframes progress-shine {
    0% { background-position: -200% center; }
    100% { background-position: 200% center; }
}

/* Pulse Animation for Loading */
.pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .skeleton,
    .loading-spinner,
    .card.loading::before,
    .btn.loading::after,
    .form-loading::after,
    .page-loading-spinner,
    .table-loading::after {
        animation: none;
    }

    .progress-bar {
        animation: none;
    }

    .pulse {
        animation: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Loading state utilities
window.LoadingStates = {
    // Show global loading overlay
    show: function(text = 'Loading...') {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.innerHTML = `
            <div class="text-center">
                <div class="loading-spinner"></div>
                <p class="mt-3">${text}</p>
            </div>
        `;
        document.body.appendChild(overlay);
    },

    // Hide global loading overlay
    hide: function() {
        const overlay = document.querySelector('.loading-overlay');
        if (overlay) {
            overlay.remove();
        }
    },

    // Add loading to button
    button: function(button, loadingText = 'Loading...') {
        if (!button) return;

        const originalText = button.innerHTML;
        button.classList.add('loading');
        button.disabled = true;

        if (button.tagName === 'BUTTON') {
            // Keep original dimensions
            button.style.minWidth = button.offsetWidth + 'px';
        }

        return () => {
            button.classList.remove('loading');
            button.disabled = false;
            button.style.minWidth = '';
        };
    },

    // Add loading to card
    card: function(card) {
        if (!card) return;
        card.classList.add('loading');
        return () => card.classList.remove('loading');
    },

    // Show skeleton loading
    skeleton: function(container, items = 3) {
        let skeletonHtml = '';
        for (let i = 0; i < items; i++) {
            skeletonHtml += `
                <div class="skeleton skeleton-card mb-3"></div>
            `;
        }
        container.innerHTML = skeletonHtml;
    },

    // Progress bar
    progress: function(container, progress = 0) {
        const progressBar = `
            <div class="progress-bar-container">
                <div class="progress-bar" style="width: ${progress}%"></div>
            </div>
        `;
        if (typeof container === 'string') {
            document.querySelector(container).innerHTML = progressBar;
        } else {
            container.innerHTML = progressBar;
        }
    }
};

// Auto-initialize loading states
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide page loader after content loads
    setTimeout(() => {
        const pageLoader = document.getElementById('pageLoader');
        if (pageLoader) {
            pageLoader.classList.add('hidden');
            setTimeout(() => pageLoader.remove(), 500);
        }
    }, 500);

    // Handle form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.classList.contains('loading')) {
                LoadingStates.button(submitBtn);
            }
        });
    });

    // Handle navigation loading
    document.querySelectorAll('a[href]').forEach(link => {
        link.addEventListener('click', function(e) {
            // Skip for external links, downloads, or if modifier key is pressed
            if (
                this.hostname !== location.hostname ||
                this.href.includes('#') ||
                this.href.includes('mailto:') ||
                this.href.includes('tel:') ||
                e.ctrlKey || e.metaKey || e.shiftKey
            ) {
                return;
            }

            // Skip for forms, buttons, or links with onclick handlers
            if (this.closest('form') || this.tagName === 'BUTTON' || this.onclick) {
                return;
            }

            // Show loading for navigation
            LoadingStates.show('Memuat...');
        });
    });
});
</script>
@endpush