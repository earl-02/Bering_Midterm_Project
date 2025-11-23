<aside class="min-w-[220px] bg-white border-r border-gray-100 shadow-sm flex flex-col">
    <div class="p-4 border-b">
        <h1 class="font-semibold">Game Collection</h1>
    </div>

    <nav class="p-3 space-y-1 text-sm">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('platforms.index') }}"
           class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('platforms.*') ? 'bg-gray-100 font-semibold' : '' }}">
            Platforms
        </a>

        <a href="{{ route('games.index') }}"
           class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('games.*') ? 'bg-gray-100 font-semibold' : '' }}">
            Games
        </a>

        <a href="{{ route('profile.edit') }}"
           class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('profile.*') ? 'bg-gray-100 font-semibold' : '' }}">
            Settings
        </a>
    </nav>
</aside>
