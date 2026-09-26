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
                    <td colspan="{{ count($header) }}" class="px-3 py-8 text-center opacity-50">Sem resultados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
