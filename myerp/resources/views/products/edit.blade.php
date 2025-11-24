@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
    {{-- LEFT: product form --}}
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Product: {{ $product->name }}</h2>
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><label class="text-sm">SKU</label><input name="sku" value="{{ old('sku',$product->sku) }}" class="border p-2 w-full rounded"></div>
                <div><label class="text-sm">Type</label>
                    <select name="type" class="border p-2 w-full rounded">
                        <option value="item" @selected($product->type=='item')>Item</option>
                        <option value="service" @selected($product->type=='service')>Service</option>
                        <option value="expense" @selected($product->type=='expense')>Expense</option>
                        <option value="asset" @selected($product->type=='asset')>Asset</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="text-sm">Name</label>
                <input name="name" value="{{ old('name',$product->name) }}" class="border p-2 w-full rounded">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">Category</label>
                    <select name="category_id" class="border p-2 w-full rounded">
                        <option value="">--</option>
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected($product->category_id==$c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
    <label class="text-sm">UoM</label>
    <select name="uom_id" class="border p-2 w-full rounded">
        <option value="">-- Select UoM --</option>
        @foreach($uoms as $u)
        <option value="{{ $u->id }}" @selected($product->uom_id == $u->id)>
            {{ $u->code }} — {{ $u->name }}
        </option>
        @endforeach
    </select>
</div>

            </div>

            <div class="mb-4">
                <label class="text-sm">Description</label>
                <textarea name="description" class="border p-2 w-full rounded">{{ old('description',$product->description) }}</textarea>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save Product</button>
        </form>
    </div>

    {{-- RIGHT: carousel tabs using Alpine --}}
    <div class="col-span-1 bg-white p-4 rounded shadow" x-data="{tab:'summary'}">
        <div class="flex flex-col space-y-2">
            <button @click="tab='summary'" :class="tab==='summary' ? 'bg-indigo-600 text-white' : 'bg-gray-50' " class="p-2 rounded">Summary</button>
            <button @click="tab='purchase'" :class="tab==='purchase' ? 'bg-indigo-600 text-white' : 'bg-gray-50' " class="p-2 rounded">Purchase History</button>
            <button @click="tab='sales'" :class="tab==='sales' ? 'bg-indigo-600 text-white' : 'bg-gray-50' " class="p-2 rounded">Sales History</button>
            <button @click="tab='movements'" :class="tab==='movements' ? 'bg-indigo-600 text-white' : 'bg-gray-50' " class="p-2 rounded">Stock Movements</button>
            <button @click="tab='current'" :class="tab==='current' ? 'bg-indigo-600 text-white' : 'bg-gray-50' " class="p-2 rounded">Current Stock</button>
            <button @click="tab='acct'" :class="tab==='acct' ? 'bg-indigo-600 text-white' : 'bg-gray-50' " class="p-2 rounded">Accounting</button>
        </div>

        <div class="mt-4">
            <div x-show="tab==='summary'">
                <h4 class="text-sm font-medium">Summary</h4>
                <div class="text-sm text-gray-600 mt-2">
                    SKU: {{ $product->sku }}<br>
                    Category: {{ $product->category->name ?? '-' }}<br>
                    Type: {{ ucfirst($product->type) }}<br>
                </div>
            </div>

            <div x-show="tab==='purchase'">
                <h4 class="text-sm font-medium">Purchase History</h4>
                <div class="mt-2 text-sm">
                    @forelse($purchaseHistory as $h)
                        <div class="border-b py-2 text-xs">
                            {{ $h->created_at->format('Y-m-d') }} — {{ $h->ref_type }} — {{ $h->qty }}
                        </div>
                    @empty
                        <div class="text-xs text-gray-500">No purchases</div>
                    @endforelse
                </div>
            </div>

            <div x-show="tab==='sales'">
                <h4 class="text-sm font-medium">Sales History</h4>
                <div class="mt-2 text-sm">
                    @forelse($salesHistory as $h)
                        <div class="border-b py-2 text-xs">
                            {{ $h->created_at->format('Y-m-d') }} — {{ $h->ref_type }} — {{ $h->qty }}
                        </div>
                    @empty
                        <div class="text-xs text-gray-500">No sales</div>
                    @endforelse
                </div>
            </div>

            <div x-show="tab==='movements'">
                <h4 class="text-sm font-medium">Stock Movements</h4>
                <div class="mt-2 text-sm max-h-40 overflow-auto">
                    @forelse($stockMovements as $m)
                        <div class="border-b py-2 text-xs">
                            {{ $m->created_at->format('Y-m-d H:i') }} — {{ $m->ref_type }} — {{ $m->qty }}
                        </div>
                    @empty
                        <div class="text-xs text-gray-500">No movements</div>
                    @endforelse
                </div>
            </div>

            <div x-show="tab==='current'">
                <h4 class="text-sm font-medium">Current Stock</h4>
                <div class="mt-2 text-sm">
                    @forelse($stockSummary as $s)
                        <div class="py-2 text-xs">
                            Warehouse: {{ $s->warehouse?->name ?? '-' }} — Qty: {{ $s->qty }}
                        </div>
                    @empty
                        <div class="text-xs text-gray-500">No stock</div>
                    @endforelse
                </div>
            </div>

            <div x-show="tab==='acct'">
                <h4 class="text-sm font-medium">Accounting</h4>
                <form action="{{ route('products.accounting.update', $product) }}" method="POST" class="mt-2">
                    @csrf
                    <div class="mb-2">
                        <label class="text-xs">Inventory Account</label>
                        <select name="inventory_account_id" class="w-full border p-1 rounded text-sm">
                            <option value="">-- use category default --</option>
                            @foreach($coa as $a)
                            <option value="{{ $a->id }}" @selected(optional($product->accounting)->inventory_account_id == $a->id)>{{ $a->code }} - {{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="text-xs">COGS Account</label>
                        <select name="cogs_account_id" class="w-full border p-1 rounded text-sm">
                            <option value="">-- use category default --</option>
                            @foreach($coa as $a)
                            <option value="{{ $a->id }}" @selected(optional($product->accounting)->cogs_account_id == $a->id)>{{ $a->code }} - {{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="text-xs">Sales Account</label>
                        <select name="sales_account_id" class="w-full border p-1 rounded text-sm">
                            <option value="">-- use category default --</option>
                            @foreach($coa as $a)
                            <option value="{{ $a->id }}" @selected(optional($product->accounting)->sales_account_id == $a->id)>{{ $a->code }} - {{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3">
                        <button class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Save Accounting</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
