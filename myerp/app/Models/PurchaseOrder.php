<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
      protected $fillable = [
            'po_number',
            'vendor_id',
            'po_date',
            'status',
            'total_amount',
            'notes'
      ];

      public function vendor()
      {
            return $this->belongsTo(BusinessPartner::class, 'vendor_id');
      }

      private function generateNumber()
      {
            $prefix = 'PO-' . date('Ym') . '-';

            $last = PurchaseOrder::where('po_number', 'like', $prefix . '%')
                  ->orderBy('po_number', 'desc')
                  ->first();

            if (!$last) return $prefix . '0001';

            $lastNumber = (int) substr($last->po_number, -4);
            return $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
      }

      // app/Models/PurchaseOrder.php

      public function details()
      {
            return $this->hasMany(PurchaseOrderDetail::class);
      }
}
