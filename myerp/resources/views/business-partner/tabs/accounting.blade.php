<h3 class="text-lg font-semibold mb-3">Accounting</h3>

<form action="{{ route('business-partner.accounting.update', $bp) }}" method="POST">
    @csrf

    <label class="text-sm">AR Account</label>
    <select name="ar_account_id" class="border p-2 w-full rounded mb-3">
        <option value="">-- None --</option>
        @foreach($coa as $a)
        <option value="{{ $a->id }}" @selected($bp->accounting?->ar_account_id == $a->id)>
            {{ $a->code }} — {{ $a->name }}
        </option>
        @endforeach
    </select>

    <label class="text-sm">AP Account</label>
    <select name="ap_account_id" class="border p-2 w-full rounded mb-3">
        <option value="">-- None --</option>
        @foreach($coa as $a)
        <option value="{{ $a->id }}" @selected($bp->accounting?->ap_account_id == $a->id)>
            {{ $a->code }} — {{ $a->name }}
        </option>
        @endforeach
    </select>

    <button class="px-4 py-1 bg-indigo-600 text-white rounded">
        Save Accounting
    </button>
</form>
