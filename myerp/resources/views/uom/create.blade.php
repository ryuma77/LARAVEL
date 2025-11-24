@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Create UoM</h2>
        <form action="{{ route('uom.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="text-sm">Code</label>
                <input name="code" class="border p-2 w-full rounded" required>
            </div>

            <div class="mb-4">
                <label class="text-sm">Name</label>
                <input name="name" class="border p-2 w-full rounded" required>
            </div>

            <div class="mb-4">
                <label class="text-sm">Symbol</label>
                <input name="symbol" class="border p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span class="ml-2 text-sm">Active</span>
                </label>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save UoM</button>
        </form>
    </div>

    <div class="col-span-1 bg-gray-100 p-4 rounded shadow opacity-60 cursor-not-allowed">
        <h3 class="text-lg font-semibold text-gray-500">Conversions</h3>
        <p class="text-sm text-gray-500 mt-2">Conversions will be available after UoM is created (edit page).</p>
    </div>
</div>
@endsection
