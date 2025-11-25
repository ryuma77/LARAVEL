<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Shipment;
use App\Models\ShipmentDetail;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Uom;
use App\Models\Bin;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * LIST SHIPMENTS
     */
    public function index()
    {
        $shipments = Shipment::with(['salesOrder', 'warehouse'])
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('shipments.index', compact('shipments'));
    }

    /**
     * CREATE SHIPMENT HEADER
     */
    public function create()
    {
        $salesOrders = SalesOrder::orderBy('id', 'desc')->get();
        $warehouses = Warehouse::all();

        return view('shipments.create', compact('salesOrders', 'warehouses'));
    }

    /**
     * STORE SHIPMENT HEADER
     */
    public function store(Request $r)
    {
        $r->validate([
            'so_id'        => 'required|exists:sales_orders,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $shipment = Shipment::create([
            'so_id'           => $r->so_id,
            'shipment_number' => Shipment::generateNumber(),
            'shipment_date'   => now(),
            'warehouse_id'    => $r->warehouse_id,
            'delivered_by'    => auth()->user()->name,
            'status'          => 'draft',
        ]);

        return redirect()->route('shipments.edit', $shipment->id)
            ->with('success', 'Shipment created, continue adding details.');
    }

    /**
     * EDIT PAGE (HEADER + DETAILS)
     */
    public function edit($id)
    {
        $shipment = Shipment::with(['details.product', 'details.uom', 'salesOrder.details'])
            ->findOrFail($id);

        $warehouse = $shipment->warehouse;
        $bins = Bin::all(); // nanti difilter sesuai locator yg dipilih
        $salesOrderDetails = $shipment->salesOrder->details;

        return view('shipments.edit', compact(
            'shipment',
            'bins',
            'salesOrderDetails'
        ));
    }

    /**
     * UPDATE SHIPMENT HEADER
     */
    public function update(Request $r, Shipment $shipment)
    {
        $r->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $shipment->update([
            'warehouse_id' => $r->warehouse_id,
        ]);

        return back()->with('success', 'Shipment updated.');
    }

    /**
     * ADD SHIPMENT DETAIL
     */
    public function addDetail(Request $r, $shipmentId)
    {
        $r->validate([
            'product_id' => 'required|exists:products,id',
            'bin_id'     => 'required|exists:bins,id',
            'quantity'   => 'required|numeric|min:1',
        ]);

        $shipment = Shipment::findOrFail($shipmentId);

        // Only products that exist in Sales Order
        $soDetail = $shipment->salesOrder->details
            ->where('product_id', $r->product_id)
            ->first();

        if (!$soDetail) {
            return back()->withErrors("Product does not exist in Sales Order.");
        }

        // Validate quantity (cannot exceed ordered qty)
        $alreadyShipped = ShipmentDetail::where('product_id', $r->product_id)
            ->whereHas('shipment', function ($q) use ($shipment) {
                $q->where('so_id', $shipment->so_id);
            })
            ->sum('quantity');

        $max = $soDetail->quantity - $alreadyShipped;

        if ($r->quantity > $max) {
            return back()->withErrors("Quantity exceeds remaining SO qty. Max allowed: $max");
        }

        ShipmentDetail::create([
            'shipment_id' => $shipment->id,
            'product_id'  => $r->product_id,
            'uom_id'      => $soDetail->uom_id,
            'quantity'    => $r->quantity,
            'bin_id'      => $r->bin_id,
        ]);

        return back()->with('success', 'Shipment detail added.');
    }

    /**
     * DELETE DETAIL
     */
    public function deleteDetail($detailId)
    {
        ShipmentDetail::findOrFail($detailId)->delete();

        return back()->with('success', 'Detail removed.');
    }

    /**
     * POST SHIPMENT (deduct stock)
     */
    public function post($id)
    {
        $shipment = Shipment::with('details')->findOrFail($id);

        // TODO: Stock deduction logic + GL posting (next step)
        $shipment->update(['status' => 'posted']);

        return redirect()->route('shipments.index')
            ->with('success', 'Shipment posted.');
    }
}
