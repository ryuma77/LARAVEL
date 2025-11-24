<?php

namespace App\Http\Controllers;

use App\Models\GoodReceipt;
use App\Models\GoodReceiptDetail;
use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class GoodReceiptDetailController extends Controller
{
    // Menampilkan form untuk membuat Good Receipt Detail
    public function create($goodReceiptId)
    {
        // Ambil Good Receipt berdasarkan ID
        $goodReceipt = GoodReceipt::findOrFail($goodReceiptId);

        // Ambil semua produk dari PO terkait (hanya produk yang ada di PO yang dipilih)
        $poDetails = $goodReceipt->purchaseOrder->details;

        return view('good-receipt.detail', compact('goodReceipt', 'poDetails'));
    }

    // Menyimpan Good Receipt Detail
    public function store(Request $request, $goodReceiptId)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
        ]);

        // Ambil Good Receipt berdasarkan ID
        $goodReceipt = GoodReceipt::findOrFail($goodReceiptId);

        // Cek apakah produk yang diterima ada dalam PO yang dipilih
        $poDetail = $goodReceipt->purchaseOrder->details->where('product_id', $request->product_id)->first();
        if (!$poDetail) {
            return redirect()->back()->withErrors('This product is not part of the selected Purchase Order.');
        }

        // Simpan detail Good Receipt
        GoodReceiptDetail::create([
            'good_receipt_id' => $goodReceipt->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'unit_price' => $poDetail->unit_price, // Mengambil harga dari PO detail
            'total_price' => $poDetail->unit_price * $request->quantity,
        ]);

        return redirect()->route('good-receipt.index')->with('success', 'Good Receipt Detail added successfully');
    }
}
