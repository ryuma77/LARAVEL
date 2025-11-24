$permName = 'inventory.view';
$permission = App\Models\Permission::firstOrCreate(
['name' => $permName],
['label' => 'View Inventory']
);
echo "Permission ensured: " . $permission->name . PHP_EOL;

$role = App\Models\Role::firstOrCreate(['name' => 'tester'], ['label' => 'Tester']);
if (!$role->permissions()->where('name', $permName)->exists()) {
$role->permissions()->attach($permission);
echo "Permission attached to role." . PHP_EOL;
}

$user = App\Models\User::firstOrCreate(
['email' => 'test_permission@example.com'],
[
'name' => 'Test User',
'password' => Illuminate\Support\Facades\Hash::make('password'),
'role_id' => $role->id
]
);
echo "User ensured: " . $user->email . " (Role ID: " . $user->role_id . ")" . PHP_EOL;