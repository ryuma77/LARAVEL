@extends('layouts.app')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-semibold">Chart of Account</h1>
    <a href="{{ route('coa.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Add Account</a>
</div>

<div class="bg-white p-4 rounded shadow">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2">Code</th>
                <th>Name</th>
                <th>Type</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coa as $c)
            <tr class="border-b">
                <td class="py-2">{{ $c->code }}</td>
                <td>
    @if($c->parent)
        <span class="text-gray-400">—</span>
    @endif
    {{ $c->name }}
</td>

                <td class="capitalize">{{ $c->type }}</td>
                <td class="text-right">
                    <a href="{{ route('coa.edit',$c) }}" class="text-indigo-600 hover:underline">Edit</a>
                    <form action="{{ route('coa.destroy',$c) }}" method="POST" class="inline-block ml-3">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
