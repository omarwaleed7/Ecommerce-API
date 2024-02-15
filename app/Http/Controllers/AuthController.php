<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\pictureTrait;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use pictureTrait;
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|confirmed',
            'profile_picture'=>'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'phone' => 'nullable|regex:/^\+?\d{1,3}?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        if ($request->has('profile_picture')){
            $path = $this->addPic($request,'profile_picture','profile_picture');
            $userData['profile_picture'] = $path;
        }

        if($request->has('phone')){
            $userData['phone'] = $request->phone;
        }

        $user = User::create($userData);

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->plainTextToken;

        return response()->json([
                'user' => $user,
                'message' => 'Successfully created user!',
                'accessToken'=> $token,
            ],201);
        }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'user' => $user,
            'accessToken' =>$token,
            'token_type' => 'Bearer',
        ]);
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    public function refresh(Request $request)
    {
        $request->user()->tokens()->delete();

        $token = $request->user()->createToken('token-name');

        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);

    }
}
