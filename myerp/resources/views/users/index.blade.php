@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold">User Management</h1>
    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Add User</a>
</div>

<div class="bg-white p-4 rounded-lg shadow">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2">Name</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr class="border-b">
                <td class="py-2">{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role->name ?? '-' }}</td>
                <td class="text-right">
                    <a href="{{ route('users.edit',$u) }}" class="text-indigo-600 hover:underline">Edit</a>
                    @if($u->email !== 'admin@erp.com')
                    <form action="{{ route('users.destroy',$u) }}" method="POST" class="inline-block ml-3">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                    @endif
                </td>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
