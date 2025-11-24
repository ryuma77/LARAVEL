@extends('layouts.app')

@section('content')
{{-- <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow"> --}}
<div class="bg-white p-6 rounded shadow">

    <h1 class="text-xl font-bold mb-4">Create Warehouse</h1>

    <form action="{{ route('warehouses.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium">Code</label>
            <input name="code" class="border p-2 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Name</label>
            <input name="name" class="border p-2 rounded w-full" required>
        </div>

        <button class="px-4 py-2 bg-indigo-600 text-white rounded">
            Save
        </button>
    </form>

</div>
@endsection
