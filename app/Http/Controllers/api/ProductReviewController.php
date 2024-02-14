<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductReviewController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'content'=>'required|string',
            'rate' => 'required|integer|between:1,5',
            'product_id'=>'required|exists:products'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $product_reviews = ProductReview::create([
            'content'=>$request->feedback,
            'rate'=>$request->rate,
            'user_id'=>auth()->user()->id,
            'product_id'=>$request->product_id
        ]);

        return $this->apiResponse($product_reviews,'Product Review created successfully',201);
    }

    public function index(){
        $product_reviews = ProductReview::all();

        if($product_reviews->isEmpty()){
            return $this->apiResponse(null,'Product Reviews not found',404);
        }

        return $this->apiResponse($product_reviews,'Product Reviews retrieved successfully',200);
    }

    public function show($id){
        $product_review = ProductReview::find($id);

        if($product_review === null){
            return $this->apiResponse(null,'Product Review not found',404);
        }

        return $this->apiResponse($product_review,'Product Review retrieved successfully',200);
    }
    public function update(Request $request){
        $product_review = ProductReview::find($request->id);

        if($product_review === null){
            return $this->apiResponse(null,'Product Review not found',404);
        }

        $validator = Validator::make($request->all(),[
            'content'=>'required|string',
            'rate' => 'required|integer|between:1,5',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $product_review->update([
            'content'=>$request->feedback,
            'rate'=>$request->rate
        ]);

        $updated_product_review = ProductReview::find($request->id);

        return $this->apiResponse($updated_product_review,'Product Review updated successfully',200);
    }
    public function delete(Request $request){
        $product_review = ProductReview::find($request->id);

        if($product_review === null){
            return $this->apiResponse(null,'Product Review not found',404);
        }

        $product_review->delete();

        return $this->apiResponse(null,'Product Review deleted successfully');
    }
}
