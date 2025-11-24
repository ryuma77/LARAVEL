<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

try {
      DB::beginTransaction();

      // Create Permission
      $permName = 'inventory.view';
      $permission = Permission::firstOrCreate(
            ['name' => $permName],
            ['label' => 'View Inventory']
      );
      echo "Permission ensured: {$permission->name}\n";

      // Create Role
      $role = Role::firstOrCreate(['name' => 'tester'], ['label' => 'Tester']);
      // Attach permission if not exists
      if (!$role->permissions()->where('name', $permName)->exists()) {
            $role->permissions()->attach($permission);
            echo "Permission attached to role.\n";
      }

      // Create User
      $user = User::firstOrCreate(
            ['email' => 'test_permission@example.com'],
            [
                  'name' => 'Test User',
                  'password' => Hash::make('password'),
                  'role_id' => $role->id
            ]
      );
      echo "User ensured: {$user->email} (Role ID: {$user->role_id})\n";

      Auth::login($user);
      echo "Logged in as user ID: {$user->id}\n";

      // Test hasPermission directly
      $has = $user->hasPermission($permName);
      echo "Direct check - hasPermission('$permName'): " . ($has ? 'Yes' : 'No') . "\n";

      // Test Middleware Logic manually
      $middleware = new \App\Http\Middleware\CheckPermission();
      $request = Illuminate\Http\Request::create('/test-permission', 'GET');

      $response = $middleware->handle($request, function ($req) {
            return new Illuminate\Http\Response('Middleware passed');
      }, $permName);

      echo "Middleware result: " . $response->getContent() . "\n";

      DB::rollBack(); // Rollback to not pollute DB
      echo "Test completed successfully (Changes rolled back).\n";
} catch (\Throwable $e) {
      DB::rollBack();
      echo "Error: " . $e->getMessage() . "\n";
      echo "File: " . $e->getFile() . "\n";
      echo "Line: " . $e->getLine() . "\n";
      echo "Trace: " . $e->getTraceAsString() . "\n";
}
