<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('order');
    }
    
    public function success($id)
    {
        $order = Order::with('orderItems.menu')->findOrFail($id);
        return view('success', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'address' => 'required|string',
            'note' => 'nullable|string',
            'items' => 'required|array',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $totalPrice = 0;
        foreach ($request->items as $item) {
            $menu = Menu::find($item['menu_id']);
            $totalPrice += $menu->price_numeric * $item['quantity'];
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'whatsapp' => $request->whatsapp,
            'address' => $request->address,
            'note' => $request->note,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        foreach ($request->items as $item) {
            $menu = Menu::find($item['menu_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $menu->price_numeric
            ]);
        }

        // Load relationships for notification
        $order->load('orderItems.menu');

        // Send WhatsApp notification
        $this->sendWhatsAppNotification($order);

        // Return JSON response with order ID for redirect
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'order_id' => $order->id,
            'redirect_url' => route('order.success', $order->id)
        ]);
    }

    private function sendWhatsAppNotification($order)
    {
        $message = "Pesanan Baru! #{$order->id}\n\n";
        $message .= "Nama: {$order->customer_name}\n";
        $message .= "No WhatsApp: {$order->whatsapp}\n";
        $message .= "Alamat: {$order->address}\n";
        $message .= "Catatan: {$order->note}\n\n";
        $message .= "Detail Pesanan:\n";
        
        foreach ($order->orderItems as $item) {
            $message .= "- {$item->menu->name} x {$item->quantity} = Rp. " . number_format($item->price * $item->quantity, 0, ',', '.') . "\n";
        }
        
        $message .= "\nTotal: Rp. " . number_format($order->total_price, 0, ',', '.') . "\n\n";
        $message .= "Terima kasih telah memesan di Warung Cilok Pedas Mak Pik!";

        \Log::info("WhatsApp Notification: " . $message);
    }
}