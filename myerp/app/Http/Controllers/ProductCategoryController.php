<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductCategoryAcct;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::with('parent')->orderBy('name')->get();
        return view('product-category.index', compact('categories'));
    }

    public function create()
    {
        $parents = ProductCategory::all();
        return view('product-category.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
        ]);

        $category = ProductCategory::create([
            'name'        => $request->name,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
            'is_active'   => true,
        ]);

        // Setelah create → redirect ke edit (karena Accounting Tab hanya muncul di edit)
        return redirect()->route('product-category.edit', $category->id)
            ->with('success', 'Category created');
    }

    public function edit(ProductCategory $category)
    {
        $parents = ProductCategory::where('id', '!=', $category->id)->get();
        $coa = ChartOfAccount::orderBy('code')->get();

        return view('product-category.edit', compact('category', 'parents', 'coa'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
        ]);

        return back()->with('success', 'Category updated');
    }

    public function updateAccounting(ProductCategory $category, Request $request)
    {
        $category->accounting()->updateOrCreate(
            ['product_category_id' => $category->id],
            [
                'inventory_account_id' => $request->inventory_account_id,
                'cogs_account_id'      => $request->cogs_account_id,
                'sales_account_id'     => $request->sales_account_id,
            ]
        );

        return back()->with('success', 'Accounting setup saved');
    }
}
