<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\BusinessPartner;
use App\Models\Product;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    // ============================
    // INDEX (LIST)
    // ============================
    public function index()
    {
        $salesOrders = SalesOrder::with('customer')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('sales-order.index', compact('salesOrders'));
    }

    // ============================
    // CREATE (HEADER)
    // ============================
    public function create()
    {
        $customers = BusinessPartner::whereIn('type', ['customer', 'both'])
            ->orderBy('name')
            ->get();

        return view('sales-order.create', compact('customers'));
    }

    // ============================
    // STORE (HEADER)
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:business_partners,id',
            'order_date'  => 'required|date',
        ]);

        // generate so number
        $soNumber = 'SO-' . now()->format('Ymd') . '-' . rand(100, 999);

        $salesOrder = SalesOrder::create([
            'so_number'   => $soNumber,
            'customer_id' => $request->customer_id,
            'order_date'  => $request->order_date,
            'status'      => 'draft',
            'total_amount' => 0,
            'created_by'  => auth()->user()->name,
            'notes'       => $request->notes,
        ]);

        return redirect()->route('sales-order.edit', $salesOrder->id)
            ->with('success', 'Sales Order created. Now add details.');
    }

    // ============================
    // EDIT = HEADER + DETAILS PAGE
    // ============================
    public function edit($id)
    {
        $salesOrder = SalesOrder::with(['details.product'])->findOrFail($id);
        $customers  = BusinessPartner::whereIn('type', ['customer', 'both'])->get();
        $products   = Product::orderBy('name')->get();

        return view('sales-order.edit', compact('salesOrder', 'customers', 'products'));
    }

    // ============================
    // UPDATE HEADER
    // ============================
    public function update(Request $request, $id)
    {
        $salesOrder = SalesOrder::findOrFail($id);

        $request->validate([
            'customer_id' => 'required|exists:business_partners,id',
            'order_date'  => 'required|date',
        ]);

        $salesOrder->update([
            'customer_id' => $request->customer_id,
            'order_date'  => $request->order_date,
            'notes'       => $request->notes,
        ]);

        return back()->with('success', 'Sales Order updated.');
    }

    // ============================
    // ADD DETAIL
    // ============================
    public function addDetail(Request $r, $salesOrderId)
    {
        $r->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0'
        ]);

        $so = SalesOrder::findOrFail($salesOrderId);

        // ambil product
        $product = Product::findOrFail($r->product_id);

        // uom id otomatis dari product
        $uomId = $product->uom_id;

        $detail = SalesOrderDetail::create([
            'sales_order_id' => $salesOrderId,
            'product_id'     => $r->product_id,
            'uom_id'         => $uomId,     // <-- FIX DISINI
            'quantity'       => $r->quantity,
            'unit_price'     => $r->unit_price,
            'total_price'    => $r->quantity * $r->unit_price,
        ]);

        // update header total
        $so->updateTotal();

        return back()->with('success', 'Detail added');
    }


    // ============================
    // DELETE DETAIL
    // ============================
    public function deleteDetail($soId, $detailId)
    {
        $detail = SalesOrderDetail::where('sales_order_id', $soId)
            ->where('id', $detailId)
            ->firstOrFail();

        $detail->delete();

        // recalc total
        $so = SalesOrder::find($soId);
        $so->total_amount = $so->details()->sum('total_price');
        $so->save();

        return back()->with('success', 'Detail removed.');
    }
}
