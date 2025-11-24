@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Warehouses</h1>

        <a href="{{ route('warehouses.create') }}"
           class="px-4 py-2 bg-indigo-600 text-white rounded">
            + Add Warehouse
        </a>
    </div>

    <table class="w-full text-sm border">
        <thead class="bg-gray-50">
            <tr class="border-b">
                <th class="p-2 text-left">Code</th>
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($warehouse as $wh)
            <tr class="border-b">
                <td class="p-2">{{ $wh->code }}</td>
                <td class="p-2">{{ $wh->name }}</td>
                <td class="p-2 text-right">
                    <a href="{{ route('warehouses.edit', $wh) }}"
                       class="text-indigo-600 hover:underline">
                        Edit
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="p-4 text-center text-gray-400">
                    No warehouse found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $warehouse->links() }}
    </div>

</div>
@endsection
