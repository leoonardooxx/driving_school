@props([
    'id',
    'fields' => [],
    'route',
    'createTitle' => 'Create',
    'editTitle' => 'Edit',
])

{{--
    Create/edit container for a resource, built from the controller's form layout.
    The form element gets two methods:
      resetForm()   back to an empty create form
      editRow(row)  fills it from a selectable table row and submits it as an update
    The close button carries data-panel-close for the page around it (see resource-page).
--}}

@php
    $editing = old('_method') === 'PUT';
    // What the JS needs to read or reset each field; create-only fields are never filled from a row.
    $flat = collect($fields)
        ->flatMap(fn ($field) => [$field, ...($field['beside'] ?? [])])
        ->reject(fn ($field) => $field['create_only'] ?? false)
        ->map(fn ($field) => [
            'name' => $field['name'],
            'type' => $field['type'] ?? 'text',
            'column' => $field['column'] ?? $field['name'],
            'default' => $field['value'] ?? null,
        ])
        ->values();
@endphp

<x-container theme="white" {{ $attributes }}>
    <form id="{{ $id }}" action="{{ $editing ? route("$route.update", old('id')) : route("$route.store") }}" data-store="{{ route("$route.store") }}" data-create-title="{{ $createTitle }}" data-edit-title="{{ $editTitle }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        <input type="hidden" name="_method" value="PUT" @disabled(! $editing)>
        <input type="hidden" name="id" value="{{ old('id') }}" @disabled(! $editing)>
        <script type="application/json" data-form-fields>@json($flat)</script>
        <div class="flex justify-between items-center">
            <div data-form-title class="text-lg">{{ $editing ? $editTitle : $createTitle }}</div>
            <x-layout.button icon="lucide-x" theme="white" data-panel-close aria-label="Fechar"/>
        </div>

        <x-form.fields :fields="$fields" :editing="$editing" />

        @if ($errors->any())
            <ul class="text-sm text-red-500">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <x-button type="submit" theme="white">{{ $editing ? 'Save' : 'Create' }}</x-button>
    </form>
    <script>
        ((form) => {
            const fields = JSON.parse(form.querySelector('[data-form-fields]').textContent);

            // Sets an input from a value, according to the field type in the form layout.
            const setField = ({ name, type }, value) => {
                const input = form.querySelector(`[name="${CSS.escape(name)}"]`);
                if (type === 'avatar') {
                    const img = input.parentElement.querySelector('img');
                    value ? img.src = value : img.removeAttribute('src');
                } else if (type === 'switch') {
                    input.checked = Boolean(value);
                } else if (type === 'select') {
                    input.parentElement.querySelector(`[role=option][value="${CSS.escape(String(value ?? ''))}"]`)?.click();
                } else {
                    input.value = value ?? '';
                }
            };

            const setMode = (editing) => {
                form.querySelectorAll('[name=_method], [name=id]').forEach((input) => input.disabled = !editing);
                form.querySelectorAll('[data-create-only]').forEach((fieldset) => fieldset.disabled = editing);
                form.querySelector('[data-form-title]').textContent = editing ? form.dataset.editTitle : form.dataset.createTitle;
                form.querySelector('[type=submit]').textContent = editing ? 'Save' : 'Create';
            };

            form.resetForm = () => {
                if (form.action === form.dataset.store) return;
                form.reset();
                form.action = form.dataset.store;
                form.querySelectorAll('[type=password]').forEach((input) => input.value = '');
                fields.forEach((field) => setField(field, field.default));
                setMode(false);
            };

            form.editRow = (row) => {
                const id = row.querySelector('td[data-column=id]').textContent.trim();
                form.reset();
                form.action = `${form.dataset.store}/${id}`;
                form.querySelector('[name=id]').value = id;
                fields.forEach((field) => {
                    const cell = row.querySelector(`td[data-column="${CSS.escape(field.column)}"]`);
                    const value = {
                        avatar: () => cell.querySelector('img')?.src,
                        switch: () => cell.querySelector('input').checked,
                    }[field.type]?.() ?? (cell.querySelector('.opacity-40') ? '' : cell.textContent.trim());
                    setField(field, value);
                });
                setMode(true);
            };
        })(document.currentScript.previousElementSibling);
    </script>
</x-container>
