<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UomConversion extends Model
{
      protected $table = 'uom_conversions';
      protected $fillable = ['uom_from_id', 'uom_to_id', 'factor'];

      public function from()
      {
            return $this->belongsTo(Uom::class, 'uom_from_id');
      }
      public function to()
      {
            return $this->belongsTo(Uom::class, 'uom_to_id');
      }
}
