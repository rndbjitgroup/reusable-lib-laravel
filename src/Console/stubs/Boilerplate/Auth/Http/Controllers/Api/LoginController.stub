<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController; 
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    /**
     * @var $loginService
     */
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    } 

    /**
     * @OA\Post(
     *  path="/login",
     *  summary="Log In",
     *  description="Login by email, password",
     *  operationId="authLogin",
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *      required={"email","password"},
     *      @OA\Property(property="email", type="string", format="email", pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$", example="admin@bjitgroup.com"),
     *      @OA\Property(property="password", type="string", format="password", example="xxxxxxxx")
     *    ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Validation error",
     *    @OA\JsonContent(
     *      @OA\Property(property="success", type="string", example=false),
     *      @OA\Property(property="message", type="string", example="The given data was invalid."),
     *      @OA\Property(
     *          property="errors",
     *          type="object",
     *          @OA\Property(
     *              property="email",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example="The email must be a valid email address.",
     *              )
     *          ),
     *          @OA\Property(
     *              property="password",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example="The password field is required.",
     *              )
     *          )
     *       )
     *     )
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *      @OA\Property(property="success", type="string", example=false),
     *      @OA\Property(property="message", type="string", example="Not authenticated!"),
     *    )
     *  )
     *  )
     */
    public function login(LoginRequest $request)
    {
        return $this->loginService->login($request);
    }

    /**
     * @OA\Post(
     *      path="/logout",
     *      tags={"Auth"},
     *      summary="Logout",
     *      operationId="logout",
     *      security={{"bearerAuth":{}}}, 
     * 
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthenticated."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ), 
     * )
     **/
    public function logout(Request $request)
    {
        return $this->loginService->logout($request);
    } 
     

}
