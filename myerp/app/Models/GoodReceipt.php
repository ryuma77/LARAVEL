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

      protected $dates = ['received_date'];

      public function purchaseOrder()
      {
            return $this->belongsTo(PurchaseOrder::class, 'po_id');
      }

      public function warehouse()
      {
            return $this->belongsTo(Warehouse::class);
      }

      public function details()
      {
            return $this->hasMany(GoodReceiptDetail::class);
      }
}
