<div class="w-full p-1 flex">
    <div id="left-side">
        <img src="{{ asset('logo_auth_white.png') }}" alt="" class="h-11" />
    </div>
    <div id="center" class="mx-auto flex gap-2">
        <x-layout.button theme="white" label="Dashboard" route="dashboard" />
        <x-layout.button theme="white" label="Categories" :dropdown="[
            ['label' => 'See all', 'route' => 'categories.index', 'icon' => 'lucide-eye'],
            ['label' => 'New category', 'route' => 'categories.create', 'icon' => 'lucide-plus'],
        ]" />
        <x-layout.button theme="white" label="Users" :dropdown="[
            ['label' => 'See all', 'route' => 'users.index', 'icon' => 'lucide-eye'],
            ['label' => 'New user', 'route' => 'users.create', 'icon' => 'lucide-plus'],
        ]" />
    </div>
    <div id="right-side" class="flex gap-2">
        <x-layout.button icon="lucide-settings" theme="white" aria-label="Definições" />
        <x-layout.button icon="lucide-bell" theme="white" aria-label="Notificações" />
        <x-layout.button theme="white" aria-label="Menu do utilizador" color="school_color" popovertarget="user-menu"
            label="{{ substr(Auth::user()->name, 0, 1) }}">

        </x-layout.button>
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


    </div>
</div>
