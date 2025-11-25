@extends('layouts.app')

@section('content')
<div class="py-6 max-w-7xl mx-auto">

    <h2 class="text-xl font-semibold mb-4">
        Good Receipt for PO: {{ $goodReceipt->purchaseOrder->po_number }}
    </h2>

    {{-- HEADER SECTION --}}
    <div class="bg-white p-5 rounded shadow mb-6">
        <p><strong>PO Number:</strong> {{ $goodReceipt->purchaseOrder->po_number }}</p>
        <p><strong>Warehouse:</strong> {{ $goodReceipt->warehouse->name }}</p>
        <p><strong>Received Date:</strong> {{ \Carbon\Carbon::parse($goodReceipt->received_date)->format('Y-m-d') }}</p>
        <p><strong>Received By:</strong> {{ $goodReceipt->received_by }}</p>
    </div>

    {{-- ADD DETAIL FORM --}}
    <div class="bg-white p-5 rounded shadow mb-6">
        <h3 class="font-semibold mb-3">Add Detail</h3>

        <form action="{{ route('good-receipt.add-detail', $goodReceipt->id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-3 gap-4">

                <div>
                    <label class="block text-sm font-medium">Product</label>
                    <select name="product_id" class="border p-2 rounded w-full" required>
                        <option value="">Select product</option>
                        @foreach($poDetails as $d)
                            <option value="{{ $d->product_id }}">
                                {{ $d->product->name }} (PO Qty: {{ $d->quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Quantity</label>
                    <input type="number" name="quantity" min="1" class="border p-2 rounded w-full" required>
                </div>

                <div class="flex items-end">
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded w-full">Add Detail</button>
                </div>

            </div>
        </form>
    </div>

    {{-- DETAIL TABLE --}}
    <div class="bg-white p-5 rounded shadow">
        <h3 class="font-semibold mb-3">Details</h3>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Product</th>
                    <th class="py-2">Qty</th>
                    <th class="py-2">Unit Price</th>
                    <th class="py-2">Total</th>
                    <th class="py-2 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($goodReceipt->details as $detail)
                <tr class="border-b">
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->unit_price, 2) }}</td>
                    <td>{{ number_format($detail->total_price, 2) }}</td>
                    <td class="text-right">
                        <form action="{{ route('good-receipt.delete-detail', $detail) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection
