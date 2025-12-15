@push('scripts')
<script>
// Favicon handling
document.addEventListener('DOMContentLoaded', function() {
    const faviconLinks = [
        { rel: 'icon', href: '{{ asset("favicon-192.png") }}', sizes: '192x192' },
        { rel: 'icon', href: '{{ asset("favicon.ico") }}', sizes: 'any' },
        { rel: 'shortcut icon', href: '{{ asset("favicon.ico") }}' }
    ];

    faviconLinks.forEach(linkData => {
        const link = document.createElement('link');
        Object.assign(link, linkData);
        document.head.appendChild(link);
    });

    // Handle broken logo images
    document.querySelectorAll('.loader-logo, .navbar-brand img').forEach(img => {
        img.addEventListener('error', function() {
            // Fallback to emoji or text logo
            if (this.classList.contains('loader-logo')) {
                this.outerHTML = '<div class="loader-logo-text">K</div>';
            } else {
                this.outerHTML = '<span>K</span>';
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.loader-logo-text {
    width: 100px;
    height: 100px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    font-weight: 700;
    color: var(--primary);
    background: var(--light-gray);
    border-radius: 50%;
    animation: pulse-scale 1.5s ease-in-out infinite;
}
</style>
@endpush