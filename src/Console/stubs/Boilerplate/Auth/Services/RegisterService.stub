<?php

namespace App\Services\Auth;

use App\Enums\CmnEnum;
use App\Http\Resources\Auth\LoginResource; 
use App\Http\Resources\Auth\UserResource;
use App\Repositories\Auth\RegisterRepository;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $registerRepository
     */
    protected $registerRepository;

    /**
     * RegisterService constructor. 
     * 
     * @param RegisterRepository $registerRepository
     */

    public function __construct(RegisterRepository $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function register($request)
    {
        $request->merge([
            'password' => Hash::make($request->password)
        ]);
        $user = $this->registerRepository->create($request);
        if($user) { 
            $result = [
                'token_type' => CmnEnum::TOKEN_TYPE,
                //'token' => auth('api')->login($user),
                'token' => $user->createToken($user->email)->plainTextToken,
                'user' => new UserResource($user)
            ];
            return $this->success(__('messages.registered'), new LoginResource($result), Response::HTTP_CREATED);
        }
        return $this->failure(__('messages.registerFailed'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}