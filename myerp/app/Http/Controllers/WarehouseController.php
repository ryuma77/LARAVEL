<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Location;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouse = Warehouse::orderBy('code')->paginate(20);
        return view('warehouse.index', compact('warehouse'));
    }


    public function create()
    {
        return view('warehouse.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'code' => 'required|unique:warehouses,code',
            'name' => 'required',
        ]);


        Warehouse::create([
            'code' => $r->code,
            'name' => $r->name,
        ]);

        return redirect()->route('warehouses.index')->with('success', 'Warehouse created');
    }

    public function edit(Warehouse $warehouse)
    {
        // Eager load locations and their bins (for tabs)
        $warehouse->load(['locations.bins']);
        return view('warehouse.edit', compact('warehouse'));
    }

    public function update(Request $r, Warehouse $warehouse)
    {
        $r->validate([
            'code' => 'required|unique:warehouses,code,' . $warehouse->id,
            'name' => 'required',
        ]);

        $warehouse->update([
            'code' => $r->code,
            'name' => $r->name,
        ]);

        return back()->with('success', 'Warehouse updated');
    }

    public function destroy(Warehouse $warehouse)
    {
        // Consider checking for dependent records (locations, stock) before deleting
        $warehouse->delete();
        return redirect()->route('warehouse.index')->with('success', 'Warehouse deleted');
    }
}
