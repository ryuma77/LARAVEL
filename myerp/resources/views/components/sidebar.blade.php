@php
/*
  Usage:
    include('components.sidebar', ['layer'=>1]) // layer 1: groups
    include('components.sidebar', ['layer'=>2]) // layer 2: submenu sets
*/
$layer = $layer ?? 1;

// Define menu skeleton (could be loaded from DB later)
$menu = [
    'configuration' => [
        'label' => 'Configuration',
        'children' => [
            ['id'=>'accounting_setup','label'=>'Accounting Setup','icon'=>'💼','href'=>'#','permission'=>'role.manage'],
            ['id'=>'currency_setup','label'=>'Currency Setup','icon'=>'💱','href'=>'#','permission'=>'role.manage'],
            ['id'=>'roles','label'=>'Role Management','icon'=>'🛡️','href'=>route('roles.index'),'permission'=>'role.manage'],
            ['id'=>'users','label'=>'User Management','icon'=>'👤','href'=>route('users.index'),'permission'=>'user.manage'],
['id'=>'coa','label'=>'Chart of Account','icon'=>'📘','href'=>route('coa.index'),'permission'=>'accounting.manage'],
        ],
    ],
    'master_data' => [
        'label' => 'Master Data',
        'children' => [
           ['id'=>'product','label'=>'Product','icon'=>'📦','href'=>route('products.index'),'permission'=>'inventory.view'],
['id'=>'category','label'=>'Category','icon'=>'🗂️','href'=>route('product-category.index'),'permission'=>'inventory.view'],
            ['id'=>'uom','label'=>'UoM','icon'=>'📏','href'=> route('uom.index'),'permission'=>'inventory.view'],
            ['id'=>'business_partner','label'=>'Business Partner','icon'=>'🏢','href'=>route('business-partner.index'),'permission'=>'user.manage'],
            ['id'=>'asset','label'=>'Asset','icon'=>'🏭','href'=>'#','permission'=>'asset.view'],
            ['id'=>'warehouse','label'=>'Warehouse','icon'=>'🏭','href'=>route('warehouses.index'),'permission'=>'inventory.view'],
        ],
    ],
    'transactions' => [
        'label' => 'Transactions',
        'children' => [
            ['id'=>'sales','label'=>'Sales','icon'=>'🛒','href'=>route('sales-order.index'),'permission'=>'purchase.view'],
             ['id'=>'shipment','label'=>'shipment','icon'=>'📦','href'=>route('shipments.index'),'permission'=>'inventory.view'],
            ['id'=>'purchase','label'=>'Purchase','icon'=>'📥','href'=>route('po.index'),'permission'=>'purchase.view'],
             ['id'=>'good-receipt','label'=>'Good Receipt','icon'=>'📦','href'=>route('good-receipt.index'),'permission'=>'inventory.manage'],
        ],
    ],
];
@endphp

@if($layer == 1)
    <div class="space-y-3">
        {{-- app title --}}
        <div class="px-2 py-3">
            <h1 class="text-lg font-bold text-gray-900">{{ config('app.name','RekaApp') }}</h1>
            <p class="text-sm text-gray-500 mt-1">Enterprise dashboard</p>
        </div>

        {{-- groups --}}
        <div class="mt-4">
            @foreach($menu as $key => $grp)
                {{-- check if any child visible by permission --}}
                @php
                    $visible = false;
                    foreach($grp['children'] as $c){
                        $visible = $visible || ( !isset($c['permission']) || ( auth()->check() && auth()->user()->hasPermission($c['permission']) ) );
                    }
                @endphp
                @if($visible)
                <button data-main-id="{{ $key }}" class="w-full flex items-center justify-between p-3 rounded-md text-left hover:bg-gray-50">
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $grp['label'] }}</div>
                    </div>
                    <div class="text-gray-400 text-sm">▾</div>
                </button>
                @endif
            @endforeach
        </div>

        {{-- bottom small info --}}
        <div class="mt-6 text-xs text-gray-500 px-2">
            <div>Role: <span class="font-medium text-gray-800">{{ auth()->user()->role->name ?? '-' }}</span></div>
            <div class="mt-2">Version: 0.1</div>
        </div>
    </div>
@else
    {{-- layer 2: render submenus for each main group; each group wrapped in data-subgroup attr --}}
    @foreach($menu as $key => $grp)
        @php
            // filter children by permission
            $children = array_filter($grp['children'], function($c){
                return !isset($c['permission']) || ( auth()->check() && auth()->user()->hasPermission($c['permission']) );
            });
        @endphp

        <div data-subgroup="{{ $key }}" class="space-y-3 {{ $loop->first ? '' : 'hidden' }}">
            <div class="mb-2 text-sm font-semibold text-gray-600 uppercase">{{ $grp['label'] }}</div>
            <div class="grid gap-2">
                @foreach($children as $c)
                    <div data-sub-id="{{ $c['id'] }}" data-href="{{ $c['href'] ?? '#' }}" class="flex items-center gap-3 p-3 rounded-md hover:bg-gray-50 cursor-pointer">
                        <div class="w-9 h-9 flex items-center justify-center bg-gray-100 rounded-md text-lg">{{ $c['icon'] }}</div>
                        <div class="text-sm font-medium">{{ $c['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endif
