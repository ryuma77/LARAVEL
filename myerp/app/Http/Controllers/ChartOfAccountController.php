<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $coa = ChartOfAccount::orderBy('code')->get();
        return view('coa.index', compact('coa'));
    }

    public function create()
    {
        $types = ['asset', 'liability', 'equity', 'revenue', 'expense'];
        $parents = ChartOfAccount::orderBy('code')->get();
        return view('coa.create', compact('types', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:chart_of_accounts,code',
            'name' => 'required',
            'type' => 'required|in:asset,liability,equity,revenue,expense',
        ]);

        ChartOfAccount::create([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'is_parent' => $request->is_parent ? true : false,
        ]);

        return redirect()->route('coa.index')->with('success', 'COA created');
    }

    public function edit(ChartOfAccount $coa)
    {
        $types = ['asset', 'liability', 'equity', 'revenue', 'expense'];
        $parents = ChartOfAccount::where('id', '!=', $coa->id)->orderBy('code')->get();
        return view('coa.edit', compact('coa', 'types', 'parents'));
    }

    public function update(Request $request, ChartOfAccount $coa)
    {
        $request->validate([
            'code' => "required|unique:chart_of_accounts,code,{$coa->id}",
            'name' => 'required',
            'type' => 'required|in:asset,liability,equity,revenue,expense',
        ]);

        $coa->update($request->all());

        return redirect()->route('coa.index')->with('success', 'COA updated');
    }

    public function destroy(ChartOfAccount $coa)
    {
        $coa->delete();

        return redirect()->route('coa.index')->with('success', 'COA deleted');
    }
}
