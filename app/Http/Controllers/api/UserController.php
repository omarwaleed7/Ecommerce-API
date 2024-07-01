<?php

namespace App\Http\Controllers\api;

use App\Contracts\BaseServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    protected BaseServiceInterface $baseService;
    public function __construct(BaseServiceInterface $baseService)
    {
        $this->baseService = $baseService;
    }

    /**
     * Register a new user
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle(): \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google
     *
     * @return string
     */
    public function handleGoogleCallback(): string
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

    /**
     * Update user profile
     *
     * @param UpdateUserProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateUserProfileRequest $request): JsonResponse
    {
        $user = auth()->user();

        // Check if profile picture is included
        if ($request->has('profile_picture')) {
            $user['profile_picture'] = $this->baseService->addPic($request,'profile_picture', 'profile_picture');
        }

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password' => bcrypt($request->password),
            'profile_picture'=>$user['profile_picture']
        ]);

        $updated_user = User::find(auth()->user()->id);

        return $this->apiResponse($updated_user,'User updated successfully',200);
    }

    /**
     * Delete user profile
     *
     * @return JsonResponse
     */
    public function deleteProfile(): JsonResponse
    {
        $user = auth()->user();

        $user->delete();

        return $this->baseService->apiResponse(null,'User deleted successfully',204);
    }
}
