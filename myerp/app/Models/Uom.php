<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
      protected $fillable = ['code', 'name', 'symbol', 'is_active'];

      public function conversionsFrom()
      {
            return $this->hasMany(UomConversion::class, 'uom_from_id');
      }

      public function conversionsTo()
      {
            return $this->hasMany(UomConversion::class, 'uom_to_id');
      }
      public static function convert($fromId, $toId, $qty)
      {
            if ($fromId == $toId) return $qty;
            $conv = UomConversion::where('uom_from_id', $fromId)
                  ->where('uom_to_id', $toId)
                  ->first();
            if (!$conv) return null; // or throw exception
            return (float)$qty * (float)$conv->factor;
      }
}
