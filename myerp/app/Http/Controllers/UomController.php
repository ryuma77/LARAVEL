<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use App\Models\UomConversion;
use Illuminate\Http\Request;

class UomController extends Controller
{
    public function index()
    {
        $uoms = Uom::orderBy('code')->get();
        return view('uom.index', compact('uoms'));
    }

    public function create()
    {
        return view('uom.create');
    }

    public function store(Request $r)
    {
        $r->validate([
            'code' => 'required|unique:uoms,code',
            'name' => 'required',
        ]);

        Uom::create($r->only(['code', 'name', 'symbol', 'is_active']));

        return redirect()->route('uom.index')->with('success', 'UoM created');
    }

    public function edit(Uom $uom)
    {
        $uoms = Uom::where('id', '!=', $uom->id)->orderBy('code')->get();
        $conversions = $uom->conversionsFrom()->with('to')->get();
        return view('uom.edit', compact('uom', 'uoms', 'conversions'));
    }

    public function update(Request $r, Uom $uom)
    {
        $r->validate([
            'code' => 'required|unique:uoms,code,' . $uom->id,
            'name' => 'required',
        ]);

        $uom->update($r->only(['code', 'name', 'symbol', 'is_active']));
        return back()->with('success', 'UoM updated');
    }

    public function storeConversion(Request $r, Uom $uom)
    {
        $r->validate([
            'uom_to_id' => 'required|exists:uoms,id|not_in:' . $uom->id,
            'factor' => 'required|numeric|min:0.000000000001',
        ]);

        // create or update conversion from -> to
        UomConversion::updateOrCreate(
            ['uom_from_id' => $uom->id, 'uom_to_id' => $r->uom_to_id],
            ['factor' => $r->factor]
        );

        // create reciprocal conversion (to -> from) with 1/factor
        $recipFactor = 1 / (float) $r->factor;
        UomConversion::updateOrCreate(
            ['uom_from_id' => $r->uom_to_id, 'uom_to_id' => $uom->id],
            ['factor' => $recipFactor]
        );

        return back()->with('success', 'Conversion saved (reciprocal created)');
    }

    public function destroy(Uom $uom)
    {
        // simple safety: do not delete if it's used in conversions or other links
        $used = $uom->conversionsFrom()->exists() || $uom->conversionsTo()->exists();
        if ($used) {
            return back()->with('error', 'UoM in use, cannot delete');
        }

        $uom->delete();
        return redirect()->route('uom.index')->with('success', 'UoM deleted');
    }
}
