<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'is_active',
    ];
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function accounting()
    {
        return $this->hasOne(ProductCategoryAcct::class, 'product_category_id');
    }

    public function isUsingAverageCost()
    {
        return $this->costing_method === 'average';
    }
    // atau
    public function isUsingFifo()
    {
        return $this->costing_method === 'fifo';
    }
}
