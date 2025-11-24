@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Edit Role</h1>

<form action="{{ route('roles.update', $role) }}" method="POST" class="bg-white p-4 rounded-md shadow">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block text-sm font-medium">Role Name</label>
        <input type="text" name="name" value="{{ $role->name }}" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Description</label>
        <input type="text" name="description" value="{{ $role->description }}" class="w-full border p-2 rounded">
    </div>

    <h3 class="font-semibold mb-2">Permissions</h3>

    <div class="grid grid-cols-3 gap-4">
        @foreach($permissions as $group => $items)
        <div class="border p-3 rounded">
            <h4 class="font-medium mb-2 capitalize">{{ $group }}</h4>

            @foreach($items as $perm)
            <label class="flex items-center gap-2 text-sm mb-1">
                <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                       @if(in_array($perm->id, $assigned)) checked @endif>
                {{ $perm->label }}
            </label>
            @endforeach
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
    </div>
</form>
@endsection
