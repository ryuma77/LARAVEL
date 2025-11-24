@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <h3 class="text-lg font-semibold mb-4">Good Receipt Detail for PO {{ $goodReceipt->purchaseOrder->po_number }}</h3>

        <form action="{{ route('good-receipt.detail.store', $goodReceipt->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="product_id" class="block text-sm font-medium">Product</label>
                <select name="product_id" id="product_id" class="border p-2 rounded w-full" required>
                    <option value="">-- Select Product --</option>
                    @foreach($poDetails as $poDetail)
                        <option value="{{ $poDetail->product_id }}">{{ $poDetail->product->name }} ({{ $poDetail->product->sku }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium">Quantity</label>
                <input type="number" name="quantity" class="border p-2 rounded w-full" required>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Add Good Receipt Detail</button>
        </form>
    </div>
</div>
@endsection
