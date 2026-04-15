<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;

try {
    $menu = Menu::first();
    if (!$menu) {
        die("No menus found. Please add a menu first.\n");
    }

    $order = Order::create([
        'customer_name' => 'Test User',
        'whatsapp' => '+628123456789',
        'address' => 'Test Address',
        'total_price' => $menu->price_numeric,
        'status' => 'pending'
    ]);

    $item = OrderItem::create([
        'order_id' => $order->id,
        'menu_id' => $menu->id,
        'quantity' => 1,
        'price' => $menu->price_numeric
    ]);

    echo "Order created with ID: " . $order->id . "\n";
    echo "OrderItem created with ID: " . $item->id . "\n";
    
    $checkOrder = Order::with('orderItems')->find($order->id);
    echo "Items count for this order: " . $checkOrder->orderItems->count() . "\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
