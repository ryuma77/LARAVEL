<?php

namespace App\Http\Controllers;

use App\Models\GoodReceipt;
use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use App\Models\Location;
use App\Models\Bin;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\GoodReceiptDetail;

class GoodReceiptController extends Controller
{
    // Menampilkan daftar Good Receipts
    public function index()
    {
        $purchaseOrders = PurchaseOrder::all();
        $goodReceipts = GoodReceipt::with('purchaseOrder', 'warehouse')
            ->orderBy('received_date', 'desc') // Menampilkan berdasarkan tanggal terima terbaru
            ->get();

        return view('good-receipt.index', compact('goodReceipts', 'purchaseOrders'));
    }

    // Menampilkan form untuk membuat Good Receipt
    public function create()
    {
        // Ambil semua Purchase Orders yang statusnya "open"
        $purchaseOrders = PurchaseOrder::all();
        $warehouses = Warehouse::all();

        return view('good-receipt.create', compact('purchaseOrders', 'warehouses'));
    }

    // Menyimpan Good Receipt header
    public function store(Request $request)
    {
        $request->validate([
            'po_id' => 'required|exists:purchase_orders,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        // Menyimpan header Good Receipt
        $goodReceipt = GoodReceipt::create([
            'po_id' => $request->po_id,
            'warehouse_id' => $request->warehouse_id,
            'received_date' => now(),
        ]);

        // Redirect ke halaman Good Receipt Detail setelah header disimpan
        return redirect()->route('good-receipt.details.create', $goodReceipt->id);
    }

    // Menampilkan form untuk menambah detail Good Receipt
    public function createDetails($goodReceiptId)
    {
        $goodReceipt = GoodReceipt::findOrFail($goodReceiptId);
        $poDetails = $goodReceipt->purchaseOrder->details;
        $locations = Location::where('warehouse_id', $goodReceipt->warehouse_id)->get();
        $bins = Bin::all(); // Bisa disesuaikan jika perlu filter bin berdasarkan location

        return view('good-receipt.details.create', compact('goodReceipt', 'poDetails', 'locations', 'bins'));
    }

    // Menyimpan detail Good Receipt
    public function storeDetails(Request $request, $goodReceiptId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'location_id' => 'required|exists:locations,id',
            'bin_id' => 'required|exists:bins,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        // Simpan detail Good Receipt
        $goodReceipt = GoodReceipt::findOrFail($goodReceiptId);

        GoodReceiptDetail::create([
            'good_receipt_id' => $goodReceipt->id,
            'product_id' => $request->product_id,
            'location_id' => $request->location_id,
            'bin_id' => $request->bin_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('good-receipt.index')->with('success', 'Good Receipt created successfully');
    }
}
