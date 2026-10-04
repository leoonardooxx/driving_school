@props([
    'title',
    'route',
    'header' => [],
    'body' => [],
    'form' => [],
    'createTitle' => 'Create',
    'editTitle' => 'Edit',
    'detailsTitle' => 'Details',
])

{{--
    Index page of a resource: table on the left, and on the right either the create/edit form
    or the clicked row's details (data-open="create" | "details").
--}}

<div data-resource-page @if ($errors->any()) data-open="create" @endif class="group flex-1 grid grid-cols-[minmax(0,1fr)_auto] grid-rows-[auto_1fr] gap-3">
    <div class="text-[24px] min-h-11 flex items-center">
        {{ $title }}
    </div>
    <x-layout.button color="school_color" theme="white" icon="lucide-plus" :label="$createTitle" class="group-data-open:hidden" data-panel-create />

    <div class="col-span-2 group-data-open:col-span-1 flex flex-col gap-3 min-w-0">
        <x-container theme="white">
            <x-table :header="$header" :body="$body" selectable />
        </x-container>
        @if ($body instanceof \Illuminate\Pagination\AbstractPaginator)
            {{ $body->links() }}
        @endif
    </div>

    <x-form.panel id="{{ $route }}-form" :fields="$form" :route="$route" :create-title="$createTitle" :edit-title="$editTitle" class="hidden group-data-[open=create]:block col-start-2 row-start-1 row-span-2 w-md" />

    <x-container theme="white" class="hidden group-data-[open=details]:flex flex-col gap-4 col-start-2 row-start-1 row-span-2 w-md">
        <div class="flex justify-between items-center">
            <div class="text-lg">{{ $detailsTitle }}</div>
            <div class="flex gap-2">
                <x-layout.button icon="lucide-pencil" theme="white" data-panel-edit aria-label="Editar"/>
                <x-layout.button icon="lucide-x" theme="white" data-panel-close aria-label="Fechar"/>
            </div>
        </div>
        <dl data-details class="flex flex-col gap-4">
            <x-form.details :fields="$form" />
        </dl>
    </x-container>

    <script>
        ((page) => {
            const form = page.querySelector('form[data-store]');
            const selected = () => page.querySelector('tr[data-selected]');

            // The side panel shows either the form or the selected row's details, never both.
            const open = (panel) => {
                if (panel) page.dataset.open = panel;
                else page.removeAttribute('data-open');
                if (panel !== 'details') selected()?.removeAttribute('data-selected');
            };

            page.addEventListener('click', (event) => {
                if (event.target.closest('[data-panel-create]')) {
                    form.resetForm();
                    open('create');
                } else if (event.target.closest('[data-panel-edit]') && selected()) {
                    form.editRow(selected());
                    open('create');
                } else if (event.target.closest('[data-panel-close]')) {
                    open(null);
                }
            });

            page.addEventListener('row-select', ({ detail: { row } }) => {
                page.querySelectorAll('[data-details] dd[data-column]').forEach((field) => {
                    const cell = row.querySelector(`td[data-column="${CSS.escape(field.dataset.column)}"]`);
                    field.replaceChildren(...(cell ? cell.cloneNode(true).childNodes : []));
                    // Selects show the option label, not the stored value.
                    if (cell && field.dataset.options && !cell.querySelector('.opacity-40')) {
                        const value = cell.textContent.trim();
                        field.textContent = JSON.parse(field.dataset.options)[value] ?? value;
                    }
                });
                open('details');
            });
        })(document.currentScript.parentElement);
    </script>
</div>
