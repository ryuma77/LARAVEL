@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Create Role</h1>

<form action="{{ route('roles.store') }}" method="POST" class="bg-white p-4 rounded-md shadow">
    @csrf

    <div class="mb-4">
        <label class="block text-sm font-medium">Role Name</label>
        <input type="text" name="name" class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Description</label>
        <input type="text" name="description" class="w-full border p-2 rounded">
    </div>

    <h3 class="font-semibold mb-2">Permissions</h3>

    <div class="grid grid-cols-3 gap-4">
        @foreach($permissions as $group => $items)
        <div class="border p-3 rounded">
            <h4 class="font-medium mb-2 capitalize">{{ $group }}</h4>

            @foreach($items as $perm)
            <label class="flex items-center gap-2 text-sm mb-1">
                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}">
                {{ $perm->label }}
            </label>
            @endforeach
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
    </div>
</form>
@endsection
