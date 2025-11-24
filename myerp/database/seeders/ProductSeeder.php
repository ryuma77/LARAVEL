<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Uom;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // ambil category
        $finishGoods     = ProductCategory::where('name', 'Finished Goods')->first();
        $rawMaterials    = ProductCategory::where('name', 'Raw Materials')->first();
        $officeEquipment = ProductCategory::where('name', 'Office Equipment')->first();
        $supportingGoods = ProductCategory::where('name', 'Supporting Goods')->first();
        $itPeripheral    = ProductCategory::where('name', 'IT Peripheral')->first();
        $wip             = ProductCategory::where('name', 'WIP')->first();
        $uomPCS          = Uom::where('name', 'Pieces')->first();

        // Data produk
        $products = [
            // FINISHED GOODS
            [
                'sku' => 'FG-001',
                'name' => 'Product A',
                'type' => 'item',
                'uom_id' => $uomPCS->id,
                'category_id' => $finishGoods?->id
            ],
            ['sku' => 'FG-002', 'name' => 'Product B', 'type' => 'item',  'uom_id' => $uomPCS->id, 'category_id' => $finishGoods?->id],

            // RAW MATERIALS
            ['sku' => 'RM-001', 'name' => 'Raw Material A', 'type' => 'item',  'uom_id' => $uomPCS->id, 'category_id' => $rawMaterials?->id],
            ['sku' => 'RM-002', 'name' => 'Raw Material B', 'type' => 'item',  'uom_id' => $uomPCS->id, 'category_id' => $rawMaterials?->id],

            // OFFICE EQUIPMENT
            ['sku' => 'OE-001', 'name' => 'Office Chair', 'type' => 'asset',  'uom_id' => $uomPCS->id, 'category_id' => $officeEquipment?->id],
            ['sku' => 'OE-002', 'name' => 'Meeting Table', 'type' => 'asset', 'uom_id' => $uomPCS->id, 'category_id' => $officeEquipment?->id],

            // SUPPORTING GOODS
            ['sku' => 'SG-001', 'name' => 'Support Tool A', 'type' => 'item',  'uom_id' => $uomPCS->id, 'category_id' => $supportingGoods?->id],

            // IT PERIPHERAL
            ['sku' => 'IT-001', 'name' => 'Mouse Wireless', 'type' => 'item', 'uom_id' => $uomPCS->id, 'category_id' => $itPeripheral?->id],
            ['sku' => 'IT-002', 'name' => 'Keyboard Wireless', 'type' => 'item',  'uom_id' => $uomPCS->id, 'category_id' => $itPeripheral?->id],

            // WIP
            ['sku' => 'WIP-001', 'name' => 'Semi-Finished Product A', 'type' => 'item',  'uom_id' => $uomPCS->id, 'category_id' => $wip?->id],
        ];

        foreach ($products as $prod) {
            Product::firstOrCreate(
                ['sku' => $prod['sku']],
                $prod
            );
        }

        echo "PRODUCTS SEEDED OK\n";
    }
}
