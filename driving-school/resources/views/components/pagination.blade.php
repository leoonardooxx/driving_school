@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginação" class="flex items-center justify-between">
        <div class="text-md">
            A mostrar {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} de {{ $paginator->total() }}
        </div>
        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <x-layout.button aria-disabled="true" theme="white" icon="lucide-chevron-left" disabled />
            @else
                <x-layout.button theme="white" icon="lucide-chevron-left" aria-label="Anterior" rel="prev"
                    href="{{ $paginator->previousPageUrl() }}" />
            @endif

            <div class="flex gap-2 text-lg">
                @php
                    $current = $paginator->currentPage();
                    $last = $paginator->lastPage();
                    $pages = collect([1, $current - 1, $current, $current + 1, $last])
                        ->filter(fn($page) => $page >= 1 && $page <= $last)
                        ->unique()
                        ->sort()
                        ->values();
                @endphp
                @foreach ($pages as $index => $page)
                    @if ($index > 0 && $page - $pages[$index - 1] > 1)
                        <span aria-hidden="true">...</span>
                    @endif
                    @if ($page == $current)
                        <p aria-current="page" class="font-semibold">{{ $page }}</p>
                    @else
                        <a href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <x-layout.button rel="next" theme="white" icon="lucide-chevron-right" aria-label="Seguinte"
                    href="{{ $paginator->nextPageUrl() }}" />
            @else
                <x-layout.button aria-disabled="true" disabled rel="next" theme="white"
                    icon="lucide-chevron-right" />
            @endif
        </div>
    </nav>
@endif
