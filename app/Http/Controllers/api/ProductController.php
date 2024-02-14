<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
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

        $product = Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'user_id'=>$request->user_id
        ]);

        return $this->apiResponse($product,'Product created successfully',201);
    }

    public function index(){
        $products = Product::all();
        if($products->isEmpty()){
            return $this->apiResponse(null,'Products not found',404);
        }
        return $this->apiResponse($products,'Products retrieved successfully',200);
    }

    public function show($id){
        $product = Product::find($id);
        if($product === null){
            return $this->apiResponse(null,'Product not found',404);
        }
        return $this->apiResponse($product,'Product retrieved successfully',200);
    }
    public function update(Request $request){
        $product = Product::find($request->id);

        if($product === null){
            return $this->apiResponse(null,'Product not found',404);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'price'=>'required|numeric',
            'description'=>'required|string',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $product->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
        ]);

        $updated_voucher = Product::find($request->id);

        return $this->apiResponse($updated_voucher,'Product updated successfully',200);
    }
    public function delete(Request $request){
        $product = Product::find($request->id);
        if($product === null){
            return $this->apiResponse(null,'Product not found',404);
        }
        $product->delete();
        return $this->apiResponse(null,'Product deleted successfully');
    }
}
