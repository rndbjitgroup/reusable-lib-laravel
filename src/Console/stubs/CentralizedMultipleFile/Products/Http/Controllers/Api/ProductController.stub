<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductFilterRequest;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Products\Product;
use App\Services\Products\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var $productService 
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductFilterRequest $request)
    {
        $this->authorize('product-list');
        return $this->productService->getAll($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        return $this->productService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('product-view');
        return $this->productService->get($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        return $this->productService->update($request, $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('product-delete');
        return $this->productService->destroy($product);
    }

    // FN : getAll
    /**
     * @OA\Get(
     *      path="/products",
     *      operationId="getProductListAll",
     *      tags={"Centralized Multiple Files"},
     *      summary="Get list of Product All",
     *      description="Returns list of Product All",
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


    // FN: store 
    /**
     * @OA\Post(
     *      path="/products",
     *      operationId="storeProduct",
     *      tags={"Centralized Multiple Files"},
     *      summary="Store New Product",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\RequestBody( 
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"filenames[0]","product_category_id","title"}, 
     *                  @OA\Property(
     *                      property="filenames[0]",
     *                      type="file",
     *                      description="Uplaod a files",
     *                  ),
     *                  @OA\Property(
     *                      property="filenames[1]",
     *                      type="file",
     *                      description="Uplaod a files",
     *                  ),
     *                  @OA\Property(
     *                      property="product_category_id",
     *                      description="Product Category Id",
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
     *                      property="identifier_url",
     *                      description="Identifier URL",
     *                      example="this_is_the_test_title_101/product1",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Post description",
     *                      example="This is the test description 101",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="size",
     *                      description="Size",
     *                      example="XS/S/M/L/XL",
     *                      type="string"
     *                  ), 
     *                  @OA\Property(
     *                      property="color",
     *                      description="Color",
     *                      example="rgba(255, 0, 0, 0.5)",
     *                      type="string"
     *                  ), 
     *                  @OA\Property(
     *                      property="old_price",
     *                      description="Old Price",
     *                      example="100",
     *                      type="number"
     *                  ), 
     *                  @OA\Property(
     *                      property="price",
     *                      description="Price",
     *                      example="110",
     *                      type="number"
     *                  ), 
     *                  @OA\Property(
     *                      property="coupon",
     *                      description="Coupon",
     *                      example="BCDEF",
     *                      type="string"
     *                  ), 
     *                  @OA\Property(
     *                      property="tags[0]",
     *                      description="Tags",
     *                      example="Men",
     *                      type="string"
     *                  ),  
     *                  @OA\Property(
     *                      property="tags[1]",
     *                      description="Tags",
     *                      example="Women",
     *                      type="string"
     *                  ),  
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

    // FN : show
    /**
     * @OA\Get(
     *      path="/products/{slug}",
     *      operationId="getProductById",
     *      tags={"Centralized Multiple Files"},
     *      summary="Return specific Product",
	 * 		security={{"bearerAuth": {}}},
     *
	 * 		@OA\Parameter(
     *          name="slug",
     *          description="Pass Product Slug",
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


    // FN: update 
    /**
     * @OA\Post(
     *      path="/products/{id}",
     *      operationId="updateProduct",
     *      tags={"Centralized Multiple Files"},
     *      summary="Update Product",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *          name="id",
     *          description="Product Id",
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
     *                      property="filenames[0]",
     *                      type="file",
     *                      description="Uplaod a files",
     *                  ),
     *                  @OA\Property(
     *                      property="filenames[1]",
     *                      type="file",
     *                      description="Uplaod a files",
     *                  ),
     *                  @OA\Property(
     *                      property="product_category_id",
     *                      description="Product Category Id",
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
     *                      property="identifier_url",
     *                      description="Identifier URL",
     *                      example="this_is_the_test_title_101/product1",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Post description",
     *                      example="This is the test description 101",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="size",
     *                      description="Size",
     *                      example="XS/S/M/L/XL",
     *                      type="string"
     *                  ), 
     *                  @OA\Property(
     *                      property="color",
     *                      description="Color",
     *                      example="rgba(255, 0, 0, 0.5)",
     *                      type="string"
     *                  ), 
     *                  @OA\Property(
     *                      property="old_price",
     *                      description="Old Price",
     *                      example="100",
     *                      type="number"
     *                  ), 
     *                  @OA\Property(
     *                      property="price",
     *                      description="Price",
     *                      example="110",
     *                      type="number"
     *                  ), 
     *                  @OA\Property(
     *                      property="coupon",
     *                      description="Coupon",
     *                      example="BCDEF",
     *                      type="string"
     *                  ), 
     *                  @OA\Property(
     *                      property="tags[0]",
     *                      description="Tags",
     *                      example="Men",
     *                      type="string"
     *                  ),  
     *                  @OA\Property(
     *                      property="tags[1]",
     *                      description="Tags",
     *                      example="Women",
     *                      type="string"
     *                  ),  
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


    // FN : delete
    /**
     * @OA\Delete(
     *      path="/products/{id}",
     *      operationId="deleteProduct",
     *      tags={"Centralized Multiple Files"},
     *      summary="Delete existing Product",
     *      description="Deletes a record and returns content",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product Id",
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

}
