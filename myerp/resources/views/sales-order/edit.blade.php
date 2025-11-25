@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto grid grid-cols-2 gap-6">

        {{-- ======================
            LEFT PANEL — HEADER
        ======================== --}}
        <div class="bg-white p-6 shadow rounded">
            <h2 class="text-lg font-semibold mb-4">Sales Order Header</h2>

            <form action="{{ route('sales-order.update', $salesOrder->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="block text-sm font-medium">SO Number</label>
                    <input value="{{ $salesOrder->so_number }}" 
                           class="border p-2 rounded w-full bg-gray-100" readonly>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Customer</label>
                    <select name="customer_id" class="border p-2 rounded w-full" required>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" 
                                @selected($c->id == $salesOrder->customer_id)>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Order Date</label>
                    <input type="date" name="order_date" value="{{ $salesOrder->order_date }}" 
                           class="border p-2 rounded w-full" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Notes</label>
                    <textarea name="notes" class="border p-2 rounded w-full">
                        {{ $salesOrder->notes }}
                    </textarea>
                </div>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded mt-2">
                    Update Header
                </button>
            </form>
        </div>

        {{-- ======================
            RIGHT PANEL — DETAILS
        ======================== --}}
        <div class="bg-white p-6 shadow rounded">
            <h2 class="text-lg font-semibold mb-4">Sales Order Details</h2>

            {{-- ADD DETAIL --}}
            <form action="{{ route('sales-order.details.add', $salesOrder->id) }}" method="POST" class="mb-6">
                @csrf

                <div class="grid grid-cols-4 gap-3">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Product</label>
                        <select name="product_id" class="border p-2 rounded w-full">
                            <option value="">-- Select Product --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->name }} ({{ $p->sku }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Qty</label>
                        <input type="number" name="quantity" class="border p-2 rounded w-full" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Unit Price</label>
                        <input type="number" name="unit_price" step="0.01" class="border p-2 rounded w-full" required>
                    </div>
                </div>

                <button class="px-4 py-2 bg-green-600 text-white rounded mt-3">
                    Add Detail
                </button>
            </form>

            {{-- LIST DETAILS --}}
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
                @foreach($salesOrder->details as $d)
                    <tr class="border-b">
                        <td class="py-2">{{ $d->product->name }}</td>
                        <td>{{ $d->quantity }}</td>
                        <td>{{ number_format($d->unit_price, 0) }}</td>
                        <td>{{ number_format($d->total_price, 0) }}</td>
                        <td class="text-right">
                            <form action="{{ route('sales-order.details.delete', [$salesOrder->id, $d->id]) }}" 
                                  method="POST">
                                @csrf 
                                @method('DELETE')
                                <button class="text-red-600 hover:underline"
                                    onclick="return confirm('Delete this detail?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

    </div>
</div>
@endsection
