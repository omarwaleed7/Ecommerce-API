<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use App\Traits\pictureTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    use ApiResponseTrait;
    use pictureTrait;
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        // Handle user authentication or registration here
        $existing_user=User::where('provider_id',$user->id)->first();
        if($existing_user){
            return 'User exists';
        }
        User::create([
            'name'          => $user->name,
            'email'         => $user->email,
            'provider_id'   => $user->id,
            'provide_type'      => 'google',
        ]);
        return 'logged in';
    }
    // update profile
    public function updateProfile(Request $request){
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users,email,' . auth()->user()->id,
            'password' => 'required|string|confirmed|min:6',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'phone'=>'regex:/^[0-9]{10,}$/'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors()->first(), 422);
        }

        $path = $this->addPic($request,'profile_picture','profile_picture');

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password' => bcrypt($request->password),
            'profile_picture'=>$path
        ]);

        $updated_user = User::find(auth()->user()->id);

        return $this->apiResponse($updated_user,'User updated successfully',200);
    }

    // delete profile
    public function deleteProfile(){
        $user = auth()->user();

        $user->delete();

        return $this->apiResponse(null,'User deleted successfully',204);
    }
}
