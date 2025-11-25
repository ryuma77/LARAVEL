<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'so_id',
        'shipment_number',
        'shipment_date',
        'warehouse_id',
        'delivered_by',
        'status',
    ];

    // --- Relationships ---

    // Shipment belongs to a Sales Order
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'so_id');
    }

    // Shipment has many detail lines
    public function details()
    {
        return $this->hasMany(ShipmentDetail::class, 'shipment_id');
    }

    // Shipment belongs to warehouse
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    // Auto-generate shipment number
    public static function generateNumber()
    {
        $prefix = "SHP-" . date('Ymd') . "-";

        $last = self::where('shipment_number', 'LIKE', $prefix . '%')
            ->orderBy('shipment_number', 'DESC')
            ->first();

        if ($last) {
            $num = intval(str_replace($prefix, '', $last->shipment_number)) + 1;
        } else {
            $num = 1;
        }

        return $prefix . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
