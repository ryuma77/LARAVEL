@extends('layouts.app')

@section('content')
<div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between mb-4">
                  <h3 class="text-lg font-semibold">Shipments</h3>
                  <a href="{{ route('shipments.create') }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded">
                        Add Shipment
                  </a>
            </div>

            <div class="bg-white p-6 rounded shadow">
                  <table class="w-full text-sm">
                        <thead>
                              <tr class="border-b text-left">
                                    <th class="py-2">Shipment No</th>
                                    <th class="py-2">SO Number</th>
                                    <th class="py-2">Date</th>
                                    <th class="py-2">Warehouse</th>
                                    <th class="py-2">Status</th>
                                    <th class="py-2 text-right">Actions</th>
                              </tr>
                        </thead>
                        <tbody>
                              @foreach($shipments as $sh)
                              <tr class="border-b">
                                    <td class="py-2">{{ $sh->shipment_number }}</td>
                                    <td>{{ $sh->salesOrder->so_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sh->shipment_date)->format('Y-m-d') }}</td>
                                    <td>{{ $sh->warehouse->name }}</td>
                                    <td>
                                          <span class="px-2 py-1 rounded text-xs
                                    {{ $sh->status === 'posted' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                                {{ ucfirst($sh->status) }}
                                          </span>
                                    </td>
                                    <td class="text-right">
                                          <a href="{{ route('shipments.edit', $sh->id) }}"
                                                class="text-indigo-600 hover:underline">Edit</a>
                                    </td>
                              </tr>
                              @endforeach
                        </tbody>
                  </table>

                  <div class="mt-4">
                        {{ $shipments->links() }}
                  </div>

            </div>
      </div>
</div>
@endsection