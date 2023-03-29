<?php

namespace App\Http\Controllers\Api\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blogs\CommentFilterRequest;
use App\Http\Requests\Blogs\CommentStoreReplyRequest;
use App\Http\Requests\Blogs\CommentStoreRequest;
use App\Models\Blogs\Comment;
use App\Models\Blogs\Post;
use App\Services\Blogs\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @var $commentService 
     */
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentFilterRequest $request)
    {
        $this->authorize('comment-list');
        return $this->commentService->getAll($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Post(
     *      path="/posts/{slug}/comments",
     *      operationId="storeComment",
     *      tags={"Blogs"},
     *      summary="Store Comment",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *          name="slug",
     *          description="Pass Post Slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string" 
     *          )
     *      ),
     * 
     *      @OA\RequestBody( 
     *          required=true,
     *          description = "Store Comment",
     *          @OA\JsonContent(
     *              title="Store new Comment request",
     *              description="Comment request body",
     *              type="object",
     *              required={"comment"},
     *              @OA\Property(
     *                  property="comment",
     *                  description="Comment",
     *                  example="This is the test comment 101",
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
    public function store(CommentStoreRequest $request, Post $post)
    {
        return $this->commentService->store($request, $post);
    }

    /**
     * @OA\Post(
     *      path="/posts/{slug}/comments/reply",
     *      operationId="storeCommentReply",
     *      tags={"Blogs"},
     *      summary="Store Comment Reply",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *          name="slug",
     *          description="Pass Post Slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string" 
     *          )
     *      ),
     * 
     *      @OA\RequestBody( 
     *          required=true,
     *          description = "Store Comment Reply",
     *          @OA\JsonContent(
     *              title="Store Comment Reply request",
     *              description="Comment Reply request body",
     *              type="object",
     *              required={"parentId", "comment"},
     *              @OA\Property(
     *                  property="parentId",
     *                  description="Comment Parent Id",
     *                  example=1,
     *                  type="integer"
     *              ),
     *              @OA\Property(
     *                  property="comment",
     *                  description="Comment",
     *                  example="This is the test comment reply 101",
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
    public function storeReply(CommentStoreReplyRequest $request, Post $post)
    {
        return $this->commentService->storeReply($request, $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $this->authorize('comment-view');
        return $this->commentService->get($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        return $this->commentService->update($request, $comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('comment-delete');
        return $this->commentService->destroy($comment);
    }

 
}
