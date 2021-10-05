<?php

namespace App\Services\Auth;

use App\Enums\CmnEnum;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Auth\RegisterResource;
use App\Http\Resources\Auth\UserResource;
use App\Repositories\Auth\LoginRepository;
use App\Repositories\Auth\RegisterRepository;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $loginRepository
     */
    protected $loginRepository;

    /**
     * LoginService constructor. 
     * 
     * @param LoginRepository $loginRepository
     */

    public function __construct(LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    public function login($request)
    {
        if($this->loginRepository->login($request)) {
            $user = Auth::user();
            $result = [
                'token_type' => CmnEnum::TOKEN_TYPE,
                //'token' => auth('api')->login($user),
                'token' => $user->createToken($user->email)->plainTextToken,
                'user' => new UserResource($user)
            ];
            return $this->success(__('messages.loggedIn'), new LoginResource($result));
        }
        return $this->failure(__('messages.loginFailed'), Response::HTTP_UNAUTHORIZED);
    }

    public function logout($request)
    {
        auth()->user()->tokens()->delete();
        //auth()->logout();
        return $this->success(__('messages.loggedOut'));
    }
    
}