@extends('layouts.app')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-semibold">Units of Measure (UoM)</h1>
    <a href="{{ route('uom.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Add UoM</a>
</div>

<div class="bg-white p-4 rounded shadow">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2">Code</th>
                <th>Name</th>
                <th>Symbol</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($uoms as $u)
            <tr class="border-b">
                <td class="py-2">{{ $u->code }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->symbol }}</td>
                <td>{{ $u->is_active ? 'Active' : 'Inactive' }}</td>
                <td class="text-right">
                    <a href="{{ route('uom.edit', $u) }}" class="text-indigo-600 hover:underline">Edit</a>
                    <form action="{{ route('uom.destroy', $u) }}" method="POST" class="inline-block ml-3">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
