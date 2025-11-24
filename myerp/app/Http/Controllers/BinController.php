<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Models\Location;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class BinController extends Controller
{
    /**
     * Create a new bin under a location.
     * Routes will be nested: /warehouses/{warehouse}/locations/{location}/bins
     */

    public function store(Request $r, Warehouse $warehouse, Location $location)
    {
        // Validate relationship
        if ($location->warehouse_id !== $warehouse->id) {
            abort(404);
        }

        $r->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $location->bins()->create([
            'code' => $r->code,
            'name' => $r->name,
        ]);

        return redirect()->route('warehouses.edit', $warehouse)->with('success', 'Bin added');
    }

    public function edit(Warehouse $warehouse, Location $location, Bin $bin)
    {
        if ($location->warehouse_id !== $warehouse->id || $bin->location_id !== $location->id) {
            abort(404);
        }

        return view('bin.edit', compact('warehouse', 'location', 'bin'));
    }

    public function update(Request $r, Warehouse $warehouse, Location $location, Bin $bin)
    {
        if ($location->warehouse_id !== $warehouse->id || $bin->location_id !== $location->id) {
            abort(404);
        }

        $r->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $bin->update([
            'code' => $r->code,
            'name' => $r->name,
        ]);

        return redirect()->route('warehouses.edit', $warehouse)->with('success', 'Bin updated');
    }

    public function destroy(Warehouse $warehouse, Location $location, Bin $bin)
    {
        if ($location->warehouse_id !== $warehouse->id || $bin->location_id !== $location->id) {
            abort(404);
        }

        $bin->delete();
        return redirect()->route('warehouses.edit', $warehouse)->with('success', 'Bin deleted');
    }
}
