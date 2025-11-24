@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Create User</h1>

<form action="{{ route('users.store') }}" method="POST" class="bg-white p-4 rounded-lg shadow">
    @csrf

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium">Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Role</label>
            <select name="role_id" class="w-full border p-2 rounded" required>
                @foreach($roles as $r)
                <option value="{{ $r->id }}">{{ $r->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
</form>
@endsection
