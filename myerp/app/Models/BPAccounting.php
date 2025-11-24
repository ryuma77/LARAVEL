<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BPAccounting extends Model
{
      protected $table = 'bp_accounting';

      protected $fillable = [
            'business_partner_id',
            'ar_account_id',
            'ap_account_id'
      ];

      public function partner()
      {
            return $this->belongsTo(BusinessPartner::class, 'business_partner_id');
      }

      public function arAccount()
      {
            return $this->belongsTo(\App\Models\ChartOfAccount::class, 'ar_account_id');
      }

      public function apAccount()
      {
            return $this->belongsTo(\App\Models\ChartOfAccount::class, 'ap_account_id');
      }
}
