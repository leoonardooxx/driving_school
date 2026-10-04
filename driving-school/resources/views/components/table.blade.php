@props([
    'header' => [],
    'body' => [],
    'table' => null,
    'selectable' => false,
    'icon' => null,
])

@php
    // Column choices are kept per table in the "table_columns" cookie as {table: {column: bool}};
    // columns the viewer never toggled fall back to show_on_table.
    $table ??= request()->route()?->getName() ?? 'table';
    $preferences = json_decode(request()->cookie('table_columns', ''), true);
    $preferences = is_array($preferences[$table] ?? null) ? $preferences[$table] : [];
    foreach ($header as $name => $column) {
        $header[$name]['visible'] = (bool) ($preferences[$name] ?? $column['show_on_table'] ?? true);
    }
    $columnsId = 'columns-' . uniqid();
    // Empty state uses the current page's navbar icon.
    $icon ??= collect(config('navigation.resources'))->first(fn ($page) => request()->routeIs("$page[1].*"))[2] ?? 'lucide-package';
@endphp

{{--
    example header =
    [
    'nome_do_campo' => ['label' => 'Label do Campo', 'component' => 'switch', 'show_on_table' => true],
    'image' => ['label' => 'Imagem', 'component' => 'table.image', 'rounded' => true, 'show_on_table' => true],
    'id' => ['label' => 'ID', 'show_on_table' => false]
    ]

    example body =
    [
    'nome_do_campo' => 'Valor'
    ]
--}}

<div data-table="{{ $table }}" {{ $attributes->merge(['class' => 'overflow-x-auto']) }}>
    <table class="w-full border-collapse text-left text-[15px]">
        <thead>
            <tr class="border-b border-current/10">
                @foreach ($header as $name => $column)
                    <th scope="col" data-column="{{ $name }}" @if (! $column['visible']) hidden @endif class="px-3 py-4 font-normal opacity-60 whitespace-nowrap">{{ $column['label'] }}</th>
                @endforeach
                <th class="px-2">
                    <x-layout.button theme="white" icon="lucide-ellipsis-vertical" aria-label="Colunas" class="ml-auto" popovertarget="{{ $columnsId }}" style="anchor-name: --{{ $columnsId }}" />
                    <x-container theme="white" id="{{ $columnsId }}" popover="auto" style="position-anchor: --{{ $columnsId }}; position-area: bottom span-left;" class="inset-auto m-0 mt-2 p-1! rounded-2xl! text-sm font-normal min-w-52 bg-white!">
                        @foreach ($header as $name => $column)
                            <div class="flex items-center justify-between gap-4 px-2.5 py-1.5 rounded-xl hover:bg-current/5">
                                <label for="{{ $columnsId }}-{{ $name }}" class="flex-1 cursor-pointer">{{ $column['label'] }}</label>
                                <x-switch :value="$column['visible']" id="{{ $columnsId }}-{{ $name }}" data-column-toggle="{{ $name }}" />
                            </div>
                        @endforeach
                    </x-container>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($body as $model)
                <tr @class(['border-b border-current/10 last:border-0 hover:bg-gray-50', 'cursor-pointer data-selected:bg-gray-100' => $selectable])>
                    @foreach ($header as $name => $column)
                        @php($value = data_get($model, $name))
                        <td data-column="{{ $name }}" @if (! $column['visible']) hidden @endif class="px-3 py-5 whitespace-nowrap">
                            @if (isset($column['component']))
                                <x-dynamic-component :component="$column['component']" :name="$name" :value="$value" :aria-label="$column['label']" :rounded="$column['rounded'] ?? false" disabled />
                            @elseif (is_bool($value))
                                {{ $value ? 'Sim' : 'Não' }}
                            @elseif (blank($value))
                                <span class="opacity-40">-</span>
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    @endforeach
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($header) + 1 }}" class="px-3 py-12">
                        <div class="flex items-center justify-center gap-4 opacity-50">
                            <x-dynamic-component :component="$icon" class="size-20 shrink-0" />
                            <div>
                                <div class="text-3xl font-semibold">Not Found</div>
                                <div class="text-lg font-medium opacity-80">Try again or create one!</div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <script>
        ((root) => {
            @if ($selectable)
            // Clicking a row marks it as selected and lets the page show its details.
            root.addEventListener('click', (event) => {
                const row = event.target.closest('tbody tr');
                if (!row?.querySelector('td[data-column]')) return;
                root.querySelectorAll('tr[data-selected]').forEach((selected) => selected.removeAttribute('data-selected'));
                row.toggleAttribute('data-selected', true);
                root.dispatchEvent(new CustomEvent('row-select', { bubbles: true, detail: { row } }));
            });
            @endif
            root.addEventListener('change', (event) => {
                const column = event.target.dataset.columnToggle;
                if (column === undefined) return;
                root.querySelectorAll(`[data-column="${CSS.escape(column)}"]`).forEach((cell) => cell.hidden = !event.target.checked);
                let preferences = {};
                try {
                    const match = document.cookie.match(/(?:^|; )table_columns=([^;]*)/);
                    preferences = match ? JSON.parse(decodeURIComponent(match[1])) : {};
                } catch {}
                (preferences[root.dataset.table] ??= {})[column] = event.target.checked;
                document.cookie = `table_columns=${encodeURIComponent(JSON.stringify(preferences))}; path=/; max-age=31536000; samesite=lax`;
            });
        })(document.currentScript.parentElement);
    </script>

</div>
@if ($body instanceof \Illuminate\Contracts\Pagination\Paginator)
<script>
    ((table) => document.addEventListener('DOMContentLoaded', () => {
        const row = table.querySelector('tbody tr');
        if (!row) return;
        // Document coordinates, so a restored scroll position doesn't change the result.
        const tbody = row.parentElement.getBoundingClientRect();
        const top = tbody.top + window.scrollY;
        const nav = document.querySelector('nav[aria-label="Paginação"]');
        // Space under the rows (container padding + pagination), ignoring a horizontal scrollbar,
        // which only shows on some pages and would make the result change from page to page.
        const scrollbar = table.offsetHeight - table.clientHeight;
        const below = (nav ? nav.getBoundingClientRect().bottom : table.getBoundingClientRect().bottom + 80) - tbody.bottom - scrollbar + 16;
        const perPage = Math.max(1, Math.floor((window.innerHeight - top - below) / row.getBoundingClientRect().height));
        const current = {{ $body->perPage() }};
        if (perPage === current) return;
        document.cookie = `per_page=${perPage}; path=/; max-age=31536000; samesite=lax`;
        const url = new URL(location.href);
        url.searchParams.set('page', Math.floor(({{ $body->currentPage() }} - 1) * current / perPage) + 1);
        location.replace(url);
    }))(document.currentScript.previousElementSibling);
</script>
@endif
