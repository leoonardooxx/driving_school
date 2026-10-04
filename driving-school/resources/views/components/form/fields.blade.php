@props([
    'fields' => [],
    'editing' => false,
])

{{--
    Inputs of a create/edit form, built from the controller's form layout.
    Fields marked 'create_only' are disabled and hidden while editing.
--}}

@foreach ($fields as $field)
    @php($type = $field['type'] ?? 'text')
    @if ($field['create_only'] ?? false)
        <fieldset data-create-only @disabled($editing) class="min-w-0 flex flex-col gap-4 disabled:hidden">
    @endif

    @if ($type === 'avatar')
        <div class="flex items-center gap-4">
            <x-avatar-input :name="$field['name']" />
            <div class="flex-1 flex flex-col gap-4">
                <x-form.fields :fields="$field['beside'] ?? []" :editing="$editing" />
            </div>
        </div>
    @elseif ($type === 'select')
        <x-select :name="$field['name']" :label="$field['label']" theme="light" :value="$field['value'] ?? null" :options="$field['options']" />
    @elseif ($type === 'switch')
        <div class="flex items-center gap-3">
            <x-switch :name="$field['name']" :value="$errors->any() ? old($field['name']) : ($field['value'] ?? false)" />
            <span>{{ $field['label'] }}</span>
        </div>
    @else
        <x-input :type="$type" :name="$field['name']" :label="$field['label']" theme="light" />
    @endif

    @if ($field['create_only'] ?? false)
        </fieldset>
    @endif
@endforeach
