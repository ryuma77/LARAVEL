@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
    
    {{-- LEFT: Product Category Form --}}
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Product Category</h2>

        <form action="{{ route('product-category.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" class="border p-2 w-full rounded"
                       value="{{ $category->name }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Description</label>
                <input type="text" name="description" class="border p-2 w-full rounded"
                       value="{{ $category->description }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Parent Category</label>
                <select name="parent_id" class="border p-2 w-full rounded">
                    <option value="">-- None --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" @selected($p->id == $category->parent_id)>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
    <label class="block text-sm font-medium">Costing Method</label>
    <select name="costing_method" class="border p-2 rounded w-full" required>
        <option value="fifo" @if($category->costing_method === 'fifo') selected @endif>FIFO</option>
        <option value="average" @if($category->costing_method === 'average') selected @endif>Average Cost</option>
    </select>
</div>


            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
        </form>
    </div>

    {{-- RIGHT: Accounting Setup --}}
    <div class="col-span-1 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Accounting Setup</h2>

        <form action="{{ route('product-category.accounting.update', $category) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-medium">Inventory Account</label>
                <select name="inventory_account_id" class="border p-2 w-full rounded">
                    <option value="">-- None --</option>
                    @foreach($coa as $a)
                        <option value="{{ $a->id }}" @selected($category->accounting?->inventory_account_id == $a->id)>
                            {{ $a->code }} — {{ $a->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">COGS Account</label>
                <select name="cogs_account_id" class="border p-2 w-full rounded">
                    <option value="">-- None --</option>
                    @foreach($coa as $a)
                        <option value="{{ $a->id }}" @selected($category->accounting?->cogs_account_id == $a->id)>
                            {{ $a->code }} — {{ $a->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Sales Account</label>
                <select name="sales_account_id" class="border p-2 w-full rounded">
                    <option value="">-- None --</option>
                    @foreach($coa as $a)
                        <option value="{{ $a->id }}" @selected($category->accounting?->sales_account_id == $a->id)>
                            {{ $a->code }} — {{ $a->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded mt-4">Save</button>
        </form>
    </div>

</div>
@endsection
