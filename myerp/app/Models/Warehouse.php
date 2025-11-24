<?php


namespace App\Models;

use App\Models\Location;


use Illuminate\Database\Eloquent\Model;


class Warehouse extends Model
{
      protected $fillable = ['code', 'name'];
      public function locations()
      {
            return $this->hasMany(Location::class, 'warehouse_id');
      }
}
