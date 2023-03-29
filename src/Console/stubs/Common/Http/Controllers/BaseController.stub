<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Common\RespondsWithHttpStatus;

/**
* @OA\Info(
*     version="1.0.0",
*     title="OpenApi Demo Documentation",
*     description="L5 Swagger OpenApi description",
*     @OA\Contact(
*         email="rnd@bjitgroup.com"
*     ),
*     @OA\License(
*         name="Apache 2.0",
*         url="http://www.apache.org/licenses/LICENSE-2.0.html"
*     )
* )
* 
* @OA\Server(
*     url=L5_SWAGGER_CONST_HOST,
*     description="Demo API Server"
* )
* 
* @OA\Schemes(format="http"),
* @OA\SecurityScheme(
*     securityScheme="bearerAuth",
*     in="header",
*     name="bearerAuth",
*     type="http",
*     scheme="bearer",
*     bearerFormat="JWT",
* ),
*
* @OA\Tag(
*     name="Projects",
*     description="API Endpoints of Projects"
* )
*/

class BaseController extends Controller
{
    use RespondsWithHttpStatus;

}
