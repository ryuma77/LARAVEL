<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodReceipt extends Model
{
      protected $fillable = [
            'purchase_order_id',
            'warehouse_id',
            'received_date'
      ];

      public function purchaseOrder()
      {
            return $this->belongsTo(PurchaseOrder::class);
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
