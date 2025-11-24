<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Uom;

class UomSeeder extends Seeder
{
    public function run(): void
    {
        $list = [
            ['code' => 'PCS', 'name' => 'Pieces', 'symbol' => 'pcs'],
            ['code' => 'KG', 'name' => 'Kilogram', 'symbol' => 'kg'],
            ['code' => 'M', 'name' => 'Meter', 'symbol' => 'm'],
            ['code' => 'ONS', 'name' => 'Ons', 'symbol' => 'ons'],
            ['code' => 'GR', 'name' => 'Gram', 'symbol' => 'g'],
            ['code' => 'BOX', 'name' => 'Box', 'symbol' => 'box'],
            ['code' => 'DOZ', 'name' => 'Dozen', 'symbol' => 'doz'],
        ];

        foreach ($list as $u) {
            Uom::firstOrCreate(['code' => $u['code']], $u);
        }
    }
}
