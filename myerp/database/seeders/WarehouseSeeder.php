<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use App\Models\Location;
use App\Models\Bin;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        // ============================
        // 1) WAREHOUSE: FINISH GOODS
        // ============================
        $wh1 = Warehouse::firstOrCreate(
            ['code' => 'WHS-FG'],
            ['name' => 'Warehouse Finish Goods']
        );

        $locationsFG = [
            'Packing'  => ['A', 'B', 'C'],
            'Keeping'  => ['A', 'B', 'C'],
            'Loading'  => ['A', 'B', 'C'],
        ];

        foreach ($locationsFG as $locName => $bins) {

            $loc = Location::firstOrCreate(
                [
                    'warehouse_id' => $wh1->id,
                    'code'         => strtoupper(substr($locName, 0, 3)),
                ],
                ['name' => $locName]
            );

            foreach ($bins as $binCode) {
                Bin::firstOrCreate(
                    [
                        'location_id' => $loc->id,
                        'code'        => $binCode,
                    ],
                    ['name' => "Bin $binCode"]
                );
            }
        }

        // ============================
        // 2) WAREHOUSE: RAW MATERIAL
        // ============================
        $wh2 = Warehouse::firstOrCreate(
            ['code' => 'WHS-RM'],
            ['name' => 'Warehouse Raw Material']
        );

        $locationsRM = [
            'Inspection' => ['X', 'Y', 'Z'],
            'Keeping'    => ['X', 'Y', 'Z'],
            'Loading'    => ['X', 'Y', 'Z'],
        ];

        foreach ($locationsRM as $locName => $bins) {

            $loc = Location::firstOrCreate(
                [
                    'warehouse_id' => $wh2->id,
                    'code'         => strtoupper(substr($locName, 0, 3)),
                ],
                ['name' => $locName]
            );

            foreach ($bins as $binCode) {
                Bin::firstOrCreate(
                    [
                        'location_id' => $loc->id,
                        'code'        => $binCode,
                    ],
                    ['name' => "Bin $binCode"]
                );
            }
        }

        echo "WAREHOUSE SEEDED OK\n";
    }
}
