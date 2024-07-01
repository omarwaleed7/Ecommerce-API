<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\AuthRequests\LoginUserRequest;
use App\Http\Requests\api\AuthRequests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected BaseServiceInterface $baseService;
    public function __construct(BaseServiceInterface $baseService)
    {
        $this->baseService = $baseService;
    }

    /**
     * Handle user registration.
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $userData = [
            'f_name' => $request->input('f_name'),
            'l_name' => $request->input('l_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone_number' => $request->input('phone_number'),
        ];

        // Check if profile picture is included
        if ($request->has('profile_picture')) {
            $userData['profile_picture'] = $this->baseService->addPic($request,'profile_picture', 'profile_picture');
        }

        $user = User::create($userData);

        // Generate a personal access token and get plain text
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
                'user' => $user,
                'message' => 'Successfully created user!',
                'accessToken'=> $token,
            ],201);
        }

    /**
     * Handle the login process.
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = request(['email','password']);

        // Authenticate user, return error message if failed
        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Invalid credentials'
            ],401);
        }

        $user = $request->user();

        // Generate a personal access token and get plain text
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'accessToken' =>$token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Retrieve the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    /**
     * Refresh the authentication token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        $token = $request->user()->createToken('token-name');

        return response()->json([
            'accessToken' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Logout the user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
