<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class WishlistController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'product_id'=>'required|exists:products'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $wishlist = Wishlist::create([
            'user_id'=>auth()->user()->id,
            'product_id'=>$request->product_id
        ]);

        return $this->apiResponse($wishlist,'Wishlist item created successfully',201);
    }

    public function show($id){
        $wishlist = Wishlist::find($id);

        if($wishlist === null){
            return $this->apiResponse(null,'Wishlist item not found ',404);
        }

        return $this->apiResponse($wishlist,'Wishlist item retrieved successfully',200);
    }

    public function delete(Request $request){
        $wishlist = Wishlist::find($request->id);

        if($wishlist === null){
            return $this->apiResponse(null,'Wishlist item not found',404);
        }

        $wishlist->delete();

        return $this->apiResponse(null,'Wishlist item deleted successfully',204);
    }
}
