<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'so_number',
        'customer_id',
        'order_date',
        'status',
        'total_amount',
        'created_by',
        'notes',
    ];

    // Relasi ke customer (business partner)
    public function customer()
    {
        return $this->belongsTo(BusinessPartner::class, 'customer_id');
    }

    // public function businessPartner()
    // {
    //     return $this->belongsTo(BusinessPartner::class, 'bp_id');
    // }


    // Relasi ke detail
    public function details()
    {
        return $this->hasMany(SalesOrderDetail::class);
    }

    public function updateTotal()
    {
        $total = $this->details()->sum('total_price');

        $this->total_amount = $total;
        $this->save();
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'so_id');
    }
}
