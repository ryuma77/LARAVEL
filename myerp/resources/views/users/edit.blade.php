@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Edit User</h1>

<form action="{{ route('users.update',$user) }}" method="POST" class="bg-white p-4 rounded-lg shadow">
    @csrf @method('PUT')

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium">Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ $user->name }}" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" value="{{ $user->email }}" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium">Password (optional)</label>
            <input type="password" name="password" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Role</label>
            <select name="role_id" class="w-full border p-2 rounded" required>
                @foreach($roles as $r)
                <option value="{{ $r->id }}" @if($user->role_id==$r->id) selected @endif>{{ $r->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
</form>
@endsection
