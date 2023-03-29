<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\Blogs\Post;
use App\Services\Profile\ProfileService; 
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var $profileService 
     */
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
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
     *      path="/update-profile",
     *      operationId="updateProfile",
     *      tags={"Profile"},
     *      summary="Update Profile",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody( 
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema( 
     *                  required={"name", "email", "contactNo"}, 
     *                  @OA\Property(
     *                      property="photo",
     *                      type="file",
     *                      description="Uplaod a image",
     *                  ), 
     *                  @OA\Property(
     *                      property="name",
     *                      description="Name",
     *                      example="Mr. X",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      description="Email",
     *                      example="example@bjitgroup.com",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="contactNo",
     *                      description="Contact No",
     *                      example="01xxxxxxxxx",
     *                      type="string"
     *                  )  
     *              )
     *          )
     *      ),     
     *  
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
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Unauthenticated."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This action is unauthorized."),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="ID is not found."),
     *          )
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
     *                      property="name",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The name field is required.",
     *                      )
     *                  ), 
     *              )
     *          )
     *      ),
     * )
     */    
    public function update(ProfileUpdateRequest $request)
    {
        return $this->profileService->update($request);
    }
    

    

}
