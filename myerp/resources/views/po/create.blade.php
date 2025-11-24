@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="font-semibold text-xl text-gray-800">
                Create Purchase Order
            </h2>
        </div>

        {{-- Form --}}
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('po.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="po_number" class="block text-sm font-medium">PO Number</label>
                        <input id="po_number" name="po_number" value="{{ old('po_number') }}" class="border p-2 rounded w-full">
                    </div>

                    <div>
                        <label for="vendor_id" class="block text-sm font-medium">Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="border p-2 rounded w-full" required>
                            <option value="">-- Select Vendor --</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                    {{ $vendor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="po_date" class="block text-sm font-medium">PO Date</label>
                        <input id="po_date" name="po_date" type="date" value="{{ old('po_date', now()->toDateString()) }}" class="border p-2 rounded w-full" required>
                    </div>

                    <div>
                        <label for="total_amount" class="block text-sm font-medium">Total Amount</label>
                        <input id="total_amount" name="total_amount" type="number" step="0.01" value="{{ old('total_amount') }}" class="border p-2 rounded w-full" >
                    </div>
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium">Notes</label>
                    <textarea id="notes" name="notes" class="border p-2 rounded w-full">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Create PO
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
