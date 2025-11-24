<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class StockOnHand extends Model
{
      protected $table = 'stock_on_hand';
      protected $fillable = ['product_id', 'warehouse_id', 'location_id', 'bin_id', 'qty'];


      public function product()
      {
            return $this->belongsTo(Product::class, 'product_id');
      }
      public function warehouse()
      {
            return $this->belongsTo(Warehouse::class, 'warehouse_id');
      }
      public function location()
      {
            return $this->belongsTo(Location::class, 'location_id');
      }
      public function bin()
      {
            return $this->belongsTo(Bin::class, 'bin_id');
      }
}
