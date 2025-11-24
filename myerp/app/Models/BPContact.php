<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BPContact extends Model
{
      protected $table = 'bp_contacts';

      protected $fillable = [
            'business_partner_id',
            'name',
            'phone',
            'email',
            'job_title'
      ];

      public function partner()
      {
            return $this->belongsTo(BusinessPartner::class, 'business_partner_id');
      }
}
