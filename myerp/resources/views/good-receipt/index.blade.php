@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Good Receipts List --}}
        <div class="bg-white p-6 rounded shadow">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Good Receipts</h3>
                <a href="{{ route('good-receipt.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Add Good Receipt</a>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">PO Number</th>
                        <th class="py-2">Warehouse</th>
                        <th class="py-2">Received Date</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($goodReceipts as $goodReceipt)
                    <tr class="border-b">
                        <td>{{ $goodReceipt->purchaseOrder->po_number }}</td>
                        <td>{{ $goodReceipt->warehouse->name }}</td>
                        <td>{{ $goodReceipt->received_date->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('good-receipt.details.create', $goodReceipt->id) }}" class="text-indigo-600 hover:underline">Add Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
