<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;
use App\Models\Bin;


class Location extends Model
{
      protected $fillable = ['warehouse_id', 'code', 'name'];
      public function warehouse()
      {
            return $this->belongsTo(Warehouse::class, 'warehouse_id');
      }
      public function bins()
      {
            return $this->hasMany(Bin::class, 'location_id');
      }
}
