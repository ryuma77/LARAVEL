<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Bin extends Model
{
      protected $fillable = ['location_id', 'code', 'name'];
      public function location()
      {
            return $this->belongsTo(Location::class, 'location_id');
      }
}
