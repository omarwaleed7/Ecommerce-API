<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'product_id'=>'required|exists:products'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $cart = Cart::create([
            'user_id'=>auth()->user()->id,
            'product_id'=>$request->product_id
        ]);

        return $this->apiResponse($cart,'Cart item created successfully',201);
    }
    public function index(){
        $cart = Cart::find(auth()->user()->id);

        if($cart === null){
            return $this->apiResponse(null,'Cart items not found',404);
        }

        return $this->apiResponse($cart,'Cart items retrieved successfully',200);
    }
    public function show($id){
        $cart = Cart::find($id);

        if($cart === null){
            return $this->apiResponse(null,'Cart item not found',404);
        }

        return $this->apiResponse($cart,'Cart item retrieved successfully',200);
    }

    public function delete($id){
        $cart = Cart::find($id);

        if($cart === null){
            return $this->apiResponse(null,'Cart item not found',404);
        }

        $cart->delete();

        return $this->apiResponse(null,'Cart item deleted successfully',422);
    }
}
