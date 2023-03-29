<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService; 

class ResetPasswordController extends BaseController
{

    /**
     * @var $resetPasswordService
     */
    protected $resetPasswordService;

    /**
     * ResetPasswordController constructor. 
     * 
     * @param ResetPasswordService $resetPasswordService
     */
    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }

    /**
     * resetPassword api
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/reset-password",
     *      tags={"Auth"},
     *      summary="Reset Password",
     *      operationId="resetPassword",
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          description="Reset Password",
     *          @OA\JsonContent(
     *              title="Reset Password request",
     *              description="Reset Password request body",
     *              type="object",
     *              required={"email", "password", "passwordConfirmation", "token"},
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
     *              @OA\Property(
     *                  property="token",
     *                  description="Token",
     *                  example="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
     *                  type="string"
     *              ), 
     *          )
     *      ),
     * 
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=true),
     *              @OA\Property(property="message", type="string", example="Your password has been reset!"),
     *          )
     *      ), 
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
    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->resetPasswordService->resetPassword($request);
    } 
     
      
}
