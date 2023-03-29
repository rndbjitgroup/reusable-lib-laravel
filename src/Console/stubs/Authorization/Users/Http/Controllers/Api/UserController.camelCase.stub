<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller; 
use App\Http\Requests\Users\UserFilterRequest;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 

class UserController extends Controller
{
    /**
     * @var $userService 
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getUserListAll",
     *      tags={"Users"},
     *      summary="Get list of User All",
     *      description="Returns list of User All",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="searchText",
     *          description="Search name or email",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ), 
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
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
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This action is unauthorized."),
     *          )
     *      ), 
     * )
     */ 
    public function index(UserFilterRequest $request)
    {
        $this->authorize('user-list');
        return $this->userService->getAll($request);
    }

    /**
     * @OA\Get(
     *      path="/users/list",
     *      operationId="getUserList",
     *      tags={"Users"},
     *      summary="Get list of User",
     *      description="Returns list of User",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="searchText",
     *          description="Search Name",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation", 
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
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This action is unauthorized."),
     *          )
     *      ),
     * )
     */
    public function list(UserFilterRequest $request)
    {
        $this->authorize('user-list');
        return $this->userService->list($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/users",
     *      operationId="storeUser",
     *      tags={"Users"},
     *      summary="Store New User",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          description="Store User",
     *          @OA\JsonContent(
     *              title="Create new user request",
     *              description="user request body",
     *              type="object",
     *              required={"name", "email", "password", "passwordConfirmation", "roles"},
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
     *              @OA\Property(
     *                  property="roles",
     *                  description="roles in array",
     *                  type="array",
     *                  @OA\Items(
     *                      title="list of Role Ids", 
     *                      type="integer",
     *                      example=1
     *                  )
     *              ),
     *          )
     *      ),
     * 
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=true),
     *              @OA\Property(property="message", type="string", example="The data is stored successfully！"),
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id", 
     *                      type="integer",  
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="name", 
     *                      type="integer",  
     *                      example="Mr. X"
     *                  ),
     *                  @OA\Property(
     *                      property="email", 
     *                      type="email",  
     *                      example="example@bjitgroup.com"
     *                  ),
     *                  @OA\Property(
     *                      property="roles",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example={"id": 1, "title": "admin", "displayTitle": "Admin"},
     *                      )
     *                  )
     *              )
     *          )
     *      ), 
     * 
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
     */
    public function store(UserStoreRequest $request)
    {
        return $this->userService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="getUserById",
     *      tags={"Users"},
     *      summary="Return specific User",
	 * 		security={{"bearerAuth": {}}},
     *
	 * 		@OA\Parameter(
     *          name="id",
     *          description="User Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
	 *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
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
     * )
     */
    public function show(User $user)
    {
        $this->authorize('user-view');
        return $this->userService->get($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update existing User",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ), 
     *      @OA\RequestBody(
     *          required=true,
     *          description="Update User",
     *          @OA\JsonContent(
     *              title="Create new user request",
     *              description="user request body",
     *              type="object",
     *              required={"name", "email", "password", "passwordConfirmation", "roles"},
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
     *              @OA\Property(
     *                  property="roles",
     *                  description="roles in array",
     *                  type="array",
     *                  @OA\Items(
     *                      title="list of Role Ids", 
     *                      type="integer",
     *                      example=1
     *                  )
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=true),
     *              @OA\Property(property="message", type="string", example="The data is updated successfully！"),
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id", 
     *                      type="integer",  
     *                      example=1
     *                  ),
     *                  @OA\Property(
     *                      property="name", 
     *                      type="integer",  
     *                      example="Mr. X"
     *                  ),
     *                  @OA\Property(
     *                      property="email", 
     *                      type="email",  
     *                      example="example@bjitgroup.com"
     *                  ),
     *                  @OA\Property(
     *                      property="roles",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example={"id": 1, "title": "admin", "displayTitle": "Admin"},
     *                      )
     *                  )
     *              )
     *          )
     *      ), 
     * 
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
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        return $this->userService->update($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Delete existing User",
     *      description="Deletes a record and returns content",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="User Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200, 
     *          description="Successful operation",
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
     * )
     */
    public function destroy(User $user)
    {
        $this->authorize('user-delete');
        return $this->userService->destroy($user);
    }
 
 
}
