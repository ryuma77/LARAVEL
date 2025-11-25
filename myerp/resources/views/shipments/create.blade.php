@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <h3 class="text-lg font-semibold mb-4">Create Shipment</h3>

        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('shipments.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium">Sales Order</label>
                    <select name="so_id" class="border p-2 rounded w-full" required>
                        <option value="">-- Select Sales Order --</option>
                        @foreach($salesOrders as $so)
                            <option value="{{ $so->id }}">
                              {{ $so->so_number }} — {{ $so->customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Warehouse</label>
                    <select name="warehouse_id" class="border p-2 rounded w-full" required>
                        <option value="">-- Select Warehouse --</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Create Shipment
                </button>

            </form>
        </div>

    </div>
</div>
@endsection
