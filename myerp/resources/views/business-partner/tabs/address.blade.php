<h3 class="text-lg font-semibold mb-3">Addresses</h3>

<form action="{{ route('business-partner.address.store', $bp) }}" method="POST" class="mb-4">
    @csrf
    <select name="address_type" class="border p-2 w-full rounded mb-2">
        <option value="billing">Billing</option>
        <option value="shipping">Shipping</option>
        <option value="other">Other</option>
    </select>

    <input name="address_line1" placeholder="Address Line 1" class="border p-2 w-full rounded mb-2" required>
    <input name="address_line2" placeholder="Address Line 2" class="border p-2 w-full rounded mb-2">
    <input name="city" placeholder="City" class="border p-2 w-full rounded mb-2">
    <input name="state" placeholder="State" class="border p-2 w-full rounded mb-2">
    <input name="country" placeholder="Country" class="border p-2 w-full rounded mb-2">
    <input name="postal_code" placeholder="Postal Code" class="border p-2 w-full rounded mb-2">

    <button class="px-3 py-1 bg-indigo-600 text-white rounded">Add Address</button>
</form>

<ul>
@foreach($bp->addresses as $a)
    <li class="border-b py-2 flex justify-between">
        <div>
            <strong>{{ ucfirst($a->address_type) }} Address</strong><br>
            <small>{{ $a->address_line1 }}, {{ $a->city }}</small>
        </div>

        <form action="{{ route('business-partner.address.delete', $a) }}" method="POST">
            @csrf @method('DELETE')
            <button class="text-red-500">Delete</button>
        </form>
    </li>
@endforeach
</ul>
