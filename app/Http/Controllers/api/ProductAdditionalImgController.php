<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProductAdditionalImg;
use App\Traits\pictureTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductAdditionalImgController extends Controller
{
    use pictureTrait;
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'additional_image'=>'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $path = $this->addPic($request,'product_additional_imgs','product_additional_img');

        $main_img=ProductAdditionalImg::create([
            'path'=>$path,
            'product_id'=>$request->product_id
        ]);
    }
}
