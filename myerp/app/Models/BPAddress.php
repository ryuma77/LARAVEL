<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BPAddress extends Model
{
      protected $table = 'bp_addresses';

      protected $fillable = [
            'business_partner_id',
            'address_type',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'country',
            'postal_code'
      ];

      public function partner()
      {
            return $this->belongsTo(BusinessPartner::class, 'business_partner_id');
      }
}
