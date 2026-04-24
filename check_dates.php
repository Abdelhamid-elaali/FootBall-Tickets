<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$matches = App\Models\FootballMatch::all(['id', 'match_date']);
echo json_encode($matches);
