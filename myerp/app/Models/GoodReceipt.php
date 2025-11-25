<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodReceipt extends Model
{
      protected $fillable = [
            'po_id',
            'warehouse_id',
            'received_date',
            'received_by',
      ];

      protected $dates = [
            'received_date'
      ];

      // Relasi ke PurchaseOrder
      public function purchaseOrder()
      {
            return $this->belongsTo(PurchaseOrder::class, 'po_id');
      }


      // Relasi ke Warehouse
      public function warehouse()
      {
            return $this->belongsTo(Warehouse::class);
      }

      // Relasi ke GoodReceiptDetail
      public function details()
      {
            return $this->hasMany(GoodReceiptDetail::class);
      }
}
