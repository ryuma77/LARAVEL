<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Show locations for a warehouse (optional index).
     * We mainly create via warehouse edit page, but provide index too.
     */
    public function index(Warehouse $warehouse)
    {
        $locations = $warehouse->locations()->orderBy('code')->get();
        return view('location.index', compact('warehouse', 'locations'));
    }

    public function create(Warehouse $warehouse)
    {
        return view('location.create', compact('warehouse'));
    }

    public function store(Request $r, Warehouse $warehouse)
    {
        $r->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $warehouse->locations()->create([
            'code' => $r->code,
            'name' => $r->name,
        ]);

        return redirect()->route('warehouses.edit', $warehouse)->with('success', 'Location added');
    }

    public function edit(Warehouse $warehouse, Location $location)
    {
        // ensure location belongs to warehouse
        if ($location->warehouse_id !== $warehouse->id) {
            abort(404);
        }

        return view('location.edit', compact('warehouse', 'location'));
    }

    public function update(Request $r, Warehouse $warehouse, Location $location)
    {
        if ($location->warehouse_id !== $warehouse->id) {
            abort(404);
        }

        $r->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $location->update([
            'code' => $r->code,
            'name' => $r->name,
        ]);

        return redirect()->route('warehouses.edit', $warehouse)->with('success', 'Location updated');
    }

    public function destroy(Warehouse $warehouse, Location $location)
    {
        if ($location->warehouse_id !== $warehouse->id) {
            abort(404);
        }

        $location->delete();
        return redirect()->route('warehouses.edit', $warehouse)->with('success', 'Location deleted');
    }
}
