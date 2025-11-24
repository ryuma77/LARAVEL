<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ROLE ADMIN
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator with full access']
        );

        // 2. LIST ALL PERMISSIONS INCLUDING ACCOUNTING
        $permissions = [
            'user.manage',
            'role.manage',
            'permission.manage',
            'inventory.view',
            'inventory.manage',
            'purchase.view',
            'purchase.manage',
            'sales.view',
            'sales.manage',
            'asset.view',
            'asset.manage',
            'accounting.manage',     // <--- ini yang kamu butuhkan
        ];

        // 3. CREATE PERMISSIONS AND ASSIGN TO ADMIN ROLE
        foreach ($permissions as $perm) {

            $p = Permission::firstOrCreate(
                ['name' => $perm],
                ['label' => ucfirst(str_replace('.', ' ', $perm))]
            );

            // Assign ke role admin
            $adminRole->permissions()->syncWithoutDetaching($p->id);
        }

        // 4. USER ADMIN DEFAULT
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@erp.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('admin123'),
            ]
        );

        // 5. ASSIGN ROLE ADMIN KE USER ADMIN
        $adminUser->update([
            'role_id' => $adminRole->id
        ]);
    }
}
