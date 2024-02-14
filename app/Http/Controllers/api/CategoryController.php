<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $category = Category::create([
            'name'=>$request->name,
            'admin_id'=>auth()->user()->id
        ]);

        return $this->apiResponse($category,'Category created successfully',201);
    }

    public function index(){
        $categories = Category::all();

        if($categories->isEmpty()){
            return $this->apiResponse(null,'Categories not found',404);
        }

        return $this->apiResponse($categories,'Categories retrieved successfully',200);
    }

    public function show($id){
        $category = Category::find($id);

        if($category === null){
            return $this->apiResponse(null,'Category not found',404);
        }

        return $this->apiResponse($category,'Category retrieved successfully',200);
    }
    public function update(Request $request){
        $category = Category::find($request->id);

        if($category === null){
            return $this->apiResponse(null,'Category not found',404);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $category->update([
            'name'=>$request->name,
            'admin_id'=>auth()->user()->id
        ]);

        $updated_category = Category::find($request->id);

        return $this->apiResponse($updated_category,'Category updated successfully',200);
    }
    public function delete(Request $request){
        $category = Category::find($request->id);

        if($category === null){
            return $this->apiResponse(null,'Category not found',404);
        }

        $category->delete();

        return $this->apiResponse(null,'Category deleted successfully',200);
    }
}
