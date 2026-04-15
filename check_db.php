<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;

echo "=== MENUS ===" . PHP_EOL;
$menus = Menu::all();
foreach ($menus as $m) {
    echo "ID:{$m->id} | {$m->name} | price_numeric:{$m->price_numeric}" . PHP_EOL;
}

echo PHP_EOL . "=== ORDERS ===" . PHP_EOL;
$orders = Order::all();
foreach ($orders as $o) {
    echo "Order #{$o->id} | {$o->customer_name} | total:{$o->total_price}" . PHP_EOL;
}

echo PHP_EOL . "=== ORDER ITEMS ===" . PHP_EOL;
$items = OrderItem::all();
foreach ($items as $i) {
    echo "Item #{$i->id} | order_id:{$i->order_id} | menu_id:{$i->menu_id} | qty:{$i->quantity} | price:{$i->price}" . PHP_EOL;
}
echo PHP_EOL . "Total items: " . $items->count() . PHP_EOL;
