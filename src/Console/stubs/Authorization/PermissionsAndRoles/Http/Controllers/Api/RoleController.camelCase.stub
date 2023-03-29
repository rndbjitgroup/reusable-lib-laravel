<?php

namespace App\Http\Controllers\Api\PermissionsAndRoles;

use App\Http\Controllers\Controller; 
use App\Http\Requests\PermissionsAndRoles\RoleFilterRequest;
use App\Http\Requests\PermissionsAndRoles\RoleStoreRequest;
use App\Http\Requests\PermissionsAndRoles\RoleUpdateRequest; 
use App\Models\PermissionsAndRoles\Role;
use App\Services\PermissionsAndRoles\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 

class RoleController extends Controller
{
    /**
     * @var $roleService 
     */
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * @OA\Get(
     *      path="/roles",
     *      operationId="getRoleListAll",
     *      tags={"PermissionsAndRoles"},
     *      summary="Get list of Role All",
     *      description="Returns list of Role All",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="searchText",
     *          description="Search displayTitle",
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
    public function index(RoleFilterRequest $request)
    { 
        $this->authorize('role-list');
        return $this->roleService->getAll($request);
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/roles",
     *      operationId="storeRole",
     *      tags={"PermissionsAndRoles"},
     *      summary="Store New Role",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\RequestBody( 
     *          required=true,
     *          description="Create the role",
     *          @OA\JsonContent(
     *              title="Create new role request",
     *              description="role request body",
     *              type="object",
     *              required={"displayTitle", "permissions"},
     *              @OA\Property(
     *                  property="displayTitle",
     *                  description="Title of the role",
     *                  example="Manager",
     *                  type="string"
     *              ), 
     *              @OA\Property(
     *                  property="permissions",
     *                  description="permissions in array",
     *                  type="array",
     *                  @OA\Items(
     *                      title="list of Permissions Ids", 
     *                      type="integer",
     *                      example=1
     *                  )
     *              ),
     *          ),
     *      ), 
     * 
     *      @OA\Response(
     *          response=201,
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
     *          response=422,
     *          description="Unprocessable Entity(Validation errors)",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(
     *                      property="displayTitle",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The display title field is required.",
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="permissions",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The permissions field is required.",
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     * )
     */
    public function store(RoleStoreRequest $request)
    {
        return $this->roleService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/roles/{id}",
     *      operationId="getRoleById",
     *      tags={"PermissionsAndRoles"},
     *      summary="Return specific Role",
	 * 		security={{"bearerAuth": {}}},
     *
	 * 		@OA\Parameter(
     *          name="id",
     *          description="Role Id",
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
    public function show(Role $role)
    {
        $this->authorize('role-view');
        return $this->roleService->get($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Put(
     *     path="/roles/{id}",
     *      operationId="updateRole",
     *      tags={"PermissionsAndRoles"},
     *      summary="Update existing Role",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *          name="id",
     *          description="Role ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ), 
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          description="Update the role",
     *          @OA\JsonContent(
     *              title="Update the role request",
     *              description="role request body",
     *              type="object",
     *              required={"displayTitle", "permissions"},
     *              @OA\Property(
     *                  property="displayTitle",
     *                  description="Title of the role",
     *                  example="Manager",
     *                  type="string"
     *              ), 
     *              @OA\Property(
     *                  property="permissions",
     *                  description="permissions in array",
     *                  type="array",
     *                  @OA\Items(
     *                      title="list of Permissions Ids", 
     *                      type="integer",
     *                      example=1
     *                  )
     *              ),
     *          ),
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
     *                      property="displayTitle",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The display title field is required.",
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="permissions",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The permissions field is required.",
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     * )
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        return $this->roleService->update($request, $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Delete(
     *      path="/roles/{id}",
     *      operationId="deleteRole",
     *      tags={"PermissionsAndRoles"},
     *      summary="Delete existing Role",
     *      description="Deletes a record and returns content",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Role Id",
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
    public function destroy(Role $role)
    {
        $this->authorize('role-delete');
        return $this->roleService->destroy($role);
    }

 
}
