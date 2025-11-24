<h3 class="text-lg font-semibold mb-4">Bins by Location</h3>

@foreach ($warehouse->locations as $loc)

    <div class="border rounded p-4 mb-6">

        <h4 class="font-semibold mb-3">
            {{ $loc->code }} — {{ $loc->name }}
        </h4>

        {{-- Add Bin --}}
        <form action="{{ route('warehouses.bins.store', [$warehouse, $loc]) }}"
              method="POST" class="mb-3">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Bin Code</label>
                    <input name="code" class="border p-2 rounded w-full" required>
                </div>

                <div>
                    <label class="text-sm font-medium">Bin Name</label>
                    <input name="name" class="border p-2 rounded w-full" required>
                </div>
            </div>

            <button class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded">
                Add Bin
            </button>
        </form>

        {{-- List --}}
        @foreach ($loc->bins as $bin)
            <div class="border rounded p-3 mb-2 flex justify-between items-center">
                <div>
                    <div class="font-semibold">{{ $bin->code }}</div>
                    <div class="text-sm text-gray-600">{{ $bin->name }}</div>
                </div>

                <form action="{{ route('warehouses.bins.destroy', [$warehouse, $loc, $bin]) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 text-sm">Delete</button>
                </form>
            </div>
        @endforeach

    </div>

@endforeach
