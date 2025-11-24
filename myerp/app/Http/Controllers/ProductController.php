<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAcct;
use App\Models\ProductCategory;
use App\Models\ChartOfAccount;
use App\Models\StockOnHand;
use App\Models\StockMovement;
use App\Models\Warehouse;
use App\Models\Uom;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(20);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        $coa = ChartOfAccount::orderBy('code')->get();
        $uoms = Uom::orderBy('code')->get();

        return view('products.create', compact('categories', 'coa', 'uoms'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required'
        ]);

        $product = Product::create([
            'sku' => $r->sku,
            'name' => $r->name,
            'type' => $r->type,
            'category_id' => $r->category_id,
            'uom_id' => $r->uom,
            'description' => $r->description,
            'is_active' => true,
        ]);

        return redirect()->route('products.edit', $product)->with('success', 'Product created');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::orderBy('name')->get();
        $coa = ChartOfAccount::orderBy('code')->get();
        $uoms = Uom::orderBy('code')->get();
        // get current stock summary
        $stockSummary = StockOnHand::where('product_id', $product->id)
            ->selectRaw('warehouse_id, sum(qty) as qty')->groupBy('warehouse_id')
            ->with('warehouse')->get();

        // histories simple
        $purchaseHistory = StockMovement::where('product_id', $product->id)
            ->where('ref_type', 'purchase')->latest()->limit(20)->get();
        $salesHistory = StockMovement::where('product_id', $product->id)
            ->where('ref_type', 'sale')->latest()->limit(20)->get();
        $stockMovements = StockMovement::where('product_id', $product->id)->latest()->limit(50)->get();

        return view('products.edit', compact('product', 'categories', 'coa', 'uoms', 'stockSummary', 'purchaseHistory', 'salesHistory', 'stockMovements'));
    }

    public function update(Request $r, Product $product)
    {
        $r->validate(['sku' => 'required|unique:products,sku,' . $product->id, 'name' => 'required']);
        $product->update($r->only(['sku', 'name', 'type', 'category_id', 'uom_id', 'description', 'is_active']));
        return back()->with('success', 'Product updated');
    }

    public function updateAccounting(Product $product, Request $r)
    {
        $product->accounting()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'inventory_account_id' => $r->inventory_account_id,
                'cogs_account_id' => $r->cogs_account_id,
                'sales_account_id' => $r->sales_account_id,
            ]
        );
        return back()->with('success', 'Product accounting saved');
    }
}
