<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessPartner extends Model
{
      protected $fillable = [
            'code',
            'name',
            'type',
            'tax_id',
            'phone',
            'email',
            'website',
            'credit_limit',
            'payment_term_id',
            'is_active',
            'description'
      ];

      // One BP has many Contacts
      public function contacts()
      {
            return $this->hasMany(BPContact::class, 'business_partner_id');
      }

      // One BP has many Addresses
      public function addresses()
      {
            return $this->hasMany(BPAddress::class, 'business_partner_id');
      }

      // One BP has one Accounting setup
      public function accounting()
      {
            return $this->hasOne(BPAccounting::class, 'business_partner_id');
      }
}
