<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'price'=>'required|numeric',
            'description'=>'required|string',
            'user_id'=>'required|exists:users'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $order = Order::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'user_id'=>$request->user_id
        ]);
        return $this->apiResponse($order,'Order created successfully',201);
    }

    public function index(){
        $orders = Order::all();
        if($orders->isEmpty()){
            return $this->apiResponse(null,'Orders not found',404);
        }
        return $this->apiResponse($orders,'Orders retrieved successfully',200);
    }

    public function show($id){
        $order = Order::find($id);
        if($order === null){
            return $this->apiResponse(null,'Order not found',404);
        }
        return $this->apiResponse($order,'Order retrieved successfully',200);
    }
    public function delete(Request $request){
        $order = Order::find($request->id);
        if($order === null){
            return $this->apiResponse(null,'Order not found',404);
        }
        $order->delete();
        return $this->apiResponse(null,'Order deleted successfully');
    }
}
