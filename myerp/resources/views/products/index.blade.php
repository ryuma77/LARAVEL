@extends('layouts.app')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-semibold">Products</h1>
    <a href="{{ route('products.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Add Product</a>
</div>

<div class="bg-white p-4 rounded shadow">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2">SKU</th>
                <th>Name</th>
                <th>Category</th>
                <th>UoM</th>
                <th>Type</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr class="border-b">
                <td class="py-2">{{ $p->sku }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->category->name ?? '-' }}</td>
                <td>{{ $p->uom->name ?? '-' }}</td>
                <td>{{ ucfirst($p->type) }}</td>
                <td class="text-right">
                    <a href="{{ route('products.edit', $p) }}" class="text-indigo-600 hover:underline">
                        Edit
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
