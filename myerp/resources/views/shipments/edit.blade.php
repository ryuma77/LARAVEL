@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <h3 class="text-lg font-semibold mb-4">
            Shipment — {{ $shipment->shipment_number }}
        </h3>

        {{-- TAB HEADER --}}
        <div x-data="{ tab: 'header' }">

            {{-- TAB BUTTONS --}}
            <div class="flex gap-4 border-b mb-6">
                <button @click="tab='header'"
                    class="py-2 px-3 border-b-2"
                    :class="tab==='header' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500'">
                    Header
                </button>

                <button @click="tab='details'"
                    class="py-2 px-3 border-b-2"
                    :class="tab==='details' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500'">
                    Details
                </button>
            </div>

            {{-- TAB CONTENT: HEADER --}}
            <div x-show="tab==='header'" class="bg-white p-6 rounded shadow">

                <form action="{{ route('shipments.update', $shipment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">SO Number</label>
                            <input disabled value="{{ $shipment->salesOrder->so_number }}"
                                   class="border p-2 rounded w-full bg-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Warehouse</label>
                            <select name="warehouse_id" class="border p-2 rounded w-full" required>
                                @foreach($shipment->warehouse->all() as $wh)
                                    <option value="{{ $wh->id }}"
                                        {{ $shipment->warehouse_id == $wh->id ? 'selected' : '' }}>
                                        {{ $wh->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded">
                        Save Header
                    </button>
                </form>

            </div>

            {{-- TAB CONTENT: DETAILS --}}
            <div x-show="tab==='details'" class="bg-white p-6 rounded shadow">

                {{-- ADD DETAIL FORM --}}
                <div class="mb-6 border-b pb-4">
                    <h4 class="font-semibold mb-3">Add Shipment Detail</h4>

                    <form action="{{ route('shipments.details.add', $shipment->id) }}" method="POST" class="grid grid-cols-4 gap-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium">Product</label>
                            <select name="product_id" class="border p-2 rounded w-full" required>
                                <option value="">-- Select Product --</option>
                                @foreach($salesOrderDetails as $detail)
                                    <option value="{{ $detail->product_id }}">
                                        {{ $detail->product->name }} ({{ $detail->product->sku }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Bin</label>
                            <select name="bin_id" class="border p-2 rounded w-full" required>
                                <option value="">-- Select Bin --</option>
                                @foreach($bins as $bin)
                                    <option value="{{ $bin->id }}">{{ $bin->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Quantity</label>
                            <input type="number" name="quantity" class="border p-2 rounded w-full" required>
                        </div>

                        <div class="flex items-end">
                            <button class="px-4 py-2 bg-green-600 text-white rounded">
                                Add Detail
                            </button>
                        </div>
                    </form>
                </div>

                {{-- DETAIL LIST --}}
                <h4 class="font-semibold mb-3">Shipment Details</h4>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="py-2">Product</th>
                            <th class="py-2">Qty</th>
                            <th class="py-2">Bin</th>
                            <th class="py-2">UoM</th>
                            <th class="py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shipment->details as $d)
                            <tr class="border-b">
                                <td class="py-2">{{ $d->product->name }}</td>
                                <td>{{ $d->quantity }}</td>
                                <td>{{ $d->bin->name }}</td>
                                <td>{{ $d->uom->name }}</td>
                                <td class="text-right">
                                    <form action="{{ route('shipments.details.delete', $d->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this detail?');">
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

    </div>
</div>
@endsection
