<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController; 
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{

    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
         
    /**
     * @OA\Post(
     *      path="/register",
     *      tags={"Auth"},
     *      summary="Register",
     *      operationId="register",
     *
     *      @OA\RequestBody(
     *          required=true,
     *          description="User Registration",
     *          @OA\JsonContent(
     *              title="Register new user request",
     *              description="user request body",
     *              type="object",
     *              required={"name", "email", "password", "passwordConfirmation"},
     *              @OA\Property(
     *                  property="name",
     *                  description="Name of User",
     *                  example="Mr. X",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="email",
     *                  description="Email (Username) of User",
     *                  example="example@bjitgroup.com",
     *                  type="email"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  description="Password of User",
     *                  example="xxxxxxxx",
     *                  type="password"
     *              ),
     *              @OA\Property(
     *                  property="passwordConfirmation",
     *                  description="Confirmation Password of User",
     *                  example="xxxxxxxx",
     *                  type="password"
     *              ), 
     *          )
     *      ),
     * 
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     * 
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ), 
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity(Validation errors)",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(
     *                      property="email",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The email must be a valid email address.",
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The password field is required.",
     *                      )
     *                  )
     *              )
     *          )
     *      ), 
     * )
     **/
    public function register(RegisterRequest $request)
    { 
        return $this->registerService->register($request);
    }
 
    
}
