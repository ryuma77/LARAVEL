@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Create Product</h2>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">SKU</label>
                    <input name="sku" value="{{ old('sku') }}" 
                           class="border p-2 w-full rounded" required>
                </div>

                <div>
                    <label class="text-sm">Type</label>
                    <select name="type" class="border p-2 w-full rounded">
                        <option value="item">Items</option>
                        <option value="service">Service</option>
                        <option value="expense">Expense</option>
                        <option value="asset">Asset</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm">Name</label>
                <input name="name" value="{{ old('name') }}" 
                       class="border p-2 w-full rounded" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">Category</label>
                    <select name="category_id" class="border p-2 w-full rounded">
                        <option value="">--</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm">UoM</label>
                    <select name="uom_id" class="border p-2 w-full rounded">
    <option value="">-- Select UoM --</option>
    @foreach($uoms as $u)
    <option value="{{ $u->id }}">
        {{ $u->code }} — {{ $u->name }}
    </option>
    @endforeach
</select>
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm">Description</label>
                <textarea name="description" class="border p-2 w-full rounded">{{ old('description') }}</textarea>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                Save
            </button>

        </form>
    </div>

    <div class="col-span-1 bg-gray-100 p-4 rounded shadow opacity-60 cursor-not-allowed">
        <h3 class="text-lg font-semibold text-gray-500">Right Tabs (Disabled)</h3>
        <p class="text-sm text-gray-500 mt-2">
            Tabs (summary, purchase, sales, stock, accounting) will be available after product is created.
        </p>
    </div>
</div>
@endsection
