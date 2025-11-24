@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Create Good Receipt Form --}}
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-semibold mb-4">Create Good Receipt</h3>

            <form action="{{ route('good-receipt.store') }}" method="POST">
                @csrf

                {{-- PO Selection --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Purchase Order</label>
                    <select name="po_id" class="border p-2 rounded w-full" required>
                        <option value="">-- Select Purchase Order --</option>
                        @foreach($purchaseOrders as $po)
                            <option value="{{ $po->id }}">{{ $po->po_number }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Warehouse Selection --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Warehouse</label>
                    <select name="warehouse_id" class="border p-2 rounded w-full" required>
                        <option value="">-- Select Warehouse --</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            </form>
        </div>

    </div>
</div>
@endsection
