<?php

namespace App\Http\Controllers\Api\Samples;

use App\Http\Controllers\Api\BaseController;  
use App\Http\Requests\Samples\SampleFilterRequest;
use App\Http\Requests\Samples\SampleStoreRequest;
use App\Http\Requests\Samples\SampleUpdateRequest; 
use App\Models\Samples\Sample;
use App\Services\Samples\SampleService; 

class SampleController extends BaseController
{
    /**
     * @var $sampleService 
     */
    protected $sampleService;

    public function __construct(SampleService $sampleService)
    {
        $this->sampleService = $sampleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    // FN : getAll
    /**
     * @OA\Get(
     *      path="/samples",
     *      operationId="getSampleListAll",
     *      tags={"Samples"},
     *      summary="Get list of Samples All",
     *      description="Returns list of Samples All",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="lang",
     *         in="header",
     *         description="Set language parameter by short code like en/ja/bn",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="searchText",
     *          description="Search Name, Detail",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="Start index for paging",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              default=""
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
     *      @OA\Response(
     *          response=405,
     *          description="Method Not Allowed",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This HTTP method is not allowed. Please select the appropriate option"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Ops! Internal Server Errors"),
     *          )
     *      ), 
     * )
     */ 

    public function index(SampleFilterRequest $request)
    {
        return $this->sampleService->getAll($request);
    }


    // FN : list
    /**
     * @OA\Get(
     *      path="/samples/list",
     *      operationId="getSampleList",
     *      tags={"Samples"},
     *      summary="Get list of Samples",
     *      description="Returns list of Samples",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         name="lang",
     *         in="header",
     *         description="Set language parameter by short code like en/ja/bn",
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
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
     *      @OA\Response(
     *          response=405,
     *          description="Method Not Allowed",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This HTTP method is not allowed. Please select the appropriate option"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Ops! Internal Server Errors"),
     *          )
     *      ), 
     * )
     */

    public function list(SampleFilterRequest $request)
    {
        return $this->sampleService->list($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     // FN: store 
    /**
     * @OA\Post(
     *     path="/samples",
     *      operationId="storeSample",
     *      tags={"Samples"},
     *      summary="Store New Sample",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *         name="lang",
     *         in="header",
     *         description="Set language parameter by short code like en/ja/bn",
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          description="Create the sample",
     *          @OA\JsonContent(
     *              title="Create new sample request",
     *              description="sample request body",
     *              type="object",
     *              required={"name", "detail"},
     *              @OA\Property(
     *                  property="name",
     *                  description="Name of User",
     *                  example="Sample Name 101",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="detail",
     *                  description="Detail",
     *                  example="detail 101",
     *                  type="string"
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
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Not Found With Given URL"),
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
     *      @OA\Response(
     *          response=405,
     *          description="Method Not Allowed",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This HTTP method is not allowed. Please select the appropriate option"),
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
     *                  ) 
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Ops! Internal Server Errors"),
     *          )
     *      ), 
     * )
     */

    public function store(SampleStoreRequest $request)
    {
        return $this->sampleService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Samples\Sample  $sample
     * @return \Illuminate\Http\Response
     */

    // FN : show
    /**
     * @OA\Get(
     *      path="/samples/{id}",
     *      operationId="getSampleById",
     *      tags={"Samples"},
     *      summary="Return specific Sample",
	 * 		security={{"bearerAuth": {}}},
     *
     *      @OA\Parameter(
     *         name="lang",
     *         in="header",
     *         description="Set language parameter by short code like en/ja/bn",
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
	 * 		@OA\Parameter(
     *          name="id",
     *          description="Sample Id",
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
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Not Found With Given URL"),
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
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="ID is not found."),
     *          )
     *      ), 
     *      @OA\Response(
     *          response=405,
     *          description="Method Not Allowed",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This HTTP method is not allowed. Please select the appropriate option"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Ops! Internal Server Errors"),
     *          )
     *      ), 
     * )
     */

    public function show(Sample $sample)
    {
        return $this->sampleService->get($sample);
    }

    // FN : showCommon
    /**
     * @OA\Get(
     *      path="/samples/show-common-arr/{id}",
     *      operationId="getCommonArrById",
     *      tags={"Samples"},
     *      summary="Return specific array data",
	 * 		security={{"bearerAuth": {}}},
     *
     *      @OA\Parameter(
     *         name="lang",
     *         in="header",
     *         description="Set language parameter by short code like en/ja/bn",
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     * 
	 * 		@OA\Parameter(
     *          name="id",
     *          description="Sample Id",
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
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Not Found With Given URL"),
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
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="ID is not found."),
     *          )
     *      ), 
     *      @OA\Response(
     *          response=405,
     *          description="Method Not Allowed",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This HTTP method is not allowed. Please select the appropriate option"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Ops! Internal Server Errors"),
     *          )
     *      ), 
     * )
     */

    public function showCommon(Sample $sample)
    {
        return $this->sampleService->getCommon($sample);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Samples\Sample  $sample
     * @return \Illuminate\Http\Response
     */


    

    // FN : update
    /**
     * @OA\Put(
     *     path="/samples/{id}",
     *      operationId="updateSample",
     *      tags={"Samples"},
     *      summary="Update existing Sample",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *         name="lang",
     *         in="header",
     *         description="Set language parameter by short code like en/ja/bn",
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     * 
     *      @OA\Parameter(
     *          name="id",
     *          description="Sample ID",
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
     *          description="Update the sample",
     *          @OA\JsonContent(
     *              title="Create new sample request",
     *              description="sample request body",
     *              type="object",
     *              required={"name", "detail"},
     *              @OA\Property(
     *                  property="name",
     *                  description="Name of User",
     *                  example="Sample Name 101",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="detail",
     *                  description="Detail",
     *                  example="detail 101",
     *                  type="string"
     *              ) 
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response="200",
     *          description="Success(Updated)",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Not Found With Given URL"),
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
     *      @OA\Response(
     *          response=405,
     *          description="Method Not Allowed",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This HTTP method is not allowed. Please select the appropriate option"),
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
     *                  ) 
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Ops! Internal Server Errors"),
     *          )
     *      ), 
     * )
     */

   


    public function update(SampleUpdateRequest $request, Sample $sample)
    {
        return $this->sampleService->update($request, $sample);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Samples\Sample  $sample
     * @return \Illuminate\Http\Response
     */


    // FN : delete
    /**
     * @OA\Delete(
     *      path="/samples/{id}",
     *      operationId="deleteSample",
     *      tags={"Samples"},
     *      summary="Delete existing Sample",
     *      description="Deletes a record and returns no content",
     *      security={{"bearerAuth": {}}},
     * 
     *      @OA\Parameter(
     *         name="lang",
     *         in="header",
     *         description="Set language parameter by short code like en/ja/bn",
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     * 
     *      @OA\Parameter(
     *          name="id",
     *          description="Sample Id",
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
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Not Found With Given URL"),
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
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="ID is not found."),
     *          )
     *      ), 
     *      @OA\Response(
     *          response=405,
     *          description="Method Not Allowed",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="This HTTP method is not allowed. Please select the appropriate option"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Errors",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="string", example=false),
     *              @OA\Property(property="message", type="string", example="Ops! Internal Server Errors"),
     *          )
     *      ), 
     * )
     */

    public function destroy(Sample $sample)
    {
        return $this->sampleService->destroy($sample);
    } 

}
