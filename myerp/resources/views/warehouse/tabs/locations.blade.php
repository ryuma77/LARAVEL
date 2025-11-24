<h3 class="text-lg font-semibold mb-4">Locations</h3>

{{-- Add Location --}}
<form action="{{ route('warehouses.locations.store', $warehouse) }}" method="POST" class="mb-6">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-medium">Code</label>
            <input name="code" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="text-sm font-medium">Name</label>
            <input name="name" class="border p-2 rounded w-full" required>
        </div>
    </div>

    <button class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded">
        Add Location
    </button>
</form>

<hr class="my-4">

{{-- List --}}
@foreach ($warehouse->locations as $loc)
    <div class="border rounded p-3 mb-3 flex justify-between items-center">
        <div>
            <div class="font-semibold">{{ $loc->code }}</div>
            <div class="text-sm text-gray-500">{{ $loc->name }}</div>
        </div>

        <form action="{{ route('warehouses.locations.destroy', [$warehouse, $loc]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="text-red-600 text-sm">Delete</button>
        </form>
    </div>
@endforeach
