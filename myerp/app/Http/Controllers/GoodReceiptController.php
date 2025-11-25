<?php

namespace App\Http\Controllers;

use App\Models\GoodReceipt;
use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GoodReceiptController extends Controller
{
    // INDEX
    public function index()
    {
        $purchaseOrders = PurchaseOrder::orderBy('id', 'desc')->get();
        $warehouses = Warehouse::all();
        $goodReceipts = GoodReceipt::with(['purchaseOrder', 'warehouse'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('good-receipt.index', compact('goodReceipts', 'purchaseOrders', 'warehouses'));
    }

    // CREATE HEADER
    public function create()
    {
        // Ambil PO yg belum full received
        $purchaseOrders = PurchaseOrder::orderBy('id', 'desc')->get();
        $warehouses = Warehouse::all();

        return view('good-receipt.create', compact('purchaseOrders', 'warehouses'));
    }

    // STORE HEADER
    public function store(Request $request)
    {
        $request->validate([
            'po_id' => 'required|exists:purchase_orders,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $goodReceipt = GoodReceipt::create([
            'po_id'         => $request->po_id,
            'warehouse_id'  => $request->warehouse_id,
            'received_date' => now(),
            'received_by' => Auth::user()->name,
        ]);

        return redirect()->route('good-receipt.details.create', $goodReceipt->id)
            ->with('success', 'Good Receipt created.');
    }


    // EDIT (DETAIL INPUT)
    public function edit($id)
    {
        $goodReceipt = GoodReceipt::with(['po.details.product', 'details'])->findOrFail($id);
        $poDetails = $goodReceipt->po->details;

        return view('good-receipt.edit', compact('goodReceipt', 'poDetails'));
    }
}
