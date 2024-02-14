<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request){
        $user = User::find(auth()->user()->id);

        if($user === null){
            return $this->apiResponse(null,'User not found');
        }

        $notification = Notification::create([
            'user_id'=>$request->user_id,
        ]);
        return $this->apiResponse($notification,'Notification created successfully',201);
    }

    public function delete(Request $request){
        $notification = Notification::find($request->id);
        if($notification === null){
            return $this->apiResponse(null,'Notification not found',404);
        }
        $notification->delete();
        return $this->apiResponse(null,'Notification deleted successfully');
    }
}
