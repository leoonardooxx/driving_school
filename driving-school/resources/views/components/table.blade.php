@props([
    'header' => [],
    'body' => [],
])

{{--
    example header =
    [
    'nome_do_campo' => ['label' => 'Label do Campo', 'component' => 'switch']
    ]

    example body =
    [
    'nome_do_campo' => 'Valor'
    ]
--}}

<div {{ $attributes->merge(['class' => 'overflow-x-auto']) }}>
    <table class="w-full border-collapse text-left text-[15px]">
        <thead>
            <tr class="border-b border-current/10">
                @foreach ($header as $column)
                    <th scope="col" class="px-3 py-4 font-normal opacity-60 whitespace-nowrap">{{ $column['label'] }}</th>
                @endforeach
                <th class="px-2">
                    <x-layout.button theme="white" icon="lucide-ellipsis-vertical" aria-label="Opções" class="ml-auto" />
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($body as $model)
                <tr class="border-b border-current/10 last:border-0">
                    @foreach ($header as $name => $column)
                        @php($value = data_get($model, $name))
                        <td class="px-3 py-5 whitespace-nowrap">
                            @if (isset($column['component']))
                                <x-dynamic-component :component="$column['component']" :name="$name" :value="$value" :aria-label="$column['label']" disabled />
                            @elseif (is_bool($value))
                                {{ $value ? 'Sim' : 'Não' }}
                            @elseif (blank($value))
                                <span class="opacity-40">-</span>
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    @endforeach

                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($header) + 1 }}" class="px-3 py-8 text-center opacity-50">Sem resultados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@if ($body instanceof \Illuminate\Contracts\Pagination\Paginator)
<script>
    (() => {
        const table = document.currentScript.previousElementSibling;
        const row = table.querySelector('tbody tr');
        if (!row) return;
        const tbody = row.parentElement.getBoundingClientRect();
        const nav = document.querySelector('nav[aria-label="Paginação"]');
        const below = (nav ? nav.getBoundingClientRect().bottom : table.getBoundingClientRect().bottom + 80) - tbody.bottom + 16;
        const perPage = Math.max(1, Math.floor((window.innerHeight - tbody.top - below) / row.offsetHeight));
        const current = {{ $body->perPage() }};
        if (perPage === current) return;
        document.cookie = `per_page=${perPage}; path=/; max-age=31536000; samesite=lax`;
        const url = new URL(location.href);
        url.searchParams.set('page', Math.floor(({{ $body->currentPage() }} - 1) * current / perPage) + 1);
        location.replace(url);
    })();
</script>
@endif
