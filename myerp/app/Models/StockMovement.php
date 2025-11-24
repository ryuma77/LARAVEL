<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class StockMovement extends Model
{
      protected $fillable = [
            'product_id',
            'ref_type',
            'ref_id',
            'from_warehouse_id',
            'to_warehouse_id',
            'from_location_id',
            'to_location_id',
            'from_bin_id',
            'to_bin_id',
            'qty',
            'note'
      ];


      public function product()
      {
            return $this->belongsTo(Product::class, 'product_id');
      }
}
