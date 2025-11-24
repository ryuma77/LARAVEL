<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Finish Goods',       'description' => 'Finished manufactured products',  'costing_method' => 'average',],
            ['name' => 'Raw Materials',      'description' => 'Materials used in production', 'costing_method' => 'average',],
            ['name' => 'Office Equipment',   'description' => 'Office tools and equipment', 'costing_method' => 'average',],
            ['name' => 'Supporting Goods',   'description' => 'Supporting materials for operations', 'costing_method' => 'average',],
            ['name' => 'IT Peripheral',      'description' => 'Hardware & IT related accessories', 'costing_method' => 'average',],
            ['name' => 'WIP',                'description' => 'Work in progress', 'costing_method' => 'average',],
        ];

        foreach ($categories as $cat) {
            ProductCategory::firstOrCreate(
                ['name' => $cat['name']],
                [
                    'description' => $cat['description'],
                    'parent_id'   => null,
                    'is_active'   => true,
                ]
            );
        }
    }
}
