<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProductMainImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductMainImgController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'main_image'=>'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $path = $this->addPic($request,'main_img','product_main_img');

        $main_img=ProductMainImg::create([
            'path'=>$path,
            'product_id'=>$request->product_id
        ]);
    }
}
