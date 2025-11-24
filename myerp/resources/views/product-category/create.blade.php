@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">

    {{-- LEFT: Product Category Form --}}
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Create Product Category</h2>

        <form action="{{ route('product-category.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" class="border p-2 w-full rounded"
                       value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Description</label>
                <input type="text" name="description" class="border p-2 w-full rounded"
                       value="{{ old('description') }}">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Parent Category</label>
                <select name="parent_id" class="border p-2 w-full rounded">
                    <option value="">-- None --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
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

    {{-- RIGHT: Accounting Setup Disabled --}}
    <div class="col-span-1 bg-gray-100 p-4 rounded shadow opacity-60 cursor-not-allowed">
        <h2 class="text-xl font-semibold mb-4 text-gray-500">Accounting Setup</h2>

        <p class="text-gray-500 text-sm">
            Accounting setup akan tersedia setelah Product Category berhasil dibuat.
        </p>

        {{-- Disabled inputs --}}
        <div class="mt-4 space-y-4">

            <div>
                <label class="block text-sm font-medium text-gray-500">Inventory Account</label>
                <select disabled class="border p-2 w-full rounded bg-gray-200"></select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500">COGS Account</label>
                <select disabled class="border p-2 w-full rounded bg-gray-200"></select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500">Sales Account</label>
                <select disabled class="border p-2 w-full rounded bg-gray-200"></select>
            </div>

        </div>
    </div>

</div>
@endsection
