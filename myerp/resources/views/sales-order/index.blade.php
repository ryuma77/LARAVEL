@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto">

        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-semibold">Sales Orders</h3>
            <a href="{{ route('sales-order.create') }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded">
                Create Sales Order
            </a>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">SO No.</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($salesOrders as $so)
                    <tr class="border-b">
                        <td class="py-2">{{ $so->so_number }}</td>
                        <td>{{ $so->customer->name ?? '-' }}</td>
                        <td>{{ $so->order_date }}</td>
                        <td>{{ number_format($so->total_amount, 0) }}</td>
                        <td class="text-right">
                            <a href="{{ route('sales-order.edit', $so->id) }}" 
                               class="text-indigo-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $salesOrders->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
