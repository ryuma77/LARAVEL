<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAcct extends Model
{
      protected $table = 'product_accts';
      protected $fillable = ['product_id', 'inventory_account_id', 'cogs_account_id', 'sales_account_id'];
      public function product()
      {
            return $this->belongsTo(Product::class, 'product_id');
      }
}
