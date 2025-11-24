@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            {{-- Header Form PO --}}
            <div class="bg-white p-6 rounded shadow mb-6">
                <form action="{{ route('po.update', $po) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="vendor_id" class="block text-sm font-medium">Vendor</label>
                            <select name="vendor_id" id="vendor_id" class="border p-2 rounded w-full" required>
                                <option value="">-- Select Vendor --</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" @selected(old('vendor_id', $po->vendor_id) == $vendor->id)>
                                        {{ $vendor->name }} ({{ $vendor->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="po_date" class="block text-sm font-medium">PO Date</label>
                            <input type="date" name="po_date" value="{{ old('po_date', $po->po_date) }}" class="border p-2 rounded w-full" required>
                        </div>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                        Save
                    </button>
                </form>
            </div>

            {{-- PO Details Table --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">PO Details</h3>

                <form action="{{ route('po.details.store', $po) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-4 gap-4 mb-6">
                        <div>
                            <label for="product_id" class="block text-sm font-medium">Product</label>
                            <select name="product_id" id="product_id" class="border p-2 rounded w-full" required>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="quantity" class="block text-sm font-medium">Quantity</label>
                            <input type="number" name="quantity" class="border p-2 rounded w-full" required>
                        </div>

                        <div>
                            <label for="unit_price" class="block text-sm font-medium">Unit Price</label>
                            <input type="number" step="0.01" name="unit_price" class="border p-2 rounded w-full" required>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Add Product</button>
                        </div>
                    </div>
                </form>

                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            <th class="py-2">Product</th>
                            <th class="py-2">Quantity</th>
                            <th class="py-2">Unit Price</th>
                            <th class="py-2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($po->details as $detail)
                            <tr class="border-b">
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->unit_price, 2) }}</td>
                                <td>{{ number_format($detail->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
