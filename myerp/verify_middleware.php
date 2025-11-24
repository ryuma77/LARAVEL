try {
$permName = 'inventory.view';
$permission = App\Models\Permission::firstOrCreate(
['name' => $permName],
['label' => 'View Inventory']
);

$role = App\Models\Role::firstOrCreate(['name' => 'tester'], ['label' => 'Tester']);
if (!$role->permissions()->where('name', $permName)->exists()) {
$role->permissions()->attach($permission);
}

$user = App\Models\User::firstOrCreate(
['email' => 'test_permission@example.com'],
[
'name' => 'Test User',
'password' => Illuminate\Support\Facades\Hash::make('password'),
'role_id' => $role->id
]
);

Illuminate\Support\Facades\Auth::login($user);
echo "Logged in as: " . Illuminate\Support\Facades\Auth::user()->email . PHP_EOL;

$middleware = new App\Http\Middleware\CheckPermission();
$request = Illuminate\Http\Request::create('/test-permission', 'GET');

$response = $middleware->handle($request, function ($req) {
return new Illuminate\Http\Response('Middleware passed');
}, $permName);

echo "Result: " . $response->getContent() . PHP_EOL;

} catch (\Throwable $e) {
echo "Error: " . $e->getMessage() . PHP_EOL;
echo "Trace: " . $e->getTraceAsString() . PHP_EOL;
}
exit;