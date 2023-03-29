<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Services\Profile\ChangePasswordService; 
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    /**
     * @var $changePasswordService 
     */
    protected $changePasswordService;

    public function __construct(ChangePasswordService $changePasswordService)
    {
        $this->changePasswordService = $changePasswordService;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *      path="/change-password",
     *      tags={"Profile"},
     *      summary="Change Password",
     *      operationId="changePassword",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Success",
     *          @OA\JsonContent(
     *              title="Change Password request",
     *              description="Change Password request body",
     *              type="object",
     *              required={"currentPassword", "newPassword", "newPasswordConfirmation"},
     *              @OA\Property(
     *                  property="currentPassword",
     *                  description="Current Password",
     *                  example="xxxxxxxx",
     *                  type="password"
     *              ),
     *              @OA\Property(
     *                  property="newPassword",
     *                  description="New Password",
     *                  example="xxxxxxxx",
     *                  type="password"
     *              ),
     *              @OA\Property(
     *                  property="newPasswordConfirmation",
     *                  description="New Password Confirmation",
     *                  example="xxxxxxxx",
     *                  type="password"
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
     *                      property="password",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The new password field is required.",
     *                      )
     *                  )
     *              )
     *          )
     *      ), 
     * )
     **/
    public function update(ChangePasswordRequest $request)
    {
        return $this->changePasswordService->update($request);
    }
    

}
