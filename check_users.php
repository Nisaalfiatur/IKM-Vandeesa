<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = \Illuminate\Support\Facades\DB::table('users')->get();
echo "=== USERS IN DATABASE ===\n";
echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n=== TABLE COLUMNS ===\n";
$columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');
echo json_encode($columns, JSON_PRETTY_PRINT);
