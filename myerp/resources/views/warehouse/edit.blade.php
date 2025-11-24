@extends('layouts.app')

@section('content')

    <h2 class="font-semibold text-xl text-gray-800 mb-4">
        Edit Warehouse — {{ $warehouse->code }}
    </h2>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Warehouse Header --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Code</label>
                            <input name="code" value="{{ $warehouse->code }}" class="border p-2 rounded w-full" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Name</label>
                            <input name="name" value="{{ $warehouse->name }}" class="border p-2 rounded w-full" required>
                        </div>
                    </div>

                    <button class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded">
                        Save
                    </button>
                </form>
            </div>

            {{-- Locations & Bins --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Locations</h3>

                {{-- Add Location --}}
                <form action="{{ route('warehouses.locations.store', $warehouse) }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex gap-3">
                        <input name="code" placeholder="LOC-001" class="border p-2 rounded w-40" required>
                        <input name="name" placeholder="Location Name" class="border p-2 rounded flex-1" required>
                        <button class="px-4 py-2 bg-green-600 text-white rounded">Add</button>
                    </div>
                </form>

                {{-- List Locations --}}
                @foreach($warehouse->locations as $loc)
                    <div class="border p-4 rounded mb-4">
                        <div class="flex justify-between">
                            <div>
                                <div class="font-semibold">{{ $loc->code }} — {{ $loc->name }}</div>
                                <div class="text-xs text-gray-500">Location</div>
                            </div>

                            <form action="{{ route('warehouses.locations.update', [$warehouse, $loc]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input name="code" value="{{ $loc->code }}" class="border p-1 rounded w-28">
                                <input name="name" value="{{ $loc->name }}" class="border p-1 rounded w-40">
                                <button class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Save</button>
                            </form>
                        </div>

                        {{-- Bins --}}
                        <div class="mt-4 pl-4 border-l">

                            {{-- Add bin --}}
                            <form action="{{ route('warehouses.bins.store', [$warehouse, $loc]) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="flex gap-2">
                                    <input name="code" placeholder="BIN-001" class="border p-1 rounded w-28" required>
                                    <input name="name" placeholder="Bin Name" class="border p-1 rounded w-40" required>
                                    <button class="px-3 py-1 bg-green-600 text-white rounded text-sm">Add Bin</button>
                                </div>
                            </form>

                            {{-- List bins --}}
                            @foreach($loc->bins as $bin)
                                <div class="flex items-center justify-between mb-2">
                                    <div class="text-sm">
                                        {{ $bin->code }} — {{ $bin->name }}
                                    </div>

                                    <form action="{{ route('warehouses.bins.update', [$warehouse, $loc, $bin]) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input name="code" value="{{ $bin->code }}" class="border p-1 rounded w-20">
                                        <input name="name" value="{{ $bin->name }}" class="border p-1 rounded w-40">
                                        <button class="px-2 py-1 bg-indigo-600 text-white rounded text-xs">Save</button>
                                    </form>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>

@endsection
