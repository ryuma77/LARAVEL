<?php

namespace Database\Seeders;

use App\Models\BPAccounting;
use App\Models\BPAddress;
use App\Models\BPContact;
use Illuminate\Database\Seeder;
use App\Models\BusinessPartner;
use App\Models\BusinessPartnerAcct;
use App\Models\BusinessPartnerContact;
use App\Models\BusinessPartnerAddress;
use App\Models\ChartOfAccount;

class BusinessPartnerSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil account AR dan AP default
        $ar = ChartOfAccount::where('code', '110000')->first(); // Account Receivable
        $ap = ChartOfAccount::where('code', '210000')->first(); // Account Payable

        // === SAMPLE CUSTOMERS ===
        $customers = [
            [
                'code' => 'BP-CUS-001',
                'name' => 'PT Customer Sukses',
                'type' => 'customer',
                'email' => 'info@customer.com',
                'phone' => '021-555111',
                'tax_id' => '01.234.567.8-011.000',
                'credit_limit' => 50000000,
                'payment_term_id' => 1,
            ],
            [
                'code' => 'BP-CUS-002',
                'name' => 'CV Pelanggan Makmur',
                'type' => 'customer',
                'email' => 'cs@pelanggan.com',
                'phone' => '021-555222',
                'tax_id' => '01.888.123.6-022.000',
                'credit_limit' => 30000000,
                'payment_term_id' => 1,
            ],
        ];

        // === SAMPLE VENDORS ===
        $vendors = [
            [
                'code' => 'BP-SUP-001',
                'name' => 'PT Supplier Abadi',
                'type' => 'vendor',
                'email' => 'sales@supplier.com',
                'phone' => '021-444111',
                'tax_id' => '02.123.567.8-099.000',
                'credit_limit' => 70000000,
                'payment_term_id' => 1,
            ],
            [
                'code' => 'BP-SUP-002',
                'name' => 'CV Bahan Mentah Jaya',
                'type' => 'vendor',
                'email' => 'purchasing@bmj.com',
                'phone' => '021-444222',
                'tax_id' => '02.888.111.3-055.000',
                'credit_limit' => 40000000,
                'payment_term_id' => 1,
            ],
        ];

        // === SAMPLE BOTH TYPE ===
        $both = [
            [
                'code' => 'BP-BOTH-001',
                'name' => 'PT Multi Usaha',
                'type' => 'both',
                'email' => 'info@multiusaha.com',
                'phone' => '021-666111',
                'tax_id' => '03.999.777.6-044.000',
                'credit_limit' => 90000000,
                'payment_term_id' => 1,
            ],
        ];

        $allBP = array_merge($customers, $vendors, $both);

        foreach ($allBP as $bpData) {

            // Create BP
            $bp = BusinessPartner::create($bpData);

            // Create Accounting Setup
            BPAccounting::create([
                'business_partner_id' => $bp->id,
                'ar_account_id' => $ar ? $ar->id : null,
                'ap_account_id' => $ap ? $ap->id : null,
            ]);

            // Create Contact
            BPContact::create([
                'business_partner_id' => $bp->id,
                'name' => 'Admin Office',
                'phone'  => $bp->phone,
                'email'  => $bp->email,
            ]);

            // Create Address
            BPAddress::create([
                'business_partner_id' => $bp->id,
                'address_line1' => 'Jl. Raya Industri No. 12',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
            ]);
        }

        echo "Business Partners seeded successfully.\n";
    }
}
