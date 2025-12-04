\App\Models\User::factory()->create([
    'name' => 'Admin User',
    'email' => 'admin@nachu.com',
    'phone' => '9876543210',
    'role' => 'admin',
    'password' => bcrypt('password'),
]);

\App\Models\User::factory()->create([
    'name' => 'Warden Smith',
    'email' => 'warden@nachu.com',
    'role' => 'warden',
    'password' => bcrypt('password'),
]);