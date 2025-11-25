<?php

namespace App\Http\Controllers;

use App\Models\GoodReceipt;
use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GoodReceiptDetail;

class GoodReceiptController extends Controller
{
    public function index()
    {
        $goodReceipts = GoodReceipt::with(['purchaseOrder', 'warehouse'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('good-receipt.index', compact('goodReceipts'));
    }

    public function create()
    {
        $purchaseOrders = PurchaseOrder::with('details')->orderBy('id', 'desc')->get();
        $warehouses = Warehouse::all();

        return view('good-receipt.create', compact('purchaseOrders', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'po_id' => 'required|exists:purchase_orders,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $goodReceipt = GoodReceipt::create([
            'po_id' => $request->po_id,
            'warehouse_id' => $request->warehouse_id,
            'received_date' => now(),
            'received_by' => auth()->user()->name,
        ]);

        return redirect()->route('good-receipt.edit', $goodReceipt->id)
            ->with('success', 'Good Receipt created. Add details below.');
    }

    public function edit($id)
    {
        $goodReceipt = GoodReceipt::with(['purchaseOrder.details.product', 'details.product'])
            ->findOrFail($id);

        $poDetails = $goodReceipt->purchaseOrder->details;

        return view('good-receipt.edit', compact('goodReceipt', 'poDetails'));
    }

    // ADD DETAIL
    public function addDetail(Request $request, $id)
    {
        $goodReceipt = GoodReceipt::with('purchaseOrder.details')->findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|min:1',
        ]);

        // Ambil PO Detail
        $poDetail = $goodReceipt->purchaseOrder->details
            ->where('product_id', $request->product_id)
            ->first();

        if (!$poDetail) {
            return back()->withErrors('Product not in PO.');
        }

        // Hitung qty yg sudah diterima
        $qtyReceived = GoodReceiptDetail::where('good_receipt_id', $id)
            ->where('product_id', $request->product_id)
            ->sum('quantity');

        $qtyRemaining = $poDetail->quantity - $qtyReceived;

        if ($request->quantity > $qtyRemaining) {
            return back()->withErrors("Qty exceeds remaining PO qty ($qtyRemaining).");
        }

        GoodReceiptDetail::create([
            'good_receipt_id' => $id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'unit_price' => $poDetail->unit_price,
            'total_price' => $poDetail->unit_price * $request->quantity,
        ]);

        return back()->with('success', 'Detail added.');
    }

    public function deleteDetail(GoodReceiptDetail $detail)
    {
        $detail->delete();
        return back()->with('success', 'Detail deleted.');
    }
}
