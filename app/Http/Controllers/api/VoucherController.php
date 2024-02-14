<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'value'=>'required|numeric|between:0,100',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $voucher = Voucher::create([
            'name'=>$request->name,
            'value'=>$request->value,
            'admin_id'=>auth()->user()->id
        ]);

        return $this->apiResponse($voucher,'Voucher created successfully',201);
    }

    public function index(){
        $vouchers = Voucher::all();

        if($vouchers->isEmpty()){
            return $this->apiResponse(null,'Vouchers not found',404);
        }

        return $this->apiResponse($vouchers,'Vouchers retrieved successfully',200);
    }

    public function show($id){
        $voucher = Voucher::find($id);

        if($voucher === null){
            return $this->apiResponse(null,'Voucher not found',404);
        }

        return $this->apiResponse($voucher,'Voucher retrieved successfully',200);
    }
    public function update(Request $request){
        $voucher = Voucher::find($request->id);
        if($voucher === null){
            return $this->apiResponse(null,'Voucher not found',404);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'value'=>'required|numeric|between:1,100',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 422);
        }

        $voucher->update([
            'name'=>$request->name,
            'value'=>$request->value,
            'admin_id'=>auth()->user()->id
        ]);

        $updated_voucher = Voucher::find($request->id);

        return $this->apiResponse($updated_voucher,'Voucher updated successfully',200);
    }
    public function delete(Request $request){
        $voucher = Voucher::find($request->id);

        if($voucher === null){
            return $this->apiResponse(null,'Voucher not found',404);
        }

        $voucher->delete();

        return $this->apiResponse(null,'Voucher deleted successfully',200);
    }
}
