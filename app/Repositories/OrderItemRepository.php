<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository
{
    public function store($cartItems,$orderID): void
    {
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
                'cart_item_id' => $cartItem->id,
                'order_id' => $orderID
            ]);
        }
    }
}
