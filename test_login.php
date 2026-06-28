<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test login
$credentials = [
    'username' => 'admin',
    'password' => 'password'
];

$user = \App\Models\User::where('username', 'admin')->first();

echo "=== USER LOOKUP ===\n";
echo "Found user: " . ($user ? $user->username . " (ID: " . $user->id_user . ", Role: " . $user->role . ")" : "NOT FOUND") . "\n\n";

if ($user) {
    echo "=== PASSWORD VERIFICATION ===\n";
    $matches = \Illuminate\Support\Facades\Hash::check('password', $user->password);
    echo "Password matches: " . ($matches ? "YES ✓" : "NO ✗") . "\n\n";

    echo "=== AUTH ATTEMPT ===\n";
    $auth = \Illuminate\Support\Facades\Auth::attempt($credentials);
    echo "Auth attempt result: " . ($auth ? "SUCCESS ✓" : "FAILED ✗") . "\n";

    if ($auth) {
        echo "Authenticated user: " . \Illuminate\Support\Facades\Auth::user()->username . "\n";
    }
}
