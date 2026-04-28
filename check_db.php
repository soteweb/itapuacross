<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$items = \App\Models\MenuItem::all();
foreach($items as $item) {
    echo "ID: {$item->id} | Name: {$item->name} | URL: {$item->url}\n";
}
