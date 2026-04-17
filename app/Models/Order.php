<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_name', 'whatsapp', 'address', 'note', 'total_price', 'status', 'created_at', 'updated_at'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}