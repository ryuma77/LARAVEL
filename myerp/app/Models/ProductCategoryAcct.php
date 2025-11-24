<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryAcct extends Model
{
      protected $fillable = [
            'product_category_id',
            'inventory_account_id',
            'cogs_account_id',
            'sales_account_id',
      ];

      public function category()
      {
            return $this->belongsTo(ProductCategory::class, 'product_category_id');
      }

      public function inventoryAccount()
      {
            return $this->belongsTo(ChartOfAccount::class, 'inventory_account_id');
      }
}
