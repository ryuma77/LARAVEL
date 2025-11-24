<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;
use App\Models\PurchaseOrderDetail;
use App\Models\Product;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $po = PurchaseOrder::with('vendor')->orderBy('id', 'desc')->paginate(20);
        return view('po.index', compact('po'));
    }

    public function create()
    {
        // pilih hanya vendor atau both
        $vendors = BusinessPartner::whereIn('type', ['vendor', 'both'])
            ->orderBy('name')->get();

        return view('po.create', compact('vendors'));
    }

    private function generateNumber()
    {
        $prefix = 'PO-' . date('Ym') . '-';

        $last = PurchaseOrder::where('po_number', 'like', $prefix . '%')
            ->orderBy('po_number', 'desc')
            ->first();

        if (!$last) return $prefix . '0001';

        $lastNumber = (int) substr($last->po_number, -4);
        return $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function store(Request $r)
    {
        $r->validate([
            'vendor_id' => 'required|exists:business_partners,id',
            'po_date'   => 'required|date',
        ]);

        $po = PurchaseOrder::create([
            'po_number'   => $this->generateNumber(),
            'vendor_id'   => $r->vendor_id,
            'po_date'     => $r->po_date,
            'status'      => 'draft',
            'notes'       => $r->notes,
            'total_amount' => 0,
        ]);

        return redirect()->route('po.edit', $po)->with('success', 'PO created');
    }

    public function edit(PurchaseOrder $po)
    {
        $products = Product::orderBy('name')->get();
        $vendors = BusinessPartner::whereIn('type', ['vendor', 'both'])
            ->orderBy('name')->get();

        return view('po.edit', compact('po', 'products', 'vendors'));
    }

    public function update(Request $r, PurchaseOrder $po)
    {
        $r->validate([
            'vendor_id' => 'required|exists:business_partners,id',
            'po_date'   => 'required|date',
        ]);

        $po->update([
            'vendor_id' => $r->vendor_id,
            'po_date'   => $r->po_date,
            'notes'     => $r->notes,
        ]);

        return back()->with('success', 'PO updated');
    }

    public function storeDetail(Request $request, PurchaseOrder $po)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        // Menghitung total harga
        $total_price = $request->quantity * $request->unit_price;

        // Menyimpan detail PO
        $poDetail = new PurchaseOrderDetail([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $total_price,
        ]);

        // Menyimpan detail PO ke dalam PO yang sudah ada
        $po->details()->save($poDetail);

        // Update total_amount pada PO
        $po->update([
            'total_amount' => $po->details->sum('total_price'),
        ]);

        return redirect()->route('po.edit', $po)->with('success', 'Purchase Order Detail added');
    }
}
