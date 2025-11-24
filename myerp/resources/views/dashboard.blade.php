@extends('layouts.app')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-3">
        <h2 class="text-2xl font-semibold mb-2">Welcome, {{ auth()->user()->name }}</h2>
        <p class="text-sm text-gray-600 mb-6">Overview dashboard. Role: <strong>{{ auth()->user()->role->name ?? '-' }}</strong></p>
    </div>

    <div class="col-span-1">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Quick Actions</h3>
            <div class="space-y-2">
                @canAccess('inventory.manage')
                    <a href="#" class="block px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">Add Product</a>
                @endcanAccess
                @canAccess('purchase.manage')
                    <a href="#" class="block px-3 py-2 border rounded-md text-sm">New Purchase</a>
                @endcanAccess
                <a href="#" class="block px-3 py-2 border rounded-md text-sm">Reports</a>
            </div>
        </div>
    </div>

    <div class="col-span-2">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Recent Activity</h3>
            <div class="text-sm text-gray-600">No recent activity yet.</div>
        </div>
    </div>
</div>
@endsection
