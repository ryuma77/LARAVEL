<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodReceiptDetail extends Model
{
      protected $fillable = [
            'good_receipt_id',
            'product_id',
            'quantity',
            'unit_price',
            'total_price'
      ];

      public function goodReceipt()
      {
            return $this->belongsTo(GoodReceipt::class);
      }

      public function product()
      {
            return $this->belongsTo(Product::class);
      }
}
