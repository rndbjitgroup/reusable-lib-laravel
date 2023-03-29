<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductCategoryFilterRequest;
use App\Http\Requests\Products\ProductCategoryStoreRequest;
use App\Http\Requests\Products\ProductCategoryUpdateRequest;
use App\Models\Products\ProductCategory;
use App\Services\Products\ProductCategoryService;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * @var $productCategoryService 
     */
    protected $productCategoryService;

    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Get(
     *      path="/product-categories",
     *      operationId="getProductCategoryListAll",
     *      tags={"Centralized Multiple Files"},
     *      summary="Get list of Product Category All",
     *      description="Returns list of Product Category All",
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
    public function index(ProductCategoryFilterRequest $request)
    {
        $this->authorize('product-category-list');
        return $this->productCategoryService->getAll($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Post(
     *      path="/product-categories",
     *      operationId="storeProductCategory",
     *      tags={"Centralized Multiple Files"},
     *      summary="Store New Product Category",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\RequestBody( 
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"filename","title"}, 
     *                  @OA\Property(
     *                      property="filename",
     *                      type="file",
     *                      description="Uplaod a file",
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      description="Title",
     *                      example="This is the test title 101",
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
    public function store(ProductCategoryStoreRequest $request)
    {
        return $this->productCategoryService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/product-categories/{slug}",
     *      operationId="getProductCategoryById",
     *      tags={"Centralized Multiple Files"},
     *      summary="Return specific Product Category",
	 * 		security={{"bearerAuth": {}}},
     *
	 * 		@OA\Parameter(
     *          name="slug",
     *          description="Pass Product Category Slug",
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
    public function show(ProductCategory $productCategory)
    {
        $this->authorize('product-category-view');
        return $this->productCategoryService->get($productCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
  
    /**
     * @OA\Post(
     *      path="/product-categories/{id}",
     *      operationId="updateProductCategory",
     *      tags={"Centralized Multiple Files"},
     *      summary="Update Product Category",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *          name="id",
     *          description="Product Category Id",
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
     *                      property="filename",
     *                      type="file",
     *                      description="Uplaod a file",
     *                  ), 
     *                  @OA\Property(
     *                      property="existing_filename",
     *                      description="Existing Filename",
     *                      example="",
     *                      type="string"
     *                  ), 
     *                  @OA\Property(
     *                      property="title",
     *                      description="Title",
     *                      example="This is the test title 101",
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
    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        return $this->productCategoryService->update($request, $productCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
 
    /**
     * @OA\Delete(
     *      path="/product-categories/{id}",
     *      operationId="deleteProductCategory",
     *      tags={"Centralized Multiple Files"},
     *      summary="Delete existing Product Category",
     *      description="Deletes a record and returns content",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product Category Id",
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
    public function destroy(ProductCategory $productCategory)
    {
        $this->authorize('product-category-delete');
        return $this->productCategoryService->destroy($productCategory);
    }

 
}
