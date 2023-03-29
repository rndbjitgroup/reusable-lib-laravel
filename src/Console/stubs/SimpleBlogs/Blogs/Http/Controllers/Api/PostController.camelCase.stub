<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blogs\PostFilterRequest;
use App\Http\Requests\Blogs\PostStoreRequest;
use App\Http\Requests\Blogs\PostUpdateRequest;
use App\Models\Blogs\Post;
use App\Services\Blogs\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @var $postService 
     */
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Get(
     *      path="/posts",
     *      operationId="getPostListAll",
     *      tags={"Blogs"},
     *      summary="Get list of Post All",
     *      description="Returns list of Post All",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="searchText",
     *          description="Search title",
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
    public function index(PostFilterRequest $request)
    {
        $this->authorize('post-list');
        return $this->postService->getAll($request);
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Post(
     *      path="/posts",
     *      operationId="storePost",
     *      tags={"Blogs"},
     *      summary="Store New Post",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\RequestBody( 
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"categoryId","title"}, 
     *                  @OA\Property(
     *                      property="image",
     *                      type="file",
     *                      description="Uplaod a image",
     *                  ),
     *                  @OA\Property(
     *                      property="categoryId",
     *                      description="Category Id",
     *                      example=1,
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      description="Title",
     *                      example="This is the test title 101",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="body",
     *                      description="Post Body",
     *                      example="This is the test body 101",
     *                      type="string"
     *                  ) 
     *              )
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
     *                      property="title",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The title field is required.",
     *                      )
     *                  ), 
     *              )
     *          )
     *      ),
     * )
     */
    public function store(PostStoreRequest $request)
    { 
        return $this->postService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Get(
     *      path="/posts/{slug}",
     *      operationId="getPostById",
     *      tags={"Blogs"},
     *      summary="Return specific Post",
	 * 		security={{"bearerAuth": {}}},
     *
	 * 		@OA\Parameter(
     *          name="slug",
     *          description="Pass Post Slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string" 
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
    public function show(Post $post)
    {
        $this->authorize('post-view');
        return $this->postService->get($post);
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
     *      path="/posts/{id}",
     *      operationId="updatePost",
     *      tags={"Blogs"},
     *      summary="Update Post",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *          name="id",
     *          description="Post Id",
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
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"_method"}, 
     *                  @OA\Property(
     *                      property="_method",
     *                      description="Method will always PUT",
     *                      example="PUT",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      type="file",
     *                      description="Uplaod a image",
     *                  ),
     *                  @OA\Property(
     *                      property="categoryId",
     *                      description="Category Id",
     *                      example=1,
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      description="Title",
     *                      example="This is the test title 101",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="body",
     *                      description="Post Body",
     *                      example="This is the test body 101",
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
     *                      property="title",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(
     *                          type="string",
     *                          example="The title field is required.",
     *                      )
     *                  ), 
     *              )
     *          )
     *      ),
     * )
     */    
    public function update(PostUpdateRequest $request, Post $post)
    {
        return $this->postService->update($request, $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
  
    /**
     * @OA\Delete(
     *      path="/posts/{id}",
     *      operationId="deletePost",
     *      tags={"Blogs"},
     *      summary="Delete existing Post",
     *      description="Deletes a record and returns content",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Post Id",
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
    public function destroy(Post $post)
    { 
        $this->authorize('post-delete');
        return $this->postService->destroy($post);
    }


}
