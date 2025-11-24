<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4">
    <div class="flex items-center gap-4">
        {{-- small app logo --}}
        <div class="text-2xl font-bold text-indigo-600">erpMU</div>

        {{-- top nav breadcrumbs / quick links --}}
        <nav class="hidden sm:flex items-center gap-3 text-sm text-gray-600">
            <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-md hover:bg-gray-50">Dashboards</a>
            <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-50">Master</a>
            <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-50">Transactions</a>
        </nav>
    </div>

    <div class="flex items-center gap-4">
        {{-- search --}}
        <div class="hidden md:block">
            <input type="search" placeholder="Search..." class="px-3 py-2 border rounded-lg w-64 text-sm bg-gray-50 focus:outline-none">
        </div>

        {{-- notifications placeholder --}}
        <button class="p-2 rounded-md hover:bg-gray-50" title="Notifications">🔔</button>

        {{-- profile --}}
        <div class="flex items-center gap-3">
            <div class="text-right mr-2 hidden sm:block">
                <div class="text-sm font-medium">{{ auth()->user()->name ?? '' }}</div>
                <div class="text-xs text-gray-500">{{ auth()->user()->role->name ?? '-' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="px-3 py-2 bg-white border rounded-full text-sm hover:bg-gray-50">Log out</button>
            </form>
        </div>
    </div>
</header>
