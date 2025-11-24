<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAcct;
use App\Models\StockOnHand;
use App\Models\StockMovement;

class Product extends Model
{
      protected $fillable = ['sku', 'name', 'type', 'category_id', 'uom_id', 'is_active', 'description'];

      public function category()
      {
            return $this->belongsTo(ProductCategory::class, 'category_id');
      }
      public function accounting()
      {
            return $this->hasOne(ProductAcct::class, 'product_id');
      }
      public function stockOnHand()
      {
            return $this->hasMany(StockOnHand::class, 'product_id');
      }
      public function stockMovements()
      {
            return $this->hasMany(StockMovement::class, 'product_id');
      }

      // helpers: return inherited or overridden acct ids
      public function inventoryAccountId()
      {
            return $this->accounting?->inventory_account_id ?? $this->category?->accounting?->inventory_account_id;
      }
      public function cogsAccountId()
      {
            return $this->accounting?->cogs_account_id ?? $this->category?->accounting?->cogs_account_id;
      }
      public function salesAccountId()
      {
            return $this->accounting?->sales_account_id ?? $this->category?->accounting?->sales_account_id;
      }
      public function uom()
      {
            return $this->belongsTo(Uom::class, 'uom_id');
      }
}
