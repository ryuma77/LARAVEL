@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Role Management</h1>
    <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Add Role</a>
</div>

<div class="bg-white p-4 rounded-lg shadow">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2">Role</th>
                <th>Description</th>
                <th>Permissions</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr class="border-b">
                    <td class="py-2">{{ $role->name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>{{ $role->permissions_count }}</td>
                    <td class="text-right">
                        <a href="{{ route('roles.edit', $role) }}" class="text-indigo-600 hover:underline">Edit</a>
                        @if($role->name !== 'admin')
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block ml-3">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
