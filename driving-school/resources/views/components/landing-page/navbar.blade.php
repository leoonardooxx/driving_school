@props(
['nav' => []]
)

<div class="w-full p-1 flex gap-2" data-navbar>
    <div id="left-side" class="shrink-0">
        <img src="{{ asset('logo_auth_white.png') }}" alt="" class="h-11" />
    </div>
    <div id="center" class="flex-1 min-w-0 flex justify-center gap-2" data-nav-center>
        @foreach ($nav as $item)
        <div class="shrink-0" data-nav-item @if (request()->routeIs(str_contains($item['route'], '.') ?
            Str::beforeLast($item['route'], '.') . '.*' : $item['route'])) data-nav-active @endif>
            <x-layout.button theme="white" :label="$item['label']"
                :icon="isset($item['dropdown']) ? $item['icon'] : null"
                :route="isset($item['dropdown']) ? null : $item['route']" :dropdown="$item['dropdown'] ?? []" />
        </div>
        @endforeach
        <div class="shrink-0" data-nav-all>
            <x-layout.button theme="white" label="All" icon="lucide-layout-grid" :highlight="false" :dropdown="array_map(
                fn ($item) => ['label' => $item['label'], 'route' => $item['route'], 'icon' => $item['icon']],
                $nav,
            )" />
        </div>
    </div>
    <div id="right-side" class="shrink-0 flex gap-2">
        <x-layout.button icon="lucide-settings" theme="white" aria-label="Definições" />
        <x-layout.button icon="lucide-bell" theme="white" aria-label="Notificações" />
        @if(auth()->check())
        @if (!empty(Auth::user()->image_url) )
        <x-layout.button theme="white" aria-label="Menu do utilizador" color="school_color" popovertarget="user-menu"
            class="overflow-hidden cursor-pointer">
            <img src="{{ Auth::user()->image_url }}" alt="" class="size-full object-cover" />
        </x-layout.button>
        @else
        <x-layout.button theme="white" aria-label="Menu do utilizador" color="school_color" popovertarget="user-menu"
            label="{{ substr(Auth::user()->name, 0, 1) }}">

        </x-layout.button>
        @endif
        <x-container theme="white" id="user-menu" popover="auto"
            class="inset-auto top-16 right-4 m-0 p-1! rounded-2xl! text-sm">
            <div class="px-2.5 py-1.5 font-medium">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</div>
            <div class="mx-1 my-1 border-t border-current/10"></div>
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-xl opacity-70 hover:opacity-100 hover:bg-current/5 cursor-pointer">
                    <x-lucide-log-out class="size-4" />
                    Terminar sessão
                </button>
            </form>
        </x-container>
        @endif



    </div>
</div>