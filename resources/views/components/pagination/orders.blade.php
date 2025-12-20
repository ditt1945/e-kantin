@if ($paginator && $paginator->hasPages())
    @once
        @push('styles')
        <style>
            .orders-pagination {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
                margin-top: 1.5rem;
            }
            .orders-pagination__info {
                color: #6c757d;
                font-size: 0.9rem;
            }
            .orders-pagination__nav {
                width: 100%;
                display: flex;
                justify-content: center;
            }
            .orders-pagination__list {
                list-style: none;
                display: flex;
                flex-wrap: wrap;
                gap: 0.35rem;
                padding: 0;
                margin: 0;
                justify-content: center;
            }
            .orders-pagination__btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 36px;
                height: 36px;
                padding: 0 0.75rem;
                border-radius: 999px;
                border: 1px solid #d8dee4;
                background: #ffffff;
                color: #0f172a;
                font-size: 0.9rem;
                line-height: 1;
                box-shadow: 0 4px 10px rgba(15, 23, 42, 0.06);
                transition: transform 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease, border-color 0.15s ease;
                text-decoration: none;
            }
            .orders-pagination__btn:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
                box-shadow: 0 6px 14px rgba(15, 23, 42, 0.08);
                transform: translateY(-1px);
            }
            .orders-pagination__btn.is-active {
                background: linear-gradient(135deg, #4f46e5, #0ea5e9);
                border-color: #4f46e5;
                color: #ffffff;
                box-shadow: 0 8px 18px rgba(79, 70, 229, 0.35);
                font-weight: 700;
            }
            .orders-pagination__btn.is-disabled {
                color: #cbd5e1;
                background: #f8fafc;
                border-color: #e2e8f0;
                box-shadow: none;
                cursor: not-allowed;
            }
            @media (max-width: 576px) {
                .orders-pagination {
                    margin-top: 1rem;
                    gap: 0.35rem;
                }
                .orders-pagination__btn {
                    min-width: 32px;
                    height: 32px;
                    padding: 0 0.65rem;
                    font-size: 0.85rem;
                }
                .orders-pagination__info {
                    font-size: 0.8rem;
                }
            }
        </style>
        @endpush
    @endonce

    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $window = 2;
        $pages = [];

        $pages[] = 1;

        $start = max(2, $currentPage - $window);
        $end = min($lastPage - 1, $currentPage + $window);

        if ($start > 2) {
            $pages[] = '...';
        }

        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        if ($end < $lastPage - 1) {
            $pages[] = '...';
        }

        if ($lastPage > 1) {
            $pages[] = $lastPage;
        }
    @endphp

    <div class="orders-pagination">
        @if ($paginator->total())
            <div class="orders-pagination__info">
                Menampilkan {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }} pesanan
            </div>
        @endif

        <nav class="orders-pagination__nav" role="navigation" aria-label="Pagination">
            <ul class="orders-pagination__list">
                @if ($paginator->onFirstPage())
                    <li><span class="orders-pagination__btn is-disabled" aria-disabled="true">&#8249;</span></li>
                @else
                    <li><a class="orders-pagination__btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">&#8249;</a></li>
                @endif

                @foreach ($pages as $page)
                    @if ($page === '...')
                        <li><span class="orders-pagination__btn is-disabled">...</span></li>
                    @elseif ($page == $currentPage)
                        <li><span class="orders-pagination__btn is-active">{{ $page }}</span></li>
                    @else
                        <li><a class="orders-pagination__btn" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li><a class="orders-pagination__btn" href="{{ $paginator->nextPageUrl() }}" rel="next">&#8250;</a></li>
                @else
                    <li><span class="orders-pagination__btn is-disabled" aria-disabled="true">&#8250;</span></li>
                @endif
            </ul>
        </nav>
    </div>
@endif
