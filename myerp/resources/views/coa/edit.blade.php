@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Edit Account</h1>

<form action="{{ route('coa.update', $coa) }}" method="POST" class="bg-white p-4 rounded shadow">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block text-sm font-medium">Code</label>
        <input type="text" name="code" class="border p-2 w-full rounded"
               value="{{ old('code', $coa->code) }}" required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Name</label>
        <input type="text" name="name" class="border p-2 w-full rounded"
               value="{{ old('name', $coa->name) }}" required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Type</label>
        <select name="type" class="border p-2 w-full rounded">
            @foreach($types as $t)
            <option value="{{ $t }}" @selected($coa->type == $t)>{{ ucfirst($t) }}</option>
            @endforeach
        </select>
    </div>
<div class="mb-4">
    <label class="block text-sm font-medium">Parent Account (optional)</label>
    <select name="parent_id" class="border p-2 w-full rounded">
        <option value="">-- No Parent (Top Level) --</option>

        @foreach($parents as $p)
            <option value="{{ $p->id }}" @selected($coa->parent_id == $p->id)>
                {{ $p->code }} - {{ $p->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4 flex items-center gap-2">
    <input type="checkbox" name="is_parent" value="1" @checked($coa->is_parent)>
    <label>Mark as Parent Account</label>
</div>

    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
</form>
@endsection
