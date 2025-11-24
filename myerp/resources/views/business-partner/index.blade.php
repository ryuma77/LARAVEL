@extends('layouts.app')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-semibold">Business Partners</h1>
    <a href="{{ route('business-partner.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">
        Add Business Partner
    </a>
</div>

<div class="bg-white p-4 rounded shadow">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2">Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Phone</th>
                <th>Email</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($partners as $bp)
            <tr class="border-b">
                <td class="py-2">{{ $bp->code }}</td>
                <td>{{ $bp->name }}</td>
                <td>{{ ucfirst($bp->type) }}</td>
                <td>{{ $bp->phone }}</td>
                <td>{{ $bp->email }}</td>
                <td class="text-right">
                    <a href="{{ route('business-partner.edit', $bp) }}" class="text-indigo-600 hover:underline">
                        Edit
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $partners->links() }}
    </div>
</div>
@endsection
