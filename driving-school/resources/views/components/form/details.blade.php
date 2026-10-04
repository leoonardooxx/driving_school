@props([
    'fields' => [],
])

{{--
    Read-only version of a form layout, with the same sizes so switching to edit doesn't move anything.
    Each <dd> is filled by JS from the clicked row's cell named by data-column.
--}}

@foreach ($fields as $field)
    @continue($field['create_only'] ?? false)
    @php
        $type = $field['type'] ?? 'text';
        $data = collect([
            'data-column' => $field['column'] ?? $field['name'],
            'data-options' => isset($field['options']) ? json_encode($field['options']) : null,
        ])->filter(fn ($value) => $value !== null)->map(fn ($value, $key) => $key . '="' . e($value) . '"')->implode(' ');
    @endphp

    @if ($type === 'avatar')
        <div class="flex items-center gap-4">
            <dd {!! $data !!} class="size-20 shrink-0 rounded-full overflow-hidden border-2 border-black/10 bg-black/5 *:size-full! *:my-0! *:rounded-none!"></dd>
            <div class="flex-1 flex flex-col gap-4">
                <x-form.details :fields="$field['beside'] ?? []" />
            </div>
        </div>
    @elseif ($type === 'switch')
        <div class="flex items-center gap-3">
            <dd {!! $data !!} class="flex"></dd>
            <dt>{{ $field['label'] }}</dt>
        </div>
    @else
        <div class="relative border-b border-black">
            <dt class="absolute left-0 top-0 -translate-y-1/2 text-xs">{{ $field['label'] }}</dt>
            <dd {!! $data !!} class="min-h-11 pt-4 pb-1 text-base truncate"></dd>
        </div>
    @endif
@endforeach
