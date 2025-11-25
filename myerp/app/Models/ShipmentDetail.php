<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    protected $fillable = [
        'shipment_id',
        'product_id',
        'uom_id',
        'quantity',
        'bin_id',
    ];

    // Belongs to shipment header
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

    // Belongs to product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Belongs to UoM
    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }

    // Belongs to Bin
    public function bin()
    {
        return $this->belongsTo(Bin::class, 'bin_id');
    }
}
