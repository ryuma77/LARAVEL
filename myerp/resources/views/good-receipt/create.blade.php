@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <h2 class="text-xl font-semibold mb-4">Create Good Receipt</h2>

        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('good-receipt.store') }}" method="POST">
                @csrf

                {{-- Purchase Order Selector --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Purchase Order</label>
                    <select name="po_id" class="border p-2 rounded w-full" required>
                        <option value="">-- Select Purchase Order --</option>
                        @foreach($purchaseOrders as $po)
                            <option value="{{ $po->id }}">
                                {{ $po->po_number }} — {{ $po->vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Warehouse --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium">Warehouse</label>
                    <select name="warehouse_id" class="border p-2 rounded w-full" required>
                        <option value="">-- Select Warehouse --</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->code }} — {{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Save Good Receipt
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
