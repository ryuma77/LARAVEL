@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <!-- LEFT (HEADER FORM) -->
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Edit Business Partner</h2>

        <form action="{{ route('business-partner.update', $bp) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">Code</label>
                    <input name="code" value="{{ $bp->code }}" class="border p-2 w-full rounded">
                </div>

                <div>
                    <label class="text-sm">Type</label>
                    <select name="type" class="border p-2 w-full rounded">
                        <option value="customer" @selected($bp->type=='customer')>Customer</option>
                        <option value="vendor" @selected($bp->type=='vendor')>Vendor</option>
                        <option value="both" @selected($bp->type=='both')>Both</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm">Name</label>
                <input name="name" value="{{ $bp->name }}" class="border p-2 w-full rounded">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">Phone</label>
                    <input name="phone" value="{{ $bp->phone }}" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="text-sm">Email</label>
                    <input name="email" value="{{ $bp->email }}" class="border p-2 w-full rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm">Website</label>
                <input name="website" value="{{ $bp->website }}" class="border p-2 w-full rounded">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm">Credit Limit</label>
                    <input name="credit_limit" value="{{ $bp->credit_limit }}" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="text-sm">Payment Term ID</label>
                    <input name="payment_term_id" value="{{ $bp->payment_term_id }}" class="border p-2 w-full rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="text-sm">Description</label>
                <textarea name="description" class="border p-2 w-full rounded">{{ $bp->description }}</textarea>
            </div>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                Update
            </button>
        </form>
    </div>

    <!-- RIGHT TAB PANEL -->
    <div class="col-span-1 bg-white rounded shadow p-4">
        
        <!-- TAB BUTTONS -->
        <div class="flex space-x-2 border-b pb-2 mb-4">
            <button onclick="openTab('tab-contact')" class="px-3 py-1 bg-gray-200 rounded">Contact</button>
            <button onclick="openTab('tab-address')" class="px-3 py-1 bg-gray-200 rounded">Address</button>
            <button onclick="openTab('tab-accounting')" class="px-3 py-1 bg-gray-200 rounded">Accounting</button>
        </div>

        <!-- TAB CONTENT -->
        <div id="tab-contact" class="tab-content">
            @include('business-partner.tabs.contact')
        </div>

        <div id="tab-address" class="tab-content hidden">
            @include('business-partner.tabs.address')
        </div>

        <div id="tab-accounting" class="tab-content hidden">
            @include('business-partner.tabs.accounting')
        </div>

    </div>
</div>

<script>
function openTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(x => x.classList.add('hidden'));
    document.getElementById(tabId).classList.remove('hidden');
}
</script>
@endsection
