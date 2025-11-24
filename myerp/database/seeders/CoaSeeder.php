<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartOfAccount;

class CoaSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [

            // ------------------ ASSET (1xxxx) ------------------
            ['code' => '10000', 'name' => 'Cash', 'type' => 'asset', 'is_parent' => false],
            ['code' => '11000', 'name' => 'Bank', 'type' => 'asset', 'is_parent' => false],
            ['code' => '12000', 'name' => 'Account Receivable', 'type' => 'asset', 'is_parent' => false],
            ['code' => '13000', 'name' => 'Inventory', 'type' => 'asset', 'is_parent' => false],

            // ---------------- LIABILITY (2xxxx) -----------------
            ['code' => '20000', 'name' => 'Account Payable', 'type' => 'liability', 'is_parent' => false],
            ['code' => '21000', 'name' => 'Accrued Liability', 'type' => 'liability', 'is_parent' => false],

            // ------------------ EQUITY (3xxxx) -------------------
            ['code' => '30000', 'name' => 'Owner Equity', 'type' => 'equity', 'is_parent' => false],
            ['code' => '31000', 'name' => 'Retained Earnings', 'type' => 'equity', 'is_parent' => false],

            // ------------------ REVENUE (4xxxx) ------------------
            ['code' => '40000', 'name' => 'Sales Revenue', 'type' => 'revenue', 'is_parent' => false],
            ['code' => '41000', 'name' => 'Service Revenue', 'type' => 'revenue', 'is_parent' => false],

            // ------------------ EXPENSE (5xxxx) ------------------
            ['code' => '50000', 'name' => 'Cost of Goods Sold', 'type' => 'expense', 'is_parent' => false],
            ['code' => '51000', 'name' => 'Operating Expense', 'type' => 'expense', 'is_parent' => false],
        ];

        foreach ($accounts as $acc) {
            ChartOfAccount::firstOrCreate(
                ['code' => $acc['code']],
                $acc
            );
        }
    }
}
