@extends('layouts.app')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-semibold">Product Categories</h1>
    <a href="{{ route('product-category.create') }}" 
       class="px-4 py-2 bg-indigo-600 text-white rounded">Add Category</a>
</div>

<div class="bg-white p-4 rounded shadow">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2">Name</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Updated At</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($categories as $cat)
                <tr class="border-b">
                    <td class="py-2">
                        @if($cat->parent_id)
                            <span class="text-gray-400">—</span>
                        @endif
                        {{ $cat->name }}
                    </td>

                    <td>
                        {{ $cat->parent->name ?? '-' }}
                    </td>

                    <td>
                        @if($cat->is_active)
                            <span class="text-green-600">Active</span>
                        @else
                            <span class="text-red-600">Inactive</span>
                        @endif
                    </td>

                    <td>{{ $cat->updated_at->format('Y-m-d') }}</td>

                    <td class="text-right">
                        <a href="{{ route('product-category.edit', $cat) }}" 
                           class="text-indigo-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection
