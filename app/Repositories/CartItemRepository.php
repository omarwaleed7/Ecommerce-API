<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartItemRepository
{
    protected BaseServiceInterface $baseService;

    protected BaseRepositoryInterface $baseRepository;
    public function __construct(BaseRepositoryInterface $baseRepository, BaseServiceInterface $baseService)
    {
        $this->baseRepository=$baseRepository;
        $this->baseService=$baseService;
    }

    /**
     * Increment the quantity of a specific cart item
     *
     * @param string $id
     */
    public function increment(string $id)
    {
        $cartItem = CartItem::find($id);

        $cartItem->quantity += 1;
        $cartItem->save();
    }
}
