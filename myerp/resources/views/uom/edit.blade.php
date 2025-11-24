@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Edit UoM: {{ $uom->code }}</h2>

        <form action="{{ route('uom.update', $uom) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="text-sm">Code</label>
                <input name="code" value="{{ old('code',$uom->code) }}" class="border p-2 w-full rounded" required>
            </div>

            <div class="mb-4">
                <label class="text-sm">Name</label>
                <input name="name" value="{{ old('name',$uom->name) }}" class="border p-2 w-full rounded" required>
            </div>

            <div class="mb-4">
                <label class="text-sm">Symbol</label>
                <input name="symbol" value="{{ old('symbol',$uom->symbol) }}" class="border p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" @checked($uom->is_active)>
                    <span class="ml-2 text-sm">Active</span>
                </label>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
        </form>
    </div>

    <div class="col-span-1 bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">UoM Conversions</h3>

        {{-- conversion form --}}
        <form action="{{ route('uom.conversion.store', $uom) }}" method="POST">
            @csrf
            <div class="mb-2">
                <label class="text-sm">UoM To</label>
                <select name="uom_to_id" class="border p-2 w-full rounded" required>
                    <option value="">-- Select UoM --</option>
                    @foreach($uoms as $uu)
                        <option value="{{ $uu->id }}">{{ $uu->code }} — {{ $uu->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label class="text-sm">Factor (multiply)</label>
                <input name="factor" class="border p-2 w-full rounded" placeholder="e.g. 12 for 1 Box = 12 PCS" required>
            </div>

            <div class="mt-3">
                <button class="px-3 py-1 bg-indigo-600 text-white rounded">Save Conversion</button>
            </div>
        </form>

        <hr class="my-4">

        <div class="text-sm">
            <h4 class="font-medium mb-2">Existing Conversions (from {{ $uom->code }})</h4>
            @forelse($conversions as $c)
                <div class="border-b py-2">
                    <div class="text-xs">1 {{ $uom->code }} = {{ rtrim(rtrim(number_format($c->factor, 12, '.', ''), '0'), '.') }} {{ $c->to->code }}</div>
                </div>
            @empty
                <div class="text-xs text-gray-500">No conversions yet.</div>
            @endforelse
        </div>

    </div>
</div>
@endsection
