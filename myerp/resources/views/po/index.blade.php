@extends('layouts.app')

@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-semibold">Purchase Orders</h1>
    <a href="{{ route('po.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Create New PO</a>
</div>

<div class="bg-white p-4 rounded shadow">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="py-2">PO Number</th>
                <th class="py-2">Vendor</th>
                <th class="py-2">Total Amount</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($po as $purchaseOrder)
                <tr class="border-b">
                    <td class="py-2">{{ $purchaseOrder->po_number }}</td>
                    <td class="py-2">{{ $purchaseOrder->vendor->name }}</td>
                    <td class="py-2">{{ $purchaseOrder->total_amount }}</td>
                    <td class="text-right">
                        <a href="{{ route('po.edit', $purchaseOrder) }}" class="text-indigo-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $po->links() }}</div>
</div>
@endsection
