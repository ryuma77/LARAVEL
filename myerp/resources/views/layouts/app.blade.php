<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? config('app.name', 'RekaApp') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800">

    {{-- Topbar --}}
    @include('components.topbar')

    <div class="flex h-[calc(100vh-64px)]">
        {{-- Layer 1: Main Groups --}}
        <aside id="sidebar-layer-1" class="w-64 bg-white border-r border-gray-200 p-3 overflow-auto">
            @include('components.sidebar', ['layer' => 1])
        </aside>

        {{-- Layer 2: Submenu (collapsible) --}}
        <aside id="sidebar-layer-2" class="w-72 bg-white border-r border-gray-200 p-3 overflow-auto hidden md:block">
            @include('components.sidebar', ['layer' => 2])
        </aside>

        {{-- Layer 3: Content --}}
        <main id="app-content" class="flex-1 p-6 overflow-auto min-w-0">  
            <div class="max-w-[1400px] mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Small inline JS to manage selected menu (no external libs) --}}
    <script>
(function () {

    const selMainKey = 'erp_selected_main';
    const selSubKey  = 'erp_selected_sub';

    // allowed main menu IDs (HARUS SAMA DENGAN sidebar layer-1)
    const validMain = ["configuration", "master_data", "transactions"];

    // Setters
    function setSelectedMain(id) {
        if (!validMain.includes(id)) return;   // cegah child disimpan sebagai main
        localStorage.setItem(selMainKey, id);
        // reset sub ketika ganti main
        localStorage.removeItem(selSubKey);
        renderSidebar();
    }

    function setSelectedSub(id) {
        localStorage.setItem(selSubKey, id);
        renderSidebar();
    }

    // Getters
    function getSelectedMain() {
        let v = localStorage.getItem(selMainKey);
        if (!validMain.includes(v)) {
            localStorage.setItem(selMainKey, "master_data");
            return "master_data";
        }
        return v;
    }

    function getSelectedSub() {
        return localStorage.getItem(selSubKey);
    }

    window.erp = { setSelectedMain, setSelectedSub, getSelectedMain, getSelectedSub };

    // Render highlight + visibility
    function renderSidebar() {

        // 1) highlight group layer-1
        document.querySelectorAll('[data-main-id]').forEach(el => {
            el.classList.remove('bg-gray-100','ring-1','ring-indigo-200');
            if (el.dataset.mainId === getSelectedMain()) {
                el.classList.add('bg-gray-100','ring-1','ring-indigo-200');
            }
        });

        // 2) tampilkan submenu dari group aktif
        document.querySelectorAll('[data-subgroup]').forEach(el => {
            el.classList.toggle('hidden', el.dataset.subgroup !== getSelectedMain());
        });

        // 3) highlight submenu
        document.querySelectorAll('[data-sub-id]').forEach(el => {
            el.classList.remove('bg-indigo-600','text-white');
            if (el.dataset.subId === getSelectedSub()) {
                el.classList.add('bg-indigo-600','text-white');
            }
        });
    }

    // --------------------------------------------------
    // CLICK HANDLER (SUPER FIXED)
    // --------------------------------------------------
    document.addEventListener('click', function(e){

        // ---- Klik group (layer-1)
        const main = e.target.closest('[data-main-id]');
        if (main) {
            e.preventDefault();
            setSelectedMain(main.dataset.mainId);
            return;
        }

        // ---- Klik submenu (layer-2)
        const sub = e.target.closest('[data-sub-id]');
        if (sub) {
            e.preventDefault();
            setSelectedSub(sub.dataset.subId);

            const url = sub.dataset.href;
            if (url && url !== '#') {
                window.location.href = url;
            }
        }
    });

    // on load
    document.addEventListener('DOMContentLoaded', renderSidebar);

})();
</script>


</body>
</html>
