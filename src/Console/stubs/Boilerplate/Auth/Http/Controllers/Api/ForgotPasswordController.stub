<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;  
use App\Services\Auth\ForgotPasswordService; 
use Illuminate\Http\Request;

class ForgotPasswordController extends BaseController
{

    /**
     * @var $forgotPasswordService
     */
    protected $forgotPasswordService;

    /**
     * ForgotPasswordController constructor. 
     * 
     * @param ForgotPasswordService $forgotPasswordService
     */
    public function __construct(ForgotPasswordService $forgotPasswordService)
    {
        $this->forgotPasswordService = $forgotPasswordService;
    }

    /**
     * forgotPassword api
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/forgot-password",
     *      tags={"Auth"},
     *      summary="Forgot Password",
     *      operationId="forgotPassword",
     *
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ), 
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ), 
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="We can't find a user with that email address."),
     *          )
     *      ), 
     * )
     **/
    public function forgotPassword(Request $request)
    {
        return $this->forgotPasswordService->forgotPassword($request);
    } 
     

}
