<?php

namespace App\Http\Controllers\Api\PermissionsAndRoles;

use App\Http\Controllers\Controller; 
use App\Http\Requests\PermissionsAndRoles\PermissionFilterRequest;
use App\Http\Requests\PermissionsAndRoles\PermissionStoreRequest;
use App\Http\Requests\PermissionsAndRoles\PermissionUpdateRequest; 
use App\Models\PermissionsAndRoles\Permission;
use App\Services\PermissionsAndRoles\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 

class PermissionController extends Controller
{
    /**
     * @var $permissionService 
     */
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/permissions",
     *      operationId="getPermissionListAll",
     *      tags={"PermissionsAndRoles"},
     *      summary="Get list of Permission All",
     *      description="Returns list of Permission All",
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
    public function index(PermissionFilterRequest $request)
    {
        $this->authorize('permission-list');
        return $this->permissionService->getAll($request);
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/permissions",
     *      operationId="storePermission",
     *      tags={"PermissionsAndRoles"},
     *      summary="Store New Permission",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\RequestBody( 
     *          required=true,
     *          description = "Store Permission",
     *          @OA\JsonContent(
     *              title="Store new permission request",
     *              description="permission request body",
     *              type="object",
     *              required={"displayTitle"},
     *              @OA\Property(
     *                  property="displayTitle",
     *                  description="Display Title",
     *                  example="Post Create",
     *                  type="string"
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
     *              )
     *          )
     *      ),
     * )
     */
    public function store(PermissionStoreRequest $request)
    {
        return $this->permissionService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/permissions/{id}",
     *      operationId="getPermissionById",
     *      tags={"PermissionsAndRoles"},
     *      summary="Return specific Permission",
	 * 		security={{"bearerAuth": {}}},
     *
	 * 		@OA\Parameter(
     *          name="id",
     *          description="Permission Id",
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
    public function show(Permission $permission)
    {
        $this->authorize('permission-view');
        return $this->permissionService->get($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/permissions/{id}",
     *      operationId="updatePermission",
     *      tags={"PermissionsAndRoles"},
     *      summary="Update existing Permission",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *          name="id",
     *          description="Permission ID",
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
     *          description = "Update Permission",
     *          @OA\JsonContent(
     *              title="Store new permission request",
     *              description="permission request body",
     *              type="object",
     *              required={"displayTitle"},
     *              @OA\Property(
     *                  property="displayTitle",
     *                  description="Display Title",
     *                  example="Post Create",
     *                  type="string"
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
     *              )
     *          )
     *      ),
     * )
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        return $this->permissionService->update($request, $permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    
    /**
     * @OA\Delete(
     *      path="/permissions/{id}",
     *      operationId="deletePermission",
     *      tags={"PermissionsAndRoles"},
     *      summary="Delete existing Permission",
     *      description="Deletes a record and returns content",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Permission Id",
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
    public function destroy(Permission $permission)
    {
        $this->authorize('permission-delete');
        return $this->permissionService->destroy($permission);
    }


}
