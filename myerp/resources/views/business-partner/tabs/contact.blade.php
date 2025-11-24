<h3 class="text-lg font-semibold mb-3">Contacts</h3>

<form action="{{ route('business-partner.contact.store', $bp) }}" method="POST" class="mb-4">
    @csrf
    <input name="name" placeholder="Name" class="border p-2 w-full rounded mb-2" required>
    <input name="phone" placeholder="Phone" class="border p-2 w-full rounded mb-2">
    <input name="email" placeholder="Email" class="border p-2 w-full rounded mb-2">
    <input name="job_title" placeholder="Job Title" class="border p-2 w-full rounded mb-2">

    <button class="px-3 py-1 bg-indigo-600 text-white rounded">Add Contact</button>
</form>

<ul>
@foreach($bp->contacts as $c)
    <li class="flex justify-between border-b py-2">
        <div>
            <strong>{{ $c->name }}</strong><br>
            <small>{{ $c->email }} | {{ $c->phone }}</small>
        </div>

        <form action="{{ route('business-partner.contact.delete', $c) }}" method="POST">
            @csrf @method('DELETE')
            <button class="text-red-500">Delete</button>
        </form>
    </li>
@endforeach
</ul>
