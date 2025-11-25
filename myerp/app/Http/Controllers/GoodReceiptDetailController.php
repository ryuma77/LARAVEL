<?php

namespace App\Http\Controllers;

use App\Models\GoodReceipt;
use App\Models\GoodReceiptDetail;
use Illuminate\Http\Request;

class GoodReceiptDetailController extends Controller
{
    // FORM INPUT DETAIL
    public function create($goodReceiptId)
    {
        $goodReceipt = GoodReceipt::with(['purchaseOrder.details.product'])
            ->findOrFail($goodReceiptId);

        $poDetails = $goodReceipt->purchaseOrder->details;

        return view('good-receipt.detail', compact('goodReceipt', 'poDetails'));
    }

    // STORE DETAIL
    public function store(Request $request, $goodReceiptId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|min:1',
        ]);

        $goodReceipt = GoodReceipt::with('purchaseOrder.details')
            ->findOrFail($goodReceiptId);

        // cek apakah product ada di PO
        $poDetail = $goodReceipt->purchaseOrder
            ->details
            ->where('product_id', $request->product_id)
            ->first();

        if (!$poDetail) {
            return back()->withErrors("Product not found in Purchase Order!");
        }

        // CREATE DETAIL
        GoodReceiptDetail::create([
            'good_receipt_id' => $goodReceipt->id,
            'product_id'      => $request->product_id,
            'quantity'        => $request->quantity,
            'unit_price'      => $poDetail->unit_price,
            'total_price'     => $poDetail->unit_price * $request->quantity,
        ]);

        return redirect()
            ->route('good-receipt.index')
            ->with('success', 'Good Receipt Detail added!');
    }
}
