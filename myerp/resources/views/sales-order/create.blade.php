@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto">

        <div class="bg-white p-6 shadow rounded">
            <h2 class="text-lg font-semibold mb-4">Create Sales Order</h2>

            <form action="{{ route('sales-order.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium">Customer</label>
                    <select name="customer_id" class="border p-2 rounded w-full" required>
                        <option value="">-- Select Customer --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Order Date</label>
                    <input type="date" name="order_date" class="border p-2 rounded w-full" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Notes</label>
                    <textarea name="notes" class="border p-2 rounded w-full"></textarea>
                </div>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Save & Continue
                </button>
            </form>

        </div>

    </div>
</div>
@endsection
