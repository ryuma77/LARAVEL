@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <!-- LEFT FORM -->
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Create Business Partner</h2>

        <form action="{{ route('business-partner.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">Code</label>
                    <input name="code" class="border p-2 w-full rounded" required>
                </div>

                <div>
                    <label class="text-sm">Type</label>
                    <select name="type" class="border p-2 w-full rounded">
                        <option value="customer">Customer</option>
                        <option value="vendor">Vendor</option>
                        <option value="both">Both</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm">Name</label>
                <input name="name" class="border p-2 w-full rounded" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">Phone</label>
                    <input name="phone" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="text-sm">Email</label>
                    <input name="email" type="email" class="border p-2 w-full rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm">Website</label>
                <input name="website" class="border p-2 w-full rounded">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">Credit Limit</label>
                    <input name="credit_limit" type="number" class="border p-2 w-full rounded" value="0">
                </div>
                <div>
                    <label class="text-sm">Payment Term (ID)</label>
                    <input name="payment_term_id" class="border p-2 w-full rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm">Description</label>
                <textarea name="description" class="border p-2 w-full rounded"></textarea>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                Save
            </button>
        </form>
    </div>

    <!-- RIGHT SIDE DISABLED -->
    <div class="bg-gray-100 p-4 rounded shadow opacity-60 cursor-not-allowed">
        <h3 class="text-lg font-semibold text-gray-500">Tabs (Disabled)</h3>
        <p class="text-sm text-gray-500 mt-2">
            Contacts, Address & Accounting will be available after BP is created.
        </p>
    </div>
</div>
@endsection
